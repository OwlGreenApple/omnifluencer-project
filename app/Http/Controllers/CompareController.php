<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HistoryCompare;
use App\User;
use App\Account;

use App\Mail\ProfileCompareEmail;

use App\Http\Controllers\AccountController;

use Auth,PDF,Excel,Validator,Mail,Carbon;

class CompareController extends Controller
{
  protected function validator(array $data){
    $rules = [
      'email' => 'required|string|email|max:255',
    ];

    return Validator::make($data, $rules);
  }

  public function index($keywords=""){
    //pengecekan membership
    if(Auth::user()->membership=='free'){
      return abort(403);
    } 

    $arr1 = explode("-",$keywords);

    $arr_compare = array(
      "username1"=>"",
      "username2"=>"",
      "username3"=>"",
      "username4"=>"",
    );
    $arr_compare["username1"] = "";
    $arr_compare["username2"] = "";
    $arr_compare["username3"] = "";
    $arr_compare["username4"] = "";

    if (isset($arr1[0])) {
      $arr_compare["username1"] = $arr1[0];
    }
    if (isset($arr1[1])) {
      $arr_compare["username2"] = $arr1[1];
    }
    if (isset($arr1[2])) {
      //pengecekan membership
      if(Auth::user()->membership=='pro'){
        return abort(403);
      }

      $arr_compare["username3"] = $arr1[2];
    }
    if (isset($arr1[3])) {
      $arr_compare["username4"] = $arr1[3];
    }

    return view('user.compare.index')
            ->with('username1',$arr_compare["username1"])
            ->with('username2',$arr_compare["username2"])
            ->with('username3',$arr_compare["username3"])
            ->with('username4',$arr_compare["username4"]);
  }

  public function check(Request $request){
    $arr['status'] = 'success';
    $arr['message'] = '';

    //pengecekan id 
    if(!isset($request->accountid)){
      $arr['status'] = 'error';
      $arr['message'] = 'Pilih akun terlebih dahulu';
      return $arr;
    }

    // pengecekan membership
    if(Auth::user()->membership=='free'){
      $arr['status'] = 'error';
      $arr['message'] = 'Free user tidak dapat melakukan compare';
      return $arr;
    } else if(Auth::user()->membership=='pro'){
      if ( count($request->accountid)>2) { 
        $arr['status'] = 'error';
        $arr['message'] = 'Maksimum compare pro user adalah 2 akun';
        return $arr;
      }
    } else {
      if ( count($request->accountid)>4) { 
        $arr['status'] = 'error';
        $arr['message'] = 'Maksimum compare adalah 4 akun';
        return $arr;
      }
    }
    
    $message = "";
    $i = 0;
    $len = count($request->accountid);
    foreach ($request->accountid as $accountid) {
      $account = Account::find($accountid);
      if (!is_null($account)) {
        $message .= $account->username;
        if ($i <> $len - 1) {
          $message .= "-";
        }
      }
      $i++;
    }
    $arr['message'] = $message;
    return $arr;
  }

  public function load_search(Request $request){
    // load akun 
    $account = Account::where('username',$request->keywords)->first();

    if(is_null($account)){
      $url = "http://cmx.space/get-user-data/".$request->keywords;

      $arr_res = AccountController::igcallback($url);
      
      if($arr_res!=null){
        $account = AccountController::create_account($arr_res);
      } else {
        $arr['status'] = 'error';
        $arr['message'] = '<b>Warning!</b> Username tidak ditemukan!';
        return $arr;
      }
    }

    // panggil function compare dibawah
    $arr_compare = array(
      "id1"=>-1,
      "id2"=>-1,
      "id3"=>-1,
      "id4"=>-1,
    );
    if ($request->part==1) {
      $arr_compare["id1"]=$account->id;
    }
    if ($request->part==2) {
      $arr_compare["id2"]=$account->id;
    }
    if ($request->part==3) {
      $arr_compare["id3"]=$account->id;
    }
    if ($request->part==4) {
      $arr_compare["id4"]=$account->id;
    }
    $this->do_compare($arr_compare);
  }
  
  public function do_compare($arr){
    $user = Auth::user();
    //cari ada user ngga yang search compare kurang dari 1 jam dari now 
    $history_compare = HistoryCompare::where("user_id",$user->id)
                        ->whereRaw("updated_at > date_sub(now(), interval 1 hour)")
                        ->first();
    if (is_null($history_compare)){
      //klo ga ada create new 
      $history_compare = new HistoryCompare;
      $history_compare->user_id=$user->id;
    }
    else {
    }
    //update data
    if ($arr["id1"]<>-1) {
      $history_compare->account_id_1=$arr["id1"];
    }
    if ($arr["id2"]<>-1) {
      $history_compare->account_id_2=$arr["id2"];
    }
    if ($arr["id3"]<>-1) {
      $history_compare->account_id_3=$arr["id3"];
    }
    if ($arr["id4"]<>-1) {
      $history_compare->account_id_4=$arr["id4"];
    }
    $history_compare->save();

    return $history_compare->id;
  }

