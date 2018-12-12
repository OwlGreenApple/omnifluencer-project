<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use App\HistorySearch;

use Auth;

class AccountController extends Controller
{
  protected $cookie_search = "history_search";
  protected $cookie_delete = "delete_search";

  public function index(){
    return view('user.search.index');
  }

  public function igcallback($url){
    $c = curl_init();

    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_REFERER, $url);
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    $page = curl_exec($c);
    curl_close($c);
        
    $arr_res = json_decode($page,true);
    return $arr_res;
  }

  public function create_account($arr_res){
    $account = new Account;
    $account->ig_id = $arr_res["pk"];
    $account->username = $arr_res["username"];
    $account->prof_pic = $arr_res["hd_profile_pic_url_info"]["url"];
    $account->jml_following = $arr_res["following_count"];
    $account->jml_followers = $arr_res["follower_count"];
    $account->jml_post = $arr_res["media_count"];

    $url2 = "http://cmx.space/get-user-feed/".$arr_res["username"];
    $arr_res2 = $this->igcallback($url2);

    if($arr_res2!=null){
      $count = 0;
      $jmllike = 0;
      $jmlcomment = 0;
            
      foreach ($arr_res2 as $arr) {
        if($count>=6){
          break;
        } else {
          $jmllike = $jmllike + $arr["like_count"];
          if(array_key_exists('comment_count', $arr)){
            $jmlcomment = $jmlcomment + $arr["comment_count"];          
          } 
          $count++;
        }
      }

      //hitung rata2 like + comment di 6 post terakhir 
      $ratalike = $jmllike/$count;
      $ratacomment = $jmlcomment/$count;

      $account->lastpost = date("Y-m-d h:i:s",$arr_res2[0]["taken_at"]);
      $account->jml_likes = floor($ratalike);
      $account->jml_comments = floor($ratacomment);
      $account->eng_rate = ($account->jml_likes + $account->jml_comments)/$account->jml_followers;
    }
    $account->save();

    return $account;
  }

  public function load_search(Request $request){
    $arr['status'] = 'success';
    $arr['message'] = '';

    if($request->keywords==''){
      //$account = Account::find(1);
      $account = Account::where('jml_followers','>=',500000)->inRandomOrder()->first();
    } else {
      $account = Account::where('username',$request->keywords)->first();

      if(is_null($account)){
        $url = "http://cmx.space/get-user-data/".$request->keywords;

        $arr_res = $this->igcallback($url);
        
        if($arr_res!=null){
          $account = $this->create_account($arr_res);
        } else {
          $arr['status'] = 'error';
          $arr['message'] = '<b>Warning!</b> Username tidak ditemukan!';
          return $arr;
        }
      }

      if(Auth::check()){
        $history = new HistorySearch;
        $history->account_id = $account->id;
        $history->user_id = Auth::user()->id;
        $history->save();
      } else {
        //$request->session()->put('account_search', $account->username);
        if(!isset($_COOKIE[$this->cookie_search])) {
          $cookie_value[] = $account->id;
          // set cookie for 30days, 86400 = 1 day
          setcookie($this->cookie_search, json_encode($cookie_value), time() + (86400 * 30), "/");
        } else {
          $cookie_value = json_decode($_COOKIE[$this->cookie_search], true);
          //var_dump($cookie_value);
          if(count($cookie_value)>=3){
            $arr['status'] = 'error';
            $arr['message'] = 'kuota habis';
          } else {
            array_push($cookie_value, $account->id);
            setcookie($this->cookie_search, json_encode($cookie_value), time() + (86400 * 30), "/");
          }
        }
      }
    }

    $arr['view'] = (string) view('user.search.content-akun')->with('account',$account);

    return $arr;
  }

  public function load_history_search(Request $request){
    $accounts = null;

    if(Auth::check()){
      $accounts = HistorySearch::join('accounts','accounts.id','=','history_searchs.account_id')
          ->select('history_searchs.*','accounts.username','accounts.prof_pic')
          ->where('history_searchs.user_id',Auth::user()->id)
          ->orderBy('history_searchs.created_at','desc')->get();
    } else {
      if(isset($_COOKIE[$this->cookie_search])){
        $cookie_value = json_decode($_COOKIE[$this->cookie_search]);
        $accounts = Account::findMany($cookie_value);
      }
    }

    $arr['view'] = (string) view('user.search.content-history')->with('accounts',$accounts);

    return $arr;
  }

  public function delete_history(Request $request){
    $arr['status'] = 'success';
    $arr['message'] = '';

    if(Auth::check()){
      $history = HistorySearch::find($request->id)->delete();
    } else {
      if(!isset($_COOKIE[$this->cookie_delete])) {
        $cookie_value = 1;
        // set cookie for 30days, 86400 = 1 day
        setcookie($this->cookie_delete, $cookie_value, time() + (86400 * 30), "/");
      } else {
        $cookie_value = $_COOKIE[$this->cookie_delete];
        if($cookie_value>1){
          $arr['status'] = 'error';
          $arr['message'] = 'kuota habis';
        } else {
          $cookie_value_search = json_decode($_COOKIE[$this->cookie_search]);

          if (($key = array_search($request->id, $cookie_value_search)) !== false) {
            unset($cookie_value_search[$key]);
          }
          setcookie($this->cookie_search, json_encode($cookie_value_search), time() + (86400 * 30), "/");

          $cookie_value = $cookie_value + 1;
          setcookie($this->cookie_delete, $cookie_value, time() + (86400 * 30), "/");
        }
      }
    }

    return $arr;
  }
}
