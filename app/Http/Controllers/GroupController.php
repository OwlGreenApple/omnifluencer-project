<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;

class GroupController extends Controller
{
    public function index(){
      return view('user.group.index');
    }

    public function load_group(){
      $groups = Group::where('user_id',Auth::user()->id)
                ->get();

      $arr['view'] = (string) view('user.group.content')
                        ->with('groups',$groups);
      $arr['pager'] = (string) view('user.group.pagination')
                        ->with('groups',$groups);
      return $arr;
    }
}