  public function check_akun($account,$keywords){
    if(is_null($account) and $keywords!=''){
      $url = "http://cmx.space/get-user-data/".$keywords;

      $arr_res = AccountController::igcallback($url);
      
      if($arr_res!=null){
        $account = AccountController::create_account($arr_res);
      } else {
        return false;
      }
    }

    return $account;
  }

  public function load_compare(Request $request){
    $acc1 = Account::where("username",$request->id1)->first();
    $acc2 = Account::where("username",$request->id2)->first();
    $acc3 = Account::where("username",$request->id3)->first();
    $acc4 = Account::where("username",$request->id4)->first();

    $acc1 = $this->check_akun($acc1,$request->id1);
    $acc2 = $this->check_akun($acc2,$request->id2);
    $acc3 = $this->check_akun($acc3,$request->id3);
    $acc4 = $this->check_akun($acc4,$request->id4);

    if($acc1===false || $acc2===false || $acc3===false || $acc4===false){
      $arr['status'] = 'error';
      $arr['message'] = 'Username tidak ditemukan';
      return $arr;
    }

    // $accounts = array($acc1,$acc2,$acc3,$acc4);
    $accounts = array();
    $arr_compare = array(
      "id1"=>-1,
      "id2"=>-1,
      "id3"=>-1,
      "id4"=>-1,
    );
    if (!is_null($acc1)){
      $arr_compare["id1"] = $acc1->id;
      $accounts[] = $acc1;
    } else {
      $accounts[] = null;
    }

    if (!is_null($acc2)){
      $arr_compare["id2"] = $acc2->id;
      $accounts[] = $acc2;
    } else {
      $accounts[] = null;
    }

    if (!is_null($acc3)){
      $arr_compare["id3"] = $acc3->id;
      $accounts[] = $acc3;
    } else {
      $accounts[] = null;
    }

    if (!is_null($acc4)){
      $arr_compare["id4"] = $acc4->id;
      $accounts[] = $acc4;
    } else {
      $accounts[] = null;
    }
    
    $id_history = $this->do_compare($arr_compare);

    $arr['status'] = "success";
    $arr['view'] = (string) view('user.compare.content-akun')
                      ->with('accounts',$accounts);
    $arr['id'] = $id_history;

    return $arr;
    // return "asd";
  }

    public function index_history(){
      //pengecekan membership 
      if(Auth::user()->membership=='free'){
        return abort(403);
      }

      return view('user.compare-history.index');
    }

    public function load_history_compare(Request $request){
      $compares = HistoryCompare::leftjoin('accounts as acc1','history_compares.account_id_1','acc1.id')
              ->leftjoin('accounts as acc2','history_compares.account_id_2','acc2.id')
              ->leftjoin('accounts as acc3','history_compares.account_id_3','acc3.id')
              ->leftjoin('accounts as acc4','history_compares.account_id_4','acc4.id')
              ->select('history_compares.*','acc1.username as acc1username','acc2.username as acc2username','acc3.username as acc3username','acc4.username as acc4username')
              ->where('history_compares.user_id',Auth::user()->id)
              ->where(function($query) use ($request) {
                  $query->where('acc1.username','like','%'.$request->keywords.'%')
                        ->orWhere('acc2.username','like','%'.$request->keywords.'%')
                        ->orWhere('acc3.username','like','%'.$request->keywords.'%')
                        ->orWhere('acc4.username','like','%'.$request->keywords.'%');
                });

      if($request->from!=null and $request->to!=null){
        $dt = Carbon::createFromFormat("Y/m/d h:i:s", $request->from.' 00:00:00'); 

        $dt1 = Carbon::createFromFormat("Y/m/d h:i:s", $request->to.' 00:00:00');

        $compares = $compares->whereDate("history_compares.created_at",">=",$dt)
                ->whereDate("history_compares.created_at","<=",$dt1);
      }

      $compares = $compares->orderBy('history_compares.created_at','desc')
                  ->paginate(15);

      $arr['view'] = (string) view('user.compare-history.content')
                        ->with('compares',$compares);
      $arr['pager'] = (string) view('user.compare-history.pagination')
                        ->with('compares',$compares);
      return $arr;
    }

