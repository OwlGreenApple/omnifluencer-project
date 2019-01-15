<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PointLog;

use Auth;

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

    }
}
