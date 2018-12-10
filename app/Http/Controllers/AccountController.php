<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use App\HistorySearch;

use Auth;
class AccountController extends Controller
{
  public function index(){
    return view('user.search.index');
  }

  public function load_search(Request $request){
    if($request->keywords==''){
      $account = Account::find(1);
    } else {
      $account = Account::where('username',$request->keywords)->first();

      $request->session()->put('account_search', $account->username);

      if(Auth::check()){
        $history = new HistorySearch;
        $history->account_id = $account->id;
        $history->user_id = Auth::user()->id;
        $history->save();
      }
    }

    $arr['view'] = (string) view('user.search.content-akun')->with('account',$account);

    return $arr;
  }

  public function load_history_search(){
    if(Auth::check()){
      $accounts = HistorySearch::join('accounts','accounts.id','=','history_searchs.account_id')
          ->select('history_searchs.*','accounts.username','accounts.prof_pic')
          ->where('history_searchs.user_id',Auth::user()->id)
          ->orderBy('history_searchs.created_at','desc')->get();
    }

    $arr['view'] = (string) view('user.search.content-history')->with('accounts',$accounts);

    return $arr;
  }

  public function delete_history(Request $request){
    $history = HistorySearch::find($request->id)->delete();

    $arr['status'] = 'success';
    $arr['message'] = '';

    return $arr;
  }
}
