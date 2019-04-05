<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserLog;
use App\PointLog;
use App\Referral;

class UserController extends Controller
{
    public function index(){
      return view('admin.list-user.index');
    }

    public function load_user(Request $request){
      $users = User::where('is_admin',0)->get();

      $arr['view'] = (string) view('admin.list-user.content')->with('users',$users);

      return $arr;
    }

    public function point_log(Request $request){
      $logs = PointLog::where('user_id',$request->id)
              ->get();

      $arr['view'] = (string) view('admin.list-user.content-poin')->with('points',$logs);

      return $arr;
    }

    public function referral_log(Request $request){
      $logs = Referral::join('users','referrals.user_id_taker','users.id')
              ->select('referrals.*','users.name','users.email')
              ->where('user_id_giver',$request->id)
              ->get();

      $arr['view'] = (string) view('admin.list-user.content-referral')->with('referrals',$logs);

      return $arr;
    }

    public function view_log(Request $request){
      $logs = UserLog::where('user_id',$request->id)
              ->get();

      $arr['view'] = (string) view('admin.list-user.content-log')->with('logs',$logs);

      return $arr;
    }
}
