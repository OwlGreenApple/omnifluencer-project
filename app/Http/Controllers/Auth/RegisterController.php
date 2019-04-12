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
use App\Order;
use App\Notification;
use App\PointLog;

use App\Mail\ConfirmEmail;

use App\Helpers\Helper;

use Carbon, Crypt, Mail,Auth;

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
      
      $pointlog = new PointLog;
      $pointlog->user_id = $user->id;
      $pointlog->jml_point = 10;
      $pointlog->poin_before = 0;
      $pointlog->poin_after = 10;
      $pointlog->keterangan = 'You get an extra point from Register';
      $pointlog->save();

      if(isset($_COOKIE['referral_link'])) {
        $user_giver = User::where('referral_link',$_COOKIE['referral_link'])->first();
        $referral = new Referral; 
        $referral->user_id_taker = $user->id;
        $referral->user_id_giver = $user_giver->id;
        $referral->save();

        /* Notif + point log user taker */
        $notif = new Notification;
        $notif->user_id = $user->id;
        $notif->notification = 'Extra +10 points for you';
        $notif->type = 'point';
        $notif->keterangan = 'Congratulations! You get an extra +10 points from registering your account';
        $notif->save();

        /* Notif + point log user giver */
        $notif = new Notification;
        $notif->user_id = $user_giver->id;
        $notif->notification = 'Extra +20 points for you';
        $notif->type = 'point';
        $notif->keterangan = 'Congratulations! You get an extra +20 points from referral link ('.$user->email.')';
        $notif->save();

        $pointlog = new PointLog;
        $pointlog->user_id = $user_giver->id;
        $pointlog->jml_point = 20;
        $pointlog->poin_before = $user_giver->point;
        $pointlog->poin_after = $user_giver->point + 10;
        $pointlog->keterangan = 'Referral Link from '.$user->email;
        $pointlog->save();

        $user_giver->point = $user_giver->point+20;
        $user_giver->save();

      } 
      
      if ($data['price']<>"") {
        //create order 
        $dt = Carbon::now();
        $order = new Order;
        $str = 'OMNI'.$dt->format('ymdHi');
        $order_number = Helper::autoGenerateID($order, 'no_order', $str, 3, '0');
        $order->no_order = $order_number;
        $order->user_id = $user->id;
        $order->package = $data["namapaket"];
        $order->jmlpoin = 0;
        $order->total = $data['price'];
        $order->discount = 0;
        $order->status = 0;
        $order->buktibayar = "";
        $order->keterangan = "";
        $order->save();
        
        //mail order to user 
        $emaildata = [
            'order' => $order,
            'user' => $user,
            'nama_paket' => $data['namapaket'],
            'no_order' => $order_number,
        ];
        Mail::send('emails.order', $emaildata, function ($message) use ($user,$order_number) {
          $message->from('no-reply@omnifluencer.com', 'Omnifluencer');
          $message->to($user->email);
          $message->subject('[Omnifluencer] Order Nomor '.$order_number);
        });
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
        
        Mail::to($user->email)->send(new ConfirmEmail($emaildata));

        if ($request->price<>"") {
          return redirect('thankyou');
        } else {
          return redirect('/login')->with("success", "Thank you for your registration. Please check your inbox to verify your email address.");
          /*Auth::loginUsingId($user->id);
          return redirect('/dashboard')->with("success", "Thank you for your registration. Please check your inbox to verify your email address.");*/
        }
      } else {
        return redirect("register")->with("error",$validator->errors()->first());
      }
    }

    public function post_register(Request $request){
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
