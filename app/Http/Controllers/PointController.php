<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PointLog;
use App\User;

use Auth, DateTime;

class PointController extends Controller
{
    public function index(){
      return view('user.points.index');
    }

    public function load_points(){
      $points = PointLog::where('user_id',Auth::user()->id)->paginate(15);

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
          $namapaket = 'Upgrade to Pro Monthly';
          $point = 2500;
          break;
        case 2 :
          $namapaket = 'Upgrade to Pro Yearly';
          $point = 7500;
          break;
        case 3 :
          $namapaket = 'Upgrade to Premium Monthly';
          $point = 5000;
          break;
        case 4 :
          $namapaket = 'Upgrade to Premium Yearly';
          $point = 10000;
          break;
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
          $user->membership = 'pro';
          $user->valid_until = new DateTime("+1 months");
          $keterangan = 'Upgrade to Pro Monthly';
          $point = 2500;
          break;
        case 2 :
          $user->membership = 'pro';
          $user->valid_until = new DateTime("+12 months");
          $keterangan = 'Upgrade to Pro Yearly';
          $point = 7500;
          break;
        case 3 :
          $user->membership = 'premium';
          $user->valid_until = new DateTime("+1 months");
          $keterangan = 'Upgrade to Premium Monthly';
          $point = 5000;
          break;
        case 4 :
          $user->membership = 'premium';
          $user->valid_until = new DateTime("+12 months");
          $keterangan = 'Upgrade to Premium Yearly';
          $point = 10000;
          break;
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

      $user->point = $user->point - $point;
      $user->save();

      $pointlog->poin_after = Auth::user()->point;
      $pointlog->keterangan = $keterangan;
      $pointlog->save();
      
      $arr['status'] = 'success';
      $arr['message'] = 'Redeem point berhasil';
      $arr['sisapoin'] = $user->point;

      return $arr;
    }
}
