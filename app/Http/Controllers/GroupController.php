<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Save;

use Auth, Carbon;

class GroupController extends Controller
{
    public function index(){
      if(Auth::user()->membership=='free'){
        return abort(403);
      }
      return view('user.groups.index');
    }

    public function load_groups(Request $request){
      $groups = Group::where('user_id',Auth::user()->id)
                ->where('group_name','like','%'.$request->keywords.'%');

      if($request->from!=null and $request->to!=null){
        $dt = Carbon::createFromFormat("Y/m/d h:i:s", $request->from.' 00:00:00'); 

        $dt1 = Carbon::createFromFormat("Y/m/d h:i:s", $request->to.' 00:00:00');

        $groups = $groups->whereDate("created_at",">=",$dt)
              ->whereDate("created_at","<=",$dt1);
      }

      $groups = $groups->paginate(15);

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

      if(Auth::user()->membership=='free'){
        return abort(403);
      }
      
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

    public function delete_saved_profile_bulk(Request $request)
    {
      if(!isset($request->saveid)){
        $arr['status'] = 'error';
        $arr['message'] = 'Pilih akun terlebih dahulu';
        return $arr;
      }

      foreach ($request->saveid as $id) {
        $saved = Save::find($id)->delete(); 
      }

      $arr['status'] = 'success';
      $arr['message'] = 'Delete saved profile berhasil';

      return $arr;
    }

    public function delete_member_group(Request $request)
    {
      $member = Save::find($request->id)->delete();

      $arr['status'] = 'success';
      $arr['message'] = 'Delete group member berhasil';

      return $arr;
    }

    public function delete_member_group_bulk(Request $request)
    {
      if(!isset($request->saveid)){
        $arr['status'] = 'error';
        $arr['message'] = 'Pilih akun terlebih dahulu';
        return $arr;
      }

      foreach ($request->saveid as $id) {
        $member = Save::find($id)->delete();
      }

      $arr['status'] = 'success';
      $arr['message'] = 'Delete group member berhasil';

      return $arr;
    }

    public function delete_group(Request $request){
      if(!isset($request->groupid)){
        $arr['status'] = 'error';
        $arr['message'] = 'Pilih group terlebih dahulu';
        return $arr;
      }

      foreach ($request->groupid as $id) {
        $group = Group::find($id);

        $member = Save::where('group_id',$group->id)
                    ->where('user_id',Auth::user()->id)
                    ->delete();

        $group = $group->delete();
      }

      $arr['status'] = 'success';
      $arr['message'] = 'Delete group berhasil';

      return $arr;
    }

    public function delete_single_group(Request $request){
        $group = Group::find($request->id);

        $member = Save::where('group_id',$group->id)
                    ->where('user_id',Auth::user()->id)
                    ->delete();

        $group = $group->delete();  

        $arr['status'] = 'success';
        $arr['message'] = 'Delete group berhasil';

        return $arr;
    }

    public function edit_group(Request $request){
      $group = Group::find($request->id);
      $group->group_name = $request->name;
      $group->save();

      $arr['status'] = 'success';
      $arr['message'] = 'Edit group berhasil';

      return $arr; 
    }
}
