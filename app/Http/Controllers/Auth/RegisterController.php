<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

use App\Mail\ConfirmEmail;

use Carbon, Crypt, Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    { 
      $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'gender'=> $data['gender'],
                'password' => Hash::make($data['password']),
                'username' => 'tes',
            ]);
      $user->point = 10;
      $user->save();
      
      return $user;
    }

    public function register(Request $request){
      $validator = $this->validator($request->all());

      if(!$validator->fails()) {
        $user = $this->create($request->all());

        $register_time = Carbon::now()->toDateTimeString();
        $confirmcode = Hash::make($user->email.$register_time);
        $user->confirm_code = $confirmcode;
        $user->save();
        
        $secret_data = [
          'email' => $user->email,
          'register_time' => $register_time,
          'confirm_code' => $confirmcode,
        ];
      
        $emaildata = [
          'url' => url('/verifyemail/').'/'.Crypt::encrypt(json_encode($secret_data)),
          'user' => $user,
          'password' => $request->password,
        ];
        
        Mail::to($user->email)->queue(new ConfirmEmail($emaildata));
        return redirect('/login')->with("success", "Thank you for your registration. Please check your inbox to verify your email address.");
      } else {
        return redirect("register")->with("error",$validator->errors()->first());
      }
    }
}
