<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Save;

use Auth;

class GroupController extends Controller
{
    public function index(){
      return view('user.groups.index');
    }

    public function load_groups(){
      $groups = Group::where('user_id',Auth::user()->id)
                ->paginate(15);

      $arr['view'] = (string) view('user.groups.content')
                        ->with('groups',$groups);
      $arr['pager'] = (string) view('user.groups.pagination')
                        ->with('groups',$groups);
      return $arr;
    }

    public function index_list($id, $group_name){
      return view('user.list-group.index')
              ->with('id_group',$id)
              ->with('group_name',$group_name);
    }

    public function load_list_group(Request $request){
      $accounts = Save::join('accounts','saves.account_id','accounts.id')
                ->select('saves.*','accounts.id as accountid','accounts.username','accounts.prof_pic')
                ->where('saves.user_id',Auth::user()->id)
                ->where('group_id',$request->id)
                ->paginate(15);

      $arr['view'] = (string) view('user.list-group.content')
                        ->with('accounts',$accounts);
      $arr['pager'] = (string) view('user.list-group.pagination')
                        ->with('accounts',$accounts);
      return $arr;
    }

    public function index_saved(){
      return view('user.saved-profile.index');
    }

    public function load_saved_accounts(Request $request){
      $accounts = Save::join('accounts','saves.account_id','accounts.id')
                ->select('saves.*','accounts.id as accountid','accounts.username','accounts.prof_pic')
                ->where('saves.user_id',Auth::user()->id)
                ->where('group_id',0)
                ->paginate(15);

      $arr['view'] = (string) view('user.saved-profile.content')
                        ->with('accounts',$accounts);
      $arr['pager'] = (string) view('user.saved-profile.pagination')
                        ->with('accounts',$accounts);
      return $arr;
    }

    public function delete_saved_profile(Request $request)
    {
      $saved = Save::find($request->id)->delete();

      $arr['status'] = 'success';
      $arr['message'] = 'Delete saved profile berhasil';

      return $arr;
    }
}
