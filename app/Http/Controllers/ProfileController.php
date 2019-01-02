<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use Auth,Validator,Storage,Hash;

class ProfileController extends Controller
{
    protected function validator(array $data)
    {
      $rules = [
        'fullname' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
      ];

      return Validator::make($data, $rules);
    }

    public function index_edit(){
      $user = Auth::user();

      return view('user.edit-profile.index')
              ->with('user',$user);
    }

    public function edit_profile(Request $request){
      dd($request->all());
      $user = User::find(Auth::user()->id);

      $validator = $this->validator($request->all());

      if(!$validator->fails()){
        $user->name = $request->fullname;
        //$user->username = $request->username;
        $user->username = 'tes';
        $user->email = $request->email;
        //$user->location = $request->location;

        if($request->hasFile('fileprofpic')){
          if($user->profpic!=''){
            Storage::delete($user->profpic);
          }

          $path = Storage::putFile('profpic', $request->file('profpic'),'public');
          
          $user->profpic = $path;
        }

        $user->save();

        $arr['status'] = 'success';
        $arr['message'] = 'Edit profile berhasil';
      } else {
        $arr['status'] = 'error';
        $arr['message'] = $validator->errors()->first();
      }

      return $arr;
    }

    public function index_changepass(){
      $user = Auth::user();

      return view('user.change-password.index')
              ->with('user',$user);
    }

    public function change_password(Request $request){
      if($request->password!=$request->confirm) {
        $arr['status'] = 'error';
        $arr['message'] = 'Password yang Anda masukkan salah';
      } else {
        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($request->password);
        $user->save();

        $arr['status'] = 'success';
        $arr['message'] = 'Password berhasil diubah';
      }

      return $arr;
    }

    public function index_dashboard(){
      return view('user.dashboard.index');
    }
}
