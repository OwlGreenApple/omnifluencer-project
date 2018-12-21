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
}