  public function print_pdf($id,$type){

    if(Auth::user()->membership=='free'){
      return abort(403);
    }

    $user = User::find(Auth::user()->id);
    $user->count_pdf = $user->count_pdf + 1;
    $user->save();

    $compare = HistoryCompare::find($id);

    $account1 = Account::find($compare->account_id_1);
    $account2 = Account::find($compare->account_id_2);
    $account3 = Account::find($compare->account_id_3);
    $account4 = Account::find($compare->account_id_4);

    $data = array(
      'data' => array($account1,$account2,$account3,$account4
            )
    );

    if($type=='plain'){
      $pdf = PDF::loadView('user.pdf-compare-plain',$data)
                ->setPaper('a4')
                ->setOrientation('landscape')
                ->setOption('margin-bottom', '0mm')
                ->setOption('margin-top', '0mm')
                ->setOption('margin-right', '0mm')
                ->setOption('margin-left', '0mm');
    } else {
      $pdf = PDF::loadView('user.pdf-compare',$data)
                ->setPaper('a4')
                ->setOrientation('landscape')
                ->setOption('margin-bottom', '0mm')
                ->setOption('margin-top', '0mm')
                ->setOption('margin-right', '0mm')
                ->setOption('margin-left', '0mm');
    }

    //return $pdf->download('omnifluencer.pdf');
    return $pdf->stream();
  }

  public function print_csv($id){

    if(Auth::user()->membership=='free' or Auth::user()->membership=='pro'){
      return abort(403);
    }

    $user = User::find(Auth::user()->id);
    $user->count_csv = $user->count_csv + 1;
    $user->save();

    $filename = 'omnifluencer';

    $compare = HistoryCompare::find($id);

    $account1 = Account::find($compare->account_id_1);
    $account2 = Account::find($compare->account_id_2);
    $account3 = Account::find($compare->account_id_3);
    $account4 = Account::find($compare->account_id_4);

    $data = array($account1,$account2,$account3,$account4
    );

    $Excel_file = Excel::create($filename, function($excel) use ($data) {
        $excel->sheet('list', function($sheet) use ($data) {
        
          $sheet->cell('B3', 'Engagement Rate'); 
          $sheet->cell('B4', 'Total Influenced'); 
          $sheet->cell('B5', 'Post'); 
          $sheet->cell('B6', 'Followers'); 
          $sheet->cell('B7', 'Following'); 
          $sheet->cell('B8', 'Last Post'); 
          $sheet->cell('B9', 'Avg Like Per Post'); 
          $sheet->cell('B10', 'Avg Comment Per Post'); 

          $cell = 'C';

          foreach ($data as $account) {
            if(is_null($account)){
              continue;
            }

            $username = '@'.$account->username;
            $sheet->cell($cell.'2', $username); 
            $sheet->cell($cell.'3', $account->eng_rate*100); 

            $influence = round($account->total_influenced);
            $sheet->cell($cell.'4', $influence); 

            $sheet->cell($cell.'5', $account->jml_post);
            $sheet->cell($cell.'6', $account->jml_followers); 
            $sheet->cell($cell.'7', $account->jml_following); 
            
            $sheet->cell($cell.'8', date("M d Y", strtotime($account->lastpost))); 
            $sheet->cell($cell.'9', $account->jml_likes);
            $sheet->cell($cell.'10', $account->jml_comments); 

            $cell++;
          }
          
          //$sheet->fromArray($data);
        });
      })->download('xlsx');
  }

  public function send_email(Request $request){
    $validator = $this->validator($request->all());

    if(!$validator->fails()){
      $compare = HistoryCompare::find($request->id);

      $account1 = Account::find($compare->account_id_1);
      $account2 = Account::find($compare->account_id_2);
      $account3 = Account::find($compare->account_id_3);
      $account4 = Account::find($compare->account_id_4);

      if($request->type=='pdf'){
        $data = array(
          'data' => array($account1,$account2,$account3,$account4),   
        );
      } else {
        $data = array($account1,$account2,$account3,$account4);
      }
      

      Mail::to($request->email)->queue(new ProfileCompareEmail($request->email,$request->type,$data));

      $arr['status'] = 'success';
      $arr['message'] = 'Email berhasil terkirim';
    } else {
      $arr['status'] = 'error';
      $arr['message'] = $validator->errors()->first();
    }

    return $arr;
  }

  public function delete_compare(Request $request){
    $compare = HistoryCompare::find($request->id)
                ->delete();

    $arr['status'] = 'success';
    $arr['message'] = 'Delete berhasil';

    return $arr;
  }

  public function delete_compare_bulk(Request $request){
    //Pengecekkan id 
    if(!isset($request->compareid)){
      $arr['status'] = 'error';
      $arr['message'] = 'Pilih history terlebih dahulu';

      return $arr;
    }

    foreach ($request->compareid as $id) {
      $compare = HistoryCompare::find($id)
                ->delete(); 
    }

    $arr['status'] = 'success';
    $arr['message'] = 'Delete berhasil';

    return $arr;
  }
}
