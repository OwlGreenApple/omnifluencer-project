<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use App\AccountLog;
use App\HistorySearch;
use App\User;
use App\Group;
use App\Save;
use App\Subscribe;

use App\Mail\ProfileEmail;
use App\Mail\ProfileBulkEmail;

use Auth,PDF,Excel,Mail,Validator,Carbon,Datetime;

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
    return view('user.search.index')
            ->with('keywords',null);
  }

  public function index_post(Request $request){
    if($request->has('keywords')){
      return view('user.search.index')
            ->with('keywords',$request->keywords);
    } else {
      return view('user.search.index')
            ->with('keywords',null);   
    }
    
  }

  public static function igcallback($url,$mode='json'){
    $c = curl_init();

    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_REFERER, $url);
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    $page = curl_exec($c);
    curl_close($c);
        
    if($mode=='json'){
      $arr_res = json_decode($page,true);
      return $arr_res;
    } else {
      return $page;
    }
  }

  public static function create_account($arr_res){
    set_time_limit(0);
    $account = new Account;
    $account->ig_id = $arr_res["pk"];
    $account->username = strtolower($arr_res["username"]);
    $account->fullname = $arr_res["full_name"];
    $account->prof_pic = $arr_res["hd_profile_pic_url_info"]["url"];
    $account->jml_following = $arr_res["following_count"];
    $account->jml_followers = $arr_res["follower_count"];
    $account->jml_post = $arr_res["media_count"];

    $count = 0;
    $jmllike = 0;
    $jmlcomment = 0;
    $end_cursor = null;
    $private = false;
    $lastpost = null;
    //var_dump($arr_res2);

    do {
      $url2 = "http://cmx.space/get-user-feed/".$arr_res["username"].'/'.$end_cursor;
      $arr_res2 = AccountController::igcallback($url2);    

      $url3 = "http://cmx.space/get-user-feed-maxid/".$arr_res["username"].'/'.$end_cursor;
      $arr_res3 = AccountController::igcallback($url3,'string');
      $end_cursor = $arr_res3;

      if($end_cursor=='InstagramAPI\Response\UserFeedResponse: Not authorized to view user.'){
          $private = true;
          break;
      }

      if(!is_null($arr_res2) and !empty($arr_res2)){
        if($count==0){
          $lastpost = date("Y-m-d h:i:s",$arr_res2[0]["taken_at"]);
        }

        foreach ($arr_res2 as $arr) {
          if($count>=20){
            break;
          } else {
            $jmllike = $jmllike + $arr["like_count"];
            if(array_key_exists('comment_count', $arr)){
              $jmlcomment = $jmlcomment + $arr["comment_count"];  
            } 
            $count++;
          }
        }
      } else {
        if($count==0){
          $private = true;
        }
        break;
      }
    } while ($count<20);

    //hitung rata2 like + comment di 20 post terakhir 
    //check akun private atau nggak
    if($private==false){
      $ratalike = $jmllike/$count;
      $ratacomment = $jmlcomment/$count;
    } else {
      $ratalike = 0;
      $ratacomment = 0;
    }

    $account->lastpost = $lastpost;
    $account->jml_likes = floor($ratalike);
    $account->jml_comments = floor($ratacomment);

    if($account->jml_followers>0){
      $account->eng_rate = ($jmllike + $jmlcomment)/($account->jml_followers*20);
      $account->total_influenced = $account->eng_rate*$account->jml_followers;
    }

    $account->save();

    $accountlog = new AccountLog;
    $accountlog->account_id = $account->id;
    $accountlog->jml_followers = $account->jml_followers;
    $accountlog->jml_following = $account->jml_following;
    $accountlog->jml_post = $account->jml_post;
    $accountlog->lastpost = $account->lastpost;
    $accountlog->jml_likes = $account->jml_likes;
    $accountlog->jml_comments = $account->jml_comments;

    if($account->jml_followers>0){
      $accountlog->eng_rate = $account->eng_rate;
      $accountlog->total_influenced = $account->total_influenced;
    }

    $accountlog->save();

    return $account;
  }

  public function load_search(Request $request){
    $arr['status'] = 'success';
    $arr['message'] = '';

    if($request->keywords==''){
      //$account = Account::find(1);
      //$account = Account::where('jml_followers','>=',500000)->inRandomOrder()->first();
      $account = Account::where('id',1499)
                  ->orWhere('id',1500)
                  ->inRandomOrder()
                  ->first();
    } else {
      $account = Account::where('username',$request->keywords)->first();

      if(is_null($account)){
        $url = "http://cmx.space/get-user-data/".$request->keywords;

        $arr_res = AccountController::igcallback($url);
        
        if($arr_res!=null){
          $account = $this->create_account($arr_res);
        } else {
          $arr['status'] = 'error';
          $arr['message'] = 'Username tidak ditemukan!';
          return $arr;
        }
      }

      if(Auth::check()){
        $history = HistorySearch::where('user_id',Auth::user()->id) 
                    ->where('account_id',$account->id)
                    ->first();

        if(is_null($history)){
          /* pengecekan membership */
          if(Auth::user()->membership=='free'){
            $currenthistory = HistorySearch::where('user_id',Auth::user()->id)->get();

            if($currenthistory->count()>=5){
              $arr['status'] = 'error';
              $arr['message'] = '<b>Warning!</b><br> Free user hanya dapat menyimpan history search sebanyak 5 kali';
              return $arr;
            }
          } else if(Auth::user()->membership=='pro'){
            $currenthistory = HistorySearch::where('user_id',Auth::user()->id)->get();

            if($currenthistory->count()>=25){
              $arr['status'] = 'error';
              $arr['message'] = '<b>Warning!</b><br> Pro user hanya dapat menyimpan history search sebanyak 25 kali';
              return $arr;
            }
          } 
        
          $history = new HistorySearch;
          $history->account_id = $account->id;
          $history->user_id = Auth::user()->id;
        } else {
          $history->updated_at = new Datetime();
        }
 
        $history->save();

        $user = User::find(Auth::user()->id);
        $user->count_calc = $user->count_calc + 1;
        $user->save();

        $account->total_calc = $account->total_calc + 1;
        $account->save();
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

  public function load_search_byid(Request $request){
    $arr['status'] = 'success';
    $arr['message'] = '';

    $account = Account::find($request->id);

    /*if(Auth::check()){
      $history = HistorySearch::where('user_id',Auth::user()->id) 
                    ->where('account_id',$account->id)
                    ->first(); 

      $history->updated_at = new Datetime();
      $history->save();
    }*/
    
    $arr['view'] = (string) view('user.search.content-akun')->with('account',$account);

    return $arr;
  }

  public function load_history(Request $request){
    $accounts = null;

    if(Auth::check()){
      $accounts = HistorySearch::join('accounts','accounts.id','=','history_searchs.account_id')
          ->select('history_searchs.*','accounts.id as accountid','accounts.username','accounts.prof_pic')
          ->where('history_searchs.user_id',Auth::user()->id)
          ->orderBy('history_searchs.updated_at','desc');

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

    $accounts = $accounts->orderBy('history_searchs.updated_at','desc')
          ->paginate(15);

    $arr['view'] = (string) view('user.history-search.content')
                      ->with('accounts',$accounts);
    $arr['pager'] = (string) view('user.history-search.pagination')
                      ->with('accounts',$accounts); 

    return $arr;
  }

  public function print_pdf($id,$type){

    /*if(Auth::user()->membership=='free'){
      return abort(403);
    }*/

    $user = User::find(Auth::user()->id);
    $user->count_pdf = $user->count_pdf + 1;
    $user->save();

    $account = Account::find($id);

    $data = array(
      'account' => $account,   
    );

    if($type=='plain'){
      $pdf = PDF::loadView('user.pdf-profile-plain', $data)
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('margin-bottom', '0mm')
            ->setOption('margin-top', '0mm')
            ->setOption('margin-right', '0mm')
            ->setOption('margin-left', '0mm');
    } else {
      $pdf = PDF::loadView('user.pdf-profile', $data)
            ->setPaper('a4')
            ->setOption('margin-bottom', '0mm')
            ->setOption('margin-top', '0mm')
            ->setOption('margin-right', '0mm')
            ->setOption('margin-left', '0mm');
    }

    return $pdf->stream();
  }

  public function print_csv($id){

    if(Auth::user()->membership=='free' or Auth::user()->membership=='pro'){
      return abort(403);
    }

    $user = User::find(Auth::user()->id);
    $user->count_csv = $user->count_csv + 1;
    $user->save();

    $account = Account::find($id);
    $filename = 'profile '.$account->username;

    $Excel_file = Excel::create($filename, function($excel) use ($account) {
        $excel->sheet('list', function($sheet) use ($account) {

          $username = '@'.$account->username;
          $sheet->cell('C2', $username); 
          $sheet->cell('C3', $account->fullname); 

          $sheet->cell('B4', 'Engagement Rate'); 
          $sheet->cell('C4', $account->eng_rate*100); 

          $influence = round($account->total_influenced);

          $sheet->cell('B5', 'Total Influenced'); 
          $sheet->cell('C5', $influence);

          $sheet->cell('B6', 'Post'); 
          $sheet->cell('C6', $account->jml_post);

          $sheet->cell('B7', 'Followers'); 
          $sheet->cell('C7', $account->jml_followers);

          $sheet->cell('B8', 'Following'); 
          $sheet->cell('C8', $account->jml_following);
          
          $sheet->cell('B9', 'Last Post'); 
          $sheet->cell('C9', date("M d Y", strtotime($account->lastpost)));

          $sheet->cell('B10', 'Avg Like Per Post'); 
          $sheet->cell('C10', $account->jml_likes);

          $sheet->cell('B11', 'Avg Comment Per Post'); 
          $sheet->cell('C11', $account->jml_comments);

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
    if(!isset($request->accountid)){
      $arr['status'] = 'error';
      $arr['message'] = 'Pilih akun terlebih dahulu';
      return $arr;
    }

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
    $arr['message'] = 'Add to group berhasil';

    //Pengecekkan id 
    if(!isset($request->accountid)){
      $arr['status'] = 'error';
      $arr['message'] = 'Pilih akun terlebih dahulu';

      return $arr;
    } else if(!isset($request->groupid)){
      $arr['status'] = 'error';
      $arr['message'] = 'Pilih group terlebih dahulu';

      return $arr;
    }

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
    //Pengecekkan id 
    if(!isset($request->accountid)){
      $arr['status'] = 'error';
      $arr['message'] = 'Pilih akun terlebih dahulu';

      return $arr;
    }

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

    //Pengecekkan id 
    if(!isset($request->historyid)){
      $arr['status'] = 'error';
      $arr['message'] = 'Pilih history terlebih dahulu';

      return $arr;
    }

    foreach ($request->historyid as $id) {
      $history = HistorySearch::find($id)->delete(); 
    }

    return $arr;
  }

  public function print_pdf_bulk(Request $request){
    if(Auth::user()->membership=='free' or Auth::user()->membership=='pro'){
      return abort(403);
    }

    if(!isset($request->accountid)){
      $arr['status'] = 'error';
      $arr['message'] = 'Pilih akun terlebih dahulu';
      return $arr;
    }

    $user = User::find(Auth::user()->id);
    //$user->count_pdf = $user->count_pdf + count($request->accountid);
    $user->count_pdf = $user->count_pdf + 1;
    $user->save();

    $account = [];
    foreach ($request->accountid as $id) {
      $account[] = Account::find($id); 
    }

    $data = array(
      'account' => $account,   
    );

    if($request->type=='plain'){
      $pdf = PDF::loadView('user.pdf-profile-plain', $data)
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('margin-bottom', '0mm')
            ->setOption('margin-top', '0mm')
            ->setOption('margin-right', '0mm')
            ->setOption('margin-left', '0mm');
    } else {
      $pdf = PDF::loadView('user.pdf-profile', $data)
            ->setPaper('a4')
            ->setOption('margin-bottom', '0mm')
            ->setOption('margin-top', '0mm')
            ->setOption('margin-right', '0mm')
            ->setOption('margin-left', '0mm');
    }
    
    //return $pdf->download('omnifluencer.pdf');
    return $pdf->stream();
  }

  public function print_csv_bulk(Request $request){

    if(Auth::user()->membership=='free' or Auth::user()->membership=='pro'){
      return abort(403);
    }

    if(!isset($request->accountid)){
      $arr['status'] = 'error';
      $arr['message'] = 'Pilih akun terlebih dahulu';
      return $arr;
    }

    $user = User::find(Auth::user()->id);
    //$user->count_csv = $user->count_csv + count($request->accountid);
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
            $sheet->cell('C3', $account->fullname); 

            $sheet->cell('B4', 'Engagement Rate'); 
            $sheet->cell('C4', $account->eng_rate*100); 

            $influence = round($account->total_influenced);

            $sheet->cell('B5', 'Total Influenced'); 
            $sheet->cell('C5', $influence);

            $sheet->cell('B6', 'Post'); 
            $sheet->cell('C6', $account->jml_post);

            $sheet->cell('B7', 'Followers'); 
            $sheet->cell('C7', $account->jml_followers);

            $sheet->cell('B8', 'Following'); 
            $sheet->cell('C8', $account->jml_following);
                
            $sheet->cell('B9', 'Last Post'); 
            $sheet->cell('C9', date("M d Y", strtotime($account->lastpost)));

            $sheet->cell('B10', 'Avg Like Per Post');
            $sheet->cell('C10', $account->jml_likes);

            $sheet->cell('B11', 'Avg Comment Per Post'); 
            $sheet->cell('C11', $account->jml_comments);
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
    
    return "Email subscribed";
  }

  public function index_account(){
    return view('admin.list-account.index');
  }

  public function load_account(Request $request){
    $accounts = Account::All();

    $arr['view'] = (string) view('admin.list-account.content')->with('accounts',$accounts);

    return $arr;
  }

  public function view_account_log(Request $request){
    $logs = AccountLog::where('account_id',$request->id)
              ->get();

    $arr['view'] = (string) view('admin.list-account.content-log')->with('logs',$logs);
    
    return $arr;
  }
}
