<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

use App\User;
use App\UserLog;
use App\Referral;
use App\HistorySearch;
use App\Order;
use App\Notification;
use App\PointLog;

use App\Mail\ConfirmEmail;

use App\Helpers\Helper;
use App\Http\Controllers\OrderController;

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
    protected $coupon_code ='OMNIPRO2019';

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

    protected function cek_emailvalid(array $data)
    {
      return Validator::make($data, [
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
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
        $ordercont = new OrderController;

        /*if($data['namapaket']=='Pro 15 hari' and strtoupper($data['coupon_code'])==$this->coupon_code){
          //create order 
          $dt = Carbon::now();
          $order = new Order;
          $str = 'OMNI'.$dt->format('ymdHi');
          $order_number = Helper::autoGenerateID($order, 'no_order', $str, 3, '0');
          $order->no_order = $order_number;
          $order->user_id = $user->id;
          $order->package = $data['namapaket'];
          $order->jmlpoin = 0;
          $order->total = 0;
          $order->discount = $data['price'];
          $order->status = 2;
          $order->buktibayar = "";
          $order->keterangan = "";
          $order->save();

          $valid = $ordercont->add_time($user,"+15 days");

          $userlog = new UserLog;
          $userlog->user_id = $user->id;
          $userlog->type = 'membership';
          $userlog->value = 'pro';
          $userlog->keterangan = 'Order '.$order->package.'. From '.$user->membership.'('.$user->valid_until.') to pro('.$valid->format('Y-m-d h:i:s').')';
          //$userlog->keterangan = 'Order '.$order->package.'. From '.$user->membership.'('.$user->valid_until.') to pro('.$valid.')';
          $userlog->save();

          $user->valid_until = $valid;
          $user->membership = 'pro';
          $user->save();
        } else {*/
          $diskon = 0;
          $total = $data['price'];
          $kuponid = null;
          if($data['kupon']!=''){
            $arr = $ordercont->cek_kupon($data['kupon'],$data['price'],$data['idpaket']);

            if($arr['status']=='error'){
              return redirect("checkout/1")->with("error", $arr['message']);
            } else {
              $total = $arr['total'];
              $diskon = $arr['diskon'];
              if($arr['coupon']!=null){
                $kuponid = $arr['coupon']->id;
              }
            }
          }

          //create order 
          $dt = Carbon::now();
          $order = new Order;
          $str = 'OMNI'.$dt->format('ymdHi');
          $order_number = Helper::autoGenerateID($order, 'no_order', $str, 3, '0');
          $order->no_order = $order_number;
          $order->user_id = $user->id;
          $order->package = $data["namapaket"];
          $order->jmlpoin = 0;
          $order->coupon_id = $kuponid;
          $order->total = $data["price"];
          $order->discount = $diskon;
          $order->grand_total = $total;
          $order->status = 0;
          $order->buktibayar = "";
          $order->keterangan = "";
          $order->save();
          
          if($order->grand_total!=0){
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
              $message->bcc(['puspita.celebgramme@gmail.com','endah.celebgram@gmail.com']);
              $message->subject('[Omnifluencer] Order Nomor '.$order_number);
            });
          } else {
            $order->status = 2;
            $order->save();

            if(substr($order->package,0,3) === "Pro"){
              if($order->package=='Pro Monthly'){
                //$valid = new DateTime("+1 months");
                $valid = $ordercont->add_time($user,"+1 months");
              } else if($order->package=='Pro Yearly'){
                //$valid = new DateTime("+12 months");
                $valid = $ordercont->add_time($user,"+12 months");
              } else if($order->package=='Pro 15 hari'){
                $valid = $ordercont->add_time($user,"+15 days");
              }

              $userlog = new UserLog;
              $userlog->user_id = $user->id;
              $userlog->type = 'membership';
              $userlog->value = 'pro';
              $userlog->keterangan = 'Order '.$order->package.'. From '.$user->membership.'('.$user->valid_until.') to pro('.$valid->format('Y-m-d h:i:s').')';
              $userlog->save();

              $user->valid_until = $valid;
              $user->membership = 'pro';
            } else if(substr($order->package,0,7) === "Premium"){
              if($order->package=='Premium Monthly'){
                //$valid = new DateTime("+1 months");
                $valid = $ordercont->add_time($user,"+1 months");
              } else if($order->package=='Premium Yearly'){
                //$valid = new DateTime("+12 months");
                $valid = $ordercont->add_time($user,"+12 months");
              }

              $userlog = new UserLog;
              $userlog->user_id = $user->id;
              $userlog->type = 'membership';
              $userlog->value = 'premium';
              $userlog->keterangan = 'Order '.$order->package.'. From '.$user->membership.'('.$user->valid_until.') to premium('.$valid->format('Y-m-d h:i:s').')';
              $userlog->save();

              $user->valid_until = $valid;
              $user->membership = 'premium';
            }

            $user->save();
          }
          
        //}
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

    public function cek_email(Request $request){
      $validator = $this->cek_emailvalid($request->all());

      if($validator->fails()){
        $arr['status'] = 'error';
        $arr['message'] = $validator->errors()->first();
      } else {
        $arr['status'] = 'success';
        $arr['message'] = $validator->errors()->first();
      }

      return $arr;
    }

    public function register(Request $request){
      $validator = $this->validator($request->all());

      $ordercont = new OrderController;
      if($request->price<>""){
        $stat = $ordercont->cekharga($request->namapaket,$request->price);
        if($stat==false){
          return redirect("checkout/1")->with("error", "Paket dan harga tidak sesuai. Silahkan order kembali.");
        }
      }

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
          /*if($request->namapaket=='Pro 15 hari' and strtoupper($request->coupon_code)==$this->coupon_code){
            return redirect('thankyou-free');   
          } else {
            return redirect('thankyou');  
          }*/

          $arr = $ordercont->cek_kupon($request->kupon,$request->price,$request->idpaket);

          if($arr['status']=='success' and $arr['total']==0){
            return redirect('thankyou-free');  
          } else {
            return redirect('thankyou');  
          }

        } else {
          return redirect('/login')->with("success", "Thank you for your registration. Please check your inbox to verify your email address.");
          /*Auth::loginUsingId($user->id);
          return redirect('/dashboard')->with("success", "Thank you for your registration. Please check your inbox to verify your email address.");*/
        }
      } else {
        return redirect("register")->with("error",$validator->errors()->first());
      }
    }

    /*public function post_register(Request $request){
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
    }*/
}
