<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HistoryCompare;

use Auth;

class CompareController extends Controller
{
    public function index_history(){
      return view('user.compare-history.index');
    }

    public function load_history_compare(){
      $compares = HistoryCompare::where('user_id',Auth::user()->id)
                  ->orderBy('created_at','desc')
                  ->paginate(15);

      $arr['view'] = (string) view('user.compare-history.content')
                        ->with('compares',$compares);
      $arr['pager'] = (string) view('user.compare-history.pagination')
                        ->with('compares',$compares);
      return $arr;
    }
}
