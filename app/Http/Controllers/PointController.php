<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PointLog;
use App\User;
use App\UserLog;

use App\Helpers\Helper;

use App\Http\Controllers\OrderController;

use Auth, DateTime;

class PointController extends Controller
{
    public function index(){
      return view('user.points.index');
    }

    public function load_points(Request $request){
      $points = PointLog::where('user_id',Auth::user()->id);

      $points = Helper::sorting($points,$request->status,$request->act);

      $points = $points->paginate(15);

      $arr['view'] = (string) view('user.points.content')
                        ->with('points',$points);
      $arr['pager'] = (string) view('user.points.pagination')
                        ->with('points',$points);

      return $arr;
    }

    public function index_redeem($id){
      $namapaket = '';
      $point = 0;

      switch ($id) {
        case 1 :
          $namapaket = 'Free Upgrade to Pro 1 Month';
          $point = 200;
          break;
        case 2 :
          $namapaket = 'Free Upgrade to Premium 1 Month';
          $point = 1000;
          break;
        /*case 3 :
          $namapaket = 'Upgrade to Pro Yearly';
          $point = 7500;
          break;*/
        /*case 4 :
          $namapaket = 'Upgrade to Premium Yearly';
          $point = 10000;
          break;*/
      }
      
      return view('user.points.index-redeem')
              ->with('idpoint',$id)
              ->with('namapaket',$namapaket)
              ->with('point',$point);
    }

    public function redeem_point(Request $request){
      $user = User::find(Auth::user()->id);
      $keterangan = '';

      switch ($request->id) {
        case 1 :
          //$valid = new DateTime("+1 months");
          $valid = OrderController::add_time($user,"+1 months");

          $userlog = new UserLog;
          $userlog->user_id = $user->id;
          $userlog->type = 'membership';
          $userlog->value = 'pro';
          $userlog->keterangan = 'Redeem Point Pro 1 Month. From '.$user->membership.'('.$user->valid_until.') to pro('.$valid->format('Y-m-d h:i:s').')';
          $userlog->save();

          $user->membership = 'pro';
          $user->valid_until = $valid;
          $keterangan = 'Free Upgrade to Pro 1 Month';
          $point = 200;
          break;
        case 2 :
          //$valid = new DateTime("+1 months");
          $valid = OrderController::add_time($user,"+1 months");

          $userlog = new UserLog;
          $userlog->user_id = $user->id;
          $userlog->type = 'membership';
          $userlog->value = 'premium';
          $userlog->keterangan = 'Redeem Point Premium 1 Month. From '.$user->membership.'('.$user->valid_until.') to premium('.$valid->format('Y-m-d h:i:s').')';
          $userlog->save();

          $user->membership = 'premium';
          $user->valid_until = $valid;
          $keterangan = 'Free Upgrade to Premium 1 Month';
          $point = 1000;
          break;
        /*case 3 :
          $user->membership = 'pro';
          $user->valid_until = new DateTime("+12 months");
          $keterangan = 'Upgrade to Pro Yearly';
          $point = 7500;
          break;*/
        /*case 4 :
          $user->membership = 'premium';
          $user->valid_until = new DateTime("+12 months");
          $keterangan = 'Upgrade to Premium Yearly';
          $point = 10000;
          break;*/
      }

      if(Auth::user()->point<$point){
        $arr['status'] = 'error';
        $arr['message'] = 'Poin tidak mencukupi';
        $arr['sisapoin'] = 0;

        return $arr;
      }

      $pointlog = new PointLog;
      $pointlog->user_id = Auth::user()->id;
      $pointlog->jml_point = $point;
      $pointlog->poin_before = Auth::user()->point;
      $pointlog->poin_after = Auth::user()->point-$point;
      $pointlog->keterangan = $keterangan;
      $pointlog->save();

      $user->point = $user->point - $point;
      $user->save();
      
      $arr['status'] = 'success';
      $arr['message'] = 'Redeem point berhasil';
      $arr['sisapoin'] = $user->point;

      return $arr;
    }
}
