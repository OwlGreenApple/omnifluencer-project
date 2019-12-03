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
                'username' => '',
                'wa_number' => $data['wa_number'],
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
        if($data['namapaket']=='Pro 15 hari' and strtoupper($data['coupon_code'])==$this->coupon_code){
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

          $ordercont = new OrderController;
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
        } else {
          //create order from user when doing register

           /* check coupon and count total payment */
          $ordercontroller = new OrderController;
          $pricing = $data['price'];
          $checkCoupon = $ordercontroller->checkCoupon($data['coupon_code']);
          if($checkCoupon == true){
             $coupon = $ordercontroller->getTotal($pricing,$data['coupon_code']);
          } else {
             $coupon['id_coupon'] = 0;
             $coupon['discount'] = 0;
             $coupon['total'] = $pricing + $ordercontroller->generateRandomPricingNumber($pricing);
          }

          $dt = Carbon::now();
          $order = new Order;
          $ordertype = $ordercontroller->orderValue($data['ordertype']);
          $str = 'OMNI'.$dt->format('ymdHi');
          $order_number = Helper::autoGenerateID($order, 'no_order', $str, 3, '0');
          $order->no_order = $order_number;
          $order->user_id = $user->id;
          $order->package = $data["namapaket"];
          $order->jmlpoin = 0;
          $order->discount = 0;
          $order->status = 0;
          $order->buktibayar = "";
          $order->keterangan = "";
          $order->pricing = $pricing;
          $order->order_type = $ordertype;
          $order->id_coupon = $coupon['id_coupon'];
          $order->total = $coupon['total'];
          $order->discount = $coupon['discount'];
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
            if(env('APP_ENV')!=='local')
            {
              $message->bcc(['celebgramme.dev@gmail.com','endah.celebgram@gmail.com']);
            }  
            $message->subject('[Omnifluencer] Order Nomor '.$order_number);
          });
        }
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
      if(!is_numeric($request->wa_number)){
        return redirect("register")->with("error", " No WA harus angka");
      }

      $validator = $this->validator($request->all());

      if($request->price<>""){
        $ordercont = new OrderController;
        $stat = $ordercont->cekharga($request->namapaket,$request->price);
        if($stat==false){
          return redirect("checkout/1")->with("error", "Paket dan harga tidak sesuai. Silahkan order kembali.");
        }
      }

      /* to prevent if user change value of bank transfer */
       $checkordertype = $ordercont->checkOrderTypeValue($request->ordertype);
         if($checkordertype == false){
            return redirect("checkout/1")->with("error", "Mohon untuk tidak untuk mengubah value");
         } else {
            $ordertype = $ordercont->orderValue($request->ordertype);
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
          if($request->namapaket=='Pro 15 hari' and strtoupper($request->coupon_code)==$this->coupon_code){
            return redirect('thankyou-free');   
          } else if($ordertype == 0) {
              return redirect('thankyou');  
          } else if($ordertype == 1) {
            return redirect(route('thankyouovo'));  
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

    public function post_register(Request $request){
      if(!is_numeric($request->wa_number)){
        return redirect("register")->with("error", " No WA harus angka");
      }
      
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
