<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Helpers\Helper;
use App\Http\Controllers\OrderController;

use App\User;
use App\UserLog;
use App\Order;

use Crypt, Carbon, Mail, Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $coupon_code ='OMNIPRO2019';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request,$user)
    {
      if ($request->price<>"") {
        $ordercont = new OrderController;
        $stat = $ordercont->cekharga($request->namapaket,$request->price);
        if($stat==false){
          return redirect("checkout/1")->with("error", "Paket dan harga tidak sesuai. Silahkan order kembali.");
        }

        /*if($request->namapaket=='Pro 15 hari' and strtoupper($request->coupon_code)==$this->coupon_code){
          //create order 
          $dt = Carbon::now();
          $order = new Order;
          $str = 'OMNI'.$dt->format('ymdHi');
          $order_number = Helper::autoGenerateID($order, 'no_order', $str, 3, '0');
          $order->no_order = $order_number;
          $order->user_id = $user->id;
          $order->package = $request->namapaket;
          $order->jmlpoin = 0;
          $order->total = 0;
          $order->discount = $request->price;
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

          return redirect('thankyou-free');   
        } else {*/
          $diskon = 0;
          $total = $request->price;
          $kuponid = null;
          if($request->kupon!=''){
            $arr = $ordercont->cek_kupon($request->kupon,$request->price,$request->idpaket);
            
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
          $order->package = $request->namapaket;
          $order->jmlpoin = 0;
          $order->coupon_id = $kuponid;
          $order->total = $request->price;
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
                'nama_paket' => $request->namapaket,
                'no_order' => $order_number,
            ];
            Mail::send('emails.order', $emaildata, function ($message) use ($user,$order_number) {
              $message->from('no-reply@omnifluencer.com', 'Omnifluencer');
              $message->to($user->email);
              $message->bcc(['puspita.celebgramme@gmail.com','endah.celebgram@gmail.com']);
              $message->subject('[Omnifluencer] Order Nomor '.$order_number);
            });

            return redirect('/thankyou');
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
            return redirect('/thankyou-free');
          }
          
        //}
        
      }
    }

    public function verifyEmail($cryptedcode){
      try {
        $decryptedcode = Crypt::decrypt($cryptedcode);
        $data = json_decode($decryptedcode);
        $user = User::where("email","=",$data->email)->first();
        if (!is_null($user)) {
          // Check customer email and status
          if (!$user->is_confirm){
            // Check Verification Code
            if ($user->confirm_code == $data->confirm_code){
              $reg_date = Carbon::createFromFormat('Y-m-d H:i:s', $data->register_time);
                // Change customer status to verified, then redirect to Home
                $user->is_confirm = 1;
                $user->save();
                
                //return redirect('/login')->with("success","Welcome to Omnifluencer! Thank you for confirming your e-mail address.");  
                Auth::loginUsingId($user->id);
                return redirect('/dashboard')->with("success", "Thank you for confirming your email.");
            }
            else{
              return redirect(404);
            }
          }
          else{
            return redirect(404);
          }
        }
        else{
          return redirect(404);
        }
      } catch (DecryptException $e) {
        return redirect(404);
      }
    }
}
