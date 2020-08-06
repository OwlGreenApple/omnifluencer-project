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
use App\Rules\CheckUserPhone;

use App\Helpers\Helper;
use App\Http\Controllers\OrderController;

use Carbon, Crypt, Mail,Auth, Session;

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
        'code_country' => ['required'],
        'wa_number' => ['required','min:6','max:18',new CheckUserPhone($data['code_country'],null)],
        // 'password' => ['required', 'string', 'min:6', 'confirmed'],
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
      Session::reflash();
      $calling_code = str_replace('+','',$data['code_country']);
      $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'gender'=> $data['gender'],
                'password' => Hash::make($data['password']),
                'username' => '',
                'wa_number' => $calling_code.$data['wa_number'],
                'country_code' => $data['code_country']
            ]);
      $user->referral_link = uniqid().md5($user->id);
      $user->point = 10;
      $user->save();
      
      //New system, to activrespon list
      if(env('APP_ENV') <> 'local'){
        $temp = $this->sendToActivrespon($calling_code.$data['wa_number'],$data['name'],$data['email']);
        $temp = $this->sendToCelebmail($data['name'],$data['email']);
      }

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
      
      if ($data['price']<>"" && Session::has('coupon')) {

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
          $coupon = Session::get('coupon');

          $dt = Carbon::now();
          $order = new Order;
          //$ordertype = $ordercontroller->orderValue($data['ordertype']);
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
          $order->order_type = 0;
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
            $message->from('info@omnifluencer.com', 'Omnifluencer');
            $message->to($user->email);
            if(env('APP_ENV')!=='local')
            {
              $message->bcc(['celebgramme.dev@gmail.com','endah.celebgram@gmail.com']);
            }  
            $message->subject('[Omnifluencer] Order Nomor '.$order_number);
          });
          if (!is_null($user->wa_number)){
              $message = null;
              $message .= '*Hi '.$user->name.'*,'."\n\n";
              $message .= "Berikut info pemesanan Omnifluencer :\n";
              $message .= '*No Order :* '.$order->no_order.''."\n";
              $message .= '*Nama :* '.$user->name.''."\n";
              $message .= '*Paket :* '.$order->package.''."\n";
              // $message .= '*Tgl Pembelian :* '.$dt->format('d-M-Y').''."\n";
              $message .= '*Total Biaya :*  Rp. '.str_replace(",",".",number_format($order->total))."\n";

              $message .= "Silahkan melakukan pembayaran dengan bank berikut : \n\n";
              $message .= 'BCA (Sugiarto Lasjim)'."\n";
              $message .= '8290-812-845'."\n\n";
              
              $message .= "Harus diperhatikan juga, kalau jumlah yang di transfer harus *sama persis dengan nominal diatas* supaya _*kami lebih mudah memproses pembelianmu*_.\n\n";

              $message .= '*Sesudah transfer:*'."\n";
              $message .= '- *Login* ke https://omnifluencer.com'."\n";
              $message .= '- *Klik* Profile'."\n";
              $message .= '- Pilih *Order & Confirm*'."\n";
              $message .= '- *Upload bukti konfirmasi* disana'."\n\n";

              $message .= 'Terima Kasih,'."\n\n";
              $message .= 'Team Omnifluencer'."\n";
              $message .= '_*Omnifluencer is part of Activomni.com_';
              
              Helper::send_message_queue_system($user->wa_number,$message);
          }
          
          
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
      Session::reflash();
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

    public function register(Request $request)
    {
      Session::reflash();
      $ordertype = 0;
      $validator = $this->validator($request->all());

      if($request->price<>"" && Session::has('coupon'))
      {
        $ordercont = new OrderController;
        $stat = $ordercont->cekharga($request->namapaket,$request->price);
        if($stat==false){
          return redirect("checkout/1")->with("error", "Paket dan harga tidak sesuai. Silahkan order kembali.");
        }
      }

      /* to prevent if user change value of bank transfer 
       $checkordertype = $ordercont->checkOrderTypeValue($request->ordertype);
         if($checkordertype == false){
            return redirect("checkout/1")->with("error", "Mohon untuk tidak untuk mengubah value");
         } else {
            $ordertype = $ordercont->orderValue($request->ordertype);
         }
       */

      // if(!$validator->fails() && Session::has('coupon')) {
      if(!$validator->fails()) {
        //random password
        $pas = $request->email.$request->name;
        $gh = substr($pas, 0,6);
        $chrnd =substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,5);
        $password = str_replace(' ','', $gh.$chrnd);
        
        $arrRequest = $request->all();
        $arrRequest['password'] = $password;
        $user = $this->create($arrRequest);
        // $user = $this->create($request->all());

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
          'password' => $password,
        ];
        
        Mail::to($user->email)->bcc("celebgramme.dev@gmail.com")->send(new ConfirmEmail($emaildata));
        
        if (!is_null($user->wa_number)){
            $message = null;
            $message .= '*Hi '.$user->name."*, \n\n";
            $message .= '*Welcome to Omnifluencer*'."\n";
            $message .= "Terima kasih sudah memilih Omnifluencer sebagai _Tool yang bisa membantu kamu lebih dekat dengan klienmu._ Jika kamu sudah dapat WA ini berarti akunmu sudah terdaftar database kami. \n\n";
            $message .= "Berikut info login kamu : \n";
            $message .= "*Nama :* ".$user->name."\n";
            $message .= "*Email :* ".$user->email."\n";
            $message .= '*Password :* '.$password."\n\n";
            $message .= '*Link login:* ';
            $message .= 'https://omnifluencer.com/login'."\n\n";
            $message .= "Oh iya, kalau ada yang ingin ditanyakan, jangan sungkan menghubungi kami di *WA 0818-318-368*. \n\n";
            $message .= "Salam hangat, \n";
            $message .= 'Tim Omnifluencer';

            
            Helper::send_message_queue_system($user->wa_number,$message);
        }

        if ($request->price<>"") {
          if($request->namapaket=='Pro 15 hari' and strtoupper($request->coupon_code)==$this->coupon_code){
            return redirect('thankyou-free');   
          } else if($ordertype == 0) {
              return redirect('thankyou');  
          } /*else if($ordertype == 1) {
            return redirect(route('thankyouovo'));  
          } */ 
        } else {
          $response = $this->sendToActivWA($arrRequest['wa_number'],$arrRequest['name'],$arrRequest['email']);
          Session::forget('error');
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
        //random password
        $pas = $request->email.$request->name;
        $gh = substr($pas, 0,6);
        $chrnd =substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,5);
        $password = str_replace(' ','', $gh.$chrnd);
        
        $arrRequest = $request->all();
        $arrRequest['password'] = $password;
        $user = $this->create($arrRequest);
        // $user = $this->create($request->all());

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
          'password' => $password,
        ];
        
        Mail::to($user->email)->bcc("celebgramme.dev@gmail.com")->queue(new ConfirmEmail($emaildata));
        Session::forget('error');
        return redirect('/login')->with("success", "Thank you for your registration. Please check your inbox to verify your email address.");
      } else {
        return redirect("register")->with("error",$validator->errors()->first());
      }
    }

    public function sendToActivrespon($wa_no,$name,$email)
    {
      $curl = curl_init();

        $data = array(
            'list_name'=>'3f5r6oxv',
            'name'=>$name,
            'email'=>$email,
            'phone_number'=>$wa_no,
        );

       $url = "https://activrespon.com/dashboard/entry-google-form";

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode($data),
          CURLOPT_HTTPHEADER => array('Content-Type:application/json'),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        /* if ($err) {
          echo "cURL Error #:" . $err;
         } else {
           echo $response."\n";
         }
         */
    }

  public function sendToCelebmail($name,$email)
  {
    $fname = "";
    $lname = "";
    $arr_name = explode(" ",$name);
    if (isset($arr_name[0])) {
      $fname = $arr_name[0];
    }
    if (isset($arr_name[1])) {
      $lname = $arr_name[1];
    }
    $lname = "";
    $ch = curl_init();

    //list gabungan curl_setopt($ch, CURLOPT_URL, 'https://celebmail.id/mail/index.php/lists/oj028pjaah5ab/subscribe');
    curl_setopt($ch, CURLOPT_URL, 'https://celebmail.id/mail/index.php/lists/ys998ocexn532/subscribe');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    $post = array(
        'EMAIL' => $email,
        'FNAME' => $fname,
        'LNAME' => $lname,
        'NEWSLETTER_CONSENT' => '1'
    );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
  }

  public function sendToActivWA($wa_no,$name,$email)
    {
      $curl = curl_init();

        $data = array(
            'list_id'=> 18, //activwa list_id for omnifluencer
            'wa_no'=>$wa_no,
            'name'=>$name,
            'email'=>$email
        );

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://activwa.com/dashboard/private-list",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode($data),
          CURLOPT_HTTPHEADER => array('Content-Type:application/json'),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          return "cURL Error #:" . $err;
        } else {
          return $response."\n";
        }
    }

/* End Controller */
}
