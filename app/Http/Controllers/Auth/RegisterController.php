<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

use App\User;
use App\Referral;
use App\HistorySearch;

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
    protected $cookie_search = "history_search";

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
      $user->referral_link = uniqid().md5($user->id);
      $user->point = 10;
      $user->save();
      
      if(isset($_COOKIE['referral_link'])) {
        $user_giver = User::where('referral_link',$_COOKIE['referral_link'])->first();
        $referral = new Referral; 
        $referral->user_id_taker = $user->id;
        $referral->user_id_giver = $user_giver->id;
        $referral->save();

        $user_giver->point = $user_giver->point+20;
        $user_giver->save();
      } 

      return $user;
    }

    protected function check_history($user){
      if(isset($_COOKIE[$this->cookie_search])) {
        $cookie_value = json_decode($_COOKIE[$this->cookie_search], true);

        foreach ($cookie_value as $cookie) {
          $history = new HistorySearch;
          $history->account_id = $cookie;
          $history->user_id = $user->id;
          $history->save();
        }
      }
    }

    public function register(Request $request){
      $validator = $this->validator($request->all());

      if(!$validator->fails()) {
        $user = $this->create($request->all());

        $register_time = Carbon::now()->toDateTimeString();
        $confirmcode = Hash::make($user->email.$register_time);
        $user->confirm_code = $confirmcode;
        $user->save();
        
        $this->check_history($user);

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
