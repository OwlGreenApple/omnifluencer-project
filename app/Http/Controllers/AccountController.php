<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use App\HistorySearch;
use App\User;
use App\Group;
use App\Save;
use App\Subscribe;

use App\Mail\ProfileEmail;
use App\Mail\ProfileBulkEmail;

use Auth,PDF,Excel,Mail,Validator,Carbon;

class AccountController extends Controller
{
  protected $cookie_search = "history_search";
  protected $cookie_delete = "delete_search";

  protected function validator(array $data){
    $rules = [
      'email' => 'required|string|email|max:255',
    ];

    return Validator::make($data, $rules);
  }

  public function index(){
    return view('user.search.index');
  }

  public static function igcallback($url){
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

  public static function create_account($arr_res){
    $account = new Account;
    $account->ig_id = $arr_res["pk"];
    $account->username = strtolower($arr_res["username"]);
    $account->prof_pic = $arr_res["hd_profile_pic_url_info"]["url"];
    $account->jml_following = $arr_res["following_count"];
    $account->jml_followers = $arr_res["follower_count"];
    $account->jml_post = $arr_res["media_count"];

    $url2 = "http://cmx.space/get-user-feed/".$arr_res["username"];
    // $arr_res2 = $this->igcallback($url2);
    $arr_res2 = AccountController::igcallback($url2);

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

        $user = User::find(Auth::user()->id);
        $user->count_calc = $user->count_calc + 1;
        $user->save();
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

  public function load_history(Request $request){
    $accounts = null;

    if(Auth::check()){
      $accounts = HistorySearch::join('accounts','accounts.id','=','history_searchs.account_id')
          ->select('history_searchs.*','accounts.username','accounts.prof_pic')
          ->where('history_searchs.user_id',Auth::user()->id)
          ->orderBy('history_searchs.created_at','desc');

      $arr['count'] = $accounts->count();
      
      $accounts = $accounts->paginate(5);
    } else {
      /*if(isset($_COOKIE[$this->cookie_search])){
        $cookie_value = json_decode($_COOKIE[$this->cookie_search],true);
        //dd($cookie_value);
        $accounts = Account::findMany($cookie_value);

        $arr['count'] = count($cookie_value);
      }*/

      $accounts = [];
      if(isset($_COOKIE[$this->cookie_search])){
        $cookie_value = json_decode($_COOKIE[$this->cookie_search],true);
        //dd($cookie_value);
        foreach ($cookie_value as $cookie) {
          $accounts[] = Account::find($cookie); 
        }
        
        $arr['count'] = count($accounts);
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
        
        $cookie_value_search = json_decode($_COOKIE[$this->cookie_search],true);
        
        if (($key = array_search($request->id, $cookie_value_search)) !== false) {
          unset($cookie_value_search[$key]);
        }
        //dd($cookie_value_search);
        setcookie($this->cookie_search, json_encode($cookie_value_search), time() + (86400 * 30), "/");
        //dd($_COOKIE[$this->cookie_search]);
      } else {
        $cookie_value = $_COOKIE[$this->cookie_delete];
        if($cookie_value>=1){
          $arr['status'] = 'error';
          $arr['message'] = 'kuota habis';
        } else {
          $cookie_value_search = json_decode($_COOKIE[$this->cookie_search],true);

          if (($key = array_search($request->id, $cookie_value_search)) !== false) {
            unset($cookie_value_search[$key]);
          }
          //dd($cookie_value_search);
          setcookie($this->cookie_search, json_encode($cookie_value_search), time() + (86400 * 30), "/");

          $cookie_value = $cookie_value + 1;
          setcookie($this->cookie_delete, $cookie_value, time() + (86400 * 30), "/");
        }
      }
    }

    return $arr;
  }

  public function index_history(){
    return view('user.history-search.index');
  }

  public function load_history_search(Request $request){
    $accounts = HistorySearch::join('accounts','accounts.id','=','history_searchs.account_id')
          ->select('history_searchs.*','accounts.id as accountid','accounts.username','accounts.prof_pic','accounts.eng_rate','accounts.jml_followers','accounts.jml_post')
          ->where('history_searchs.user_id',Auth::user()->id)
          ->where('accounts.username','like','%'.$request->keywords.'%');

    if($request->from!=null and $request->to!=null){
      $dt = Carbon::createFromFormat("Y/m/d h:i:s", $request->from.' 00:00:00'); 

      $dt1 = Carbon::createFromFormat("Y/m/d h:i:s", $request->to.' 00:00:00');

      $accounts = $accounts->whereDate("history_searchs.created_at",">=",$dt)
              ->whereDate("history_searchs.created_at","<=",$dt1);
    }

    $accounts = $accounts->orderBy('history_searchs.created_at','desc')
          ->paginate(15);

    $arr['view'] = (string) view('user.history-search.content')
                      ->with('accounts',$accounts);
    $arr['pager'] = (string) view('user.history-search.pagination')
                      ->with('accounts',$accounts); 

    return $arr;
  }

  public function print_pdf($id){
    $user = User::find(Auth::user()->id);
    $user->count_pdf = $user->count_pdf + 1;
    $user->save();

    $account = Account::find($id);

    $data = array(
      'account' => $account,   
    );

    $pdf = PDF::loadView('user.pdf-profile', $data)
            ->setOption('margin-bottom', '0mm')
            ->setOption('margin-top', '0mm')
            ->setOption('margin-right', '0mm')
            ->setOption('margin-left', '0mm');

    //return $pdf->download('omnifluencer.pdf');
    return $pdf->stream();
  }

  public function print_csv($id){
    $user = User::find(Auth::user()->id);
    $user->count_csv = $user->count_csv + 1;
    $user->save();

    $filename = 'omnifluencer';
    $account = Account::find($id);

    $Excel_file = Excel::create($filename, function($excel) use ($account) {
        $excel->sheet('list', function($sheet) use ($account) {

          $username = '@'.$account->username;
          $sheet->cell('C2', $username); 

          $sheet->cell('B3', 'Engagement Rate'); 
          $sheet->cell('C3', $account->eng_rate*100); 

          $influence = round($account->eng_rate*$account->jml_followers);

          $sheet->cell('B4', 'Total Influenced'); 
          $sheet->cell('C4', $influence);

          $sheet->cell('B5', 'Post'); 
          $sheet->cell('C5', $account->jml_post);

          $sheet->cell('B6', 'Followers'); 
          $sheet->cell('C6', $account->jml_followers);

          $sheet->cell('B7', 'Following'); 
          $sheet->cell('C7', $account->jml_following);
          
          $sheet->cell('B8', 'Last Post'); 
          $sheet->cell('C8', date("M d Y", strtotime($account->lastpost)));

          $sheet->cell('B9', 'Avg Like Per Post'); 
          $sheet->cell('C9', $account->jml_likes);

          $sheet->cell('B10', 'Avg Comment Per Post'); 
          $sheet->cell('C10', $account->jml_comments);

          //$sheet->fromArray($data);
        });
      })->download('xlsx');
  }

  public function send_email(Request $request){
    $validator = $this->validator($request->all());

    if(!$validator->fails()){
      Mail::to($request->email)->queue(new ProfileEmail($request->email,$request->type,$request->id));

      $arr['status'] = 'success';
      $arr['message'] = 'Email berhasil terkirim';
    } else {
      $arr['status'] = 'error';
      $arr['message'] = $validator->errors()->first();
    }

    return $arr;
  }

  public function send_email_bulk(Request $request){
    $validator = $this->validator($request->all());

    if(!$validator->fails()){
      Mail::to($request->email)->queue(new ProfileBulkEmail($request->email,$request->type,$request->accountid));

      $arr['status'] = 'success';
      $arr['message'] = 'Email berhasil terkirim';
    } else {
      $arr['status'] = 'error';
      $arr['message'] = $validator->errors()->first();
    }

    return $arr;
  }

  public function get_groups(){
    $groups = Group::where('user_id',Auth::user()->id)
                ->orderBy('created_at','desc')
                ->get();

    $arr['view'] = (string) view('user.history-search.content-group')
            ->with('groups',$groups);

    return $arr;
  }

  public function add_groups(Request $request){
    $arr['status'] = 'success';
    $arr['message'] = '';

    foreach ($request->accountid as $accountid) {
      foreach ($request->groupid as $groupid) {
        $checksave = Save::where('user_id',Auth::user()->id)
                      ->where('account_id',$accountid)
                      ->where('group_id',$groupid)
                      ->first();

        if(is_null($checksave)){
          $save = new Save;
          $save->user_id = Auth::user()->id;
          $save->type = 'influencer';
          $save->account_id = $accountid;
          $save->group_id = $groupid;
          $save->save();
        }
      }
    }

    return $arr;
  }

  public function create_groups(Request $request){
    $group = new Group;
    $group->user_id = Auth::user()->id;
    $group->group_name = $request->groupname;
    $group->save();

    $arr['status'] = 'success';
    $arr['message'] = '';

    return $arr;
  }

  public function save_groups(Request $request){
    foreach ($request->accountid as $accountid) {
      $checksave = Save::where('user_id',Auth::user()->id)
                      ->where('account_id',$accountid)
                      ->where('group_id',0)
                      ->first();

      if(is_null($checksave)){
        $save = new Save;
        $save->user_id = Auth::user()->id;
        $save->type = 'influencer';
        $save->account_id = $accountid;
        $save->group_id = 0;
        $save->save();
      }
    }

    $arr['status'] = 'success';
    $arr['message'] = 'Berhasil menyimpan history ke <b>"Saved Profile"</b>';

    return $arr;
  }

  public function delete_history_bulk(Request $request){
    $arr['status'] = 'success';
    $arr['message'] = '';

    foreach ($request->historyid as $id) {
      $history = HistorySearch::find($id)->delete(); 
    }

    return $arr;
  }

  public function print_pdf_bulk(Request $request){
    $user = User::find(Auth::user()->id);
    $user->count_pdf = $user->count_pdf + 1;
    $user->save();

    $account = [];
    foreach ($request->accountid as $id) {
      $account[] = Account::find($id); 
    }

    $data = array(
      'account' => $account,   
    );

    $pdf = PDF::loadView('user.pdf-profile', $data)
                  ->setOption('margin-bottom', '0mm')
                  ->setOption('margin-top', '0mm')
                  ->setOption('margin-right', '0mm')
                  ->setOption('margin-left', '0mm');

    //return $pdf->download('omnifluencer.pdf');
    return $pdf->stream();
  }

  public function print_csv_bulk(Request $request){
    $user = User::find(Auth::user()->id);
    $user->count_csv = $user->count_csv + 1;
    $user->save();

    $filename = 'omnifluencer';

    $Excel_file = Excel::create($filename, function($excel) use ($request) {

      $i = 1;
      foreach ($request->accountid as $id) {
        $sheetname = 'Sheet'.$i;

        $excel->sheet($sheetname, function($sheet) use ($id) {

            $account = Account::find($id); 

            $username = '@'.$account->username;
            $sheet->cell('C2', $username); 

            $sheet->cell('B3', 'Engagement Rate'); 
            $sheet->cell('C3', $account->eng_rate*100); 

            $influence = round($account->eng_rate*$account->jml_followers);

            $sheet->cell('B4', 'Total Influenced'); 
            $sheet->cell('C4', $influence);

            $sheet->cell('B5', 'Post'); 
            $sheet->cell('C5', $account->jml_post);

            $sheet->cell('B6', 'Followers'); 
            $sheet->cell('C6', $account->jml_followers);

            $sheet->cell('B7', 'Following'); 
            $sheet->cell('C7', $account->jml_following);
                
            $sheet->cell('B8', 'Last Post'); 
            $sheet->cell('C8', date("M d Y", strtotime($account->lastpost)));

            $sheet->cell('B9', 'Avg Like Per Post'); 
            $sheet->cell('C9', $account->jml_likes);

            $sheet->cell('B10', 'Avg Comment Per Post'); 
            $sheet->cell('C10', $account->jml_comments);
        });
        $i++;
      }
    })->download('xlsx');
  }

  public function subscribe_email(Request $request){
    //pengecekan email 
    $validator = Validator::make(["email"=>$request->email], [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:subscribers'],
    ]);
    
    if(!$validator->fails()) {
      //input data
      $subscribe = new Subscribe;
      $subscribe->email = $request->email;
      $subscribe->save();
    }
    else {
      return $validator->errors()->first();
    }
    
    return "email subscribed";
  }
}
