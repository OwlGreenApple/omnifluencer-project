<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use App\HistorySearch;
use App\User;
use App\UserLog;
use App\Group;
use App\Save;
use App\Order;
use App\Notification;

use App\Mail\ConfirmOrderMail;

use App\Helpers\Helper;

use Auth,Mail,Validator,Storage,DateTime;
use Carbon\Carbon;

class OrderController extends Controller
{ 
  protected $coupon_code ='OMNIPRO2019';

  public function pricing(){
    return view('user.pricing.pricing');
  }

  public function thankyou(){
    return view('user.pricing.thankyou');
  }

  public function thankyou_free(){
    return view('user.pricing.thankyou_free');
  }

  public function cekharga($namapaket, $price){
    $paket = array(
      'Pro Monthly' => 197000,
      'Premium Monthly' => 297000,
      'Pro Yearly' => 708000,
      'Premium Yearly' => 1068000,
      'Pro 15 hari' => 98500,
    );

    if(isset($paket[$namapaket])){
      if($price!=$paket[$namapaket]){
        return false; 
      } else {
        return true;
      }
    } else {
      return false;
    }
  }

  public function checkout($id){
    return view('user.pricing.checkout')->with(array(
			'id'=>$id,		
		));
  }
  
  public function checkout_free(){
    return view('user.pricing.checkout_free');
  }

  public function register_payment(Request $request){
    $stat = $this->cekharga($request->namapaket,$request->price);

    if($stat==false){
      return redirect("checkout/1")->with("error", "Paket dan harga tidak sesuai. Silahkan order kembali.");
    }

    return view('auth.register')->with(array(
			"price"=>$request->price,
			"namapaket"=>$request->namapaket,
      "coupon_code"=>$request->coupon_code,
		));
  }
  
  public function login_payment(Request $request){
    $stat = $this->cekharga($request->namapaket,$request->price);

    if($stat==false){
      return redirect("checkout/1")->with("error", "Paket dan harga tidak sesuai. Silahkan order kembali.");
    }

    return view('auth.login')->with(array(
      "price"=>$request->price,
      "namapaket"=>$request->namapaket,
      "coupon_code"=>$request->coupon_code,
    ));  
  }

  public function confirm_payment(Request $request){
    $stat = $this->cekharga($request->namapaket,$request->price);

    if($stat==false){
      return redirect("checkout/1")->with("error", "Paket dan harga tidak sesuai. Silahkan order kembali.");
    }

    if($request->ordertype !== 0 || $request->ordertype !== 1 )
    {
       return redirect("checkout/1")->with("error", "Mohon untuk tidak untuk mengubah value");
    }

    $user = Auth::user();

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

      $valid = $this->add_time($user,"+15 days");

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

      return view('user.pricing.thankyou_free');

    } else {*/
      //create order 
      $dt = Carbon::now();
      $order = new Order;
      $str = 'OMNI'.$dt->format('ymdHi');
      $order_number = Helper::autoGenerateID($order, 'no_order', $str, 3, '0');
      $order->no_order = $order_number;
      $order->user_id = $user->id;
      $order->package = $request->namapaket;
      $order->jmlpoin = 0;
      $order->total = $request->price;
      $order->discount = 0;
      $order->status = 0;
      $order->order_type = $request->ordertype;
      $order->buktibayar = "";
      $order->keterangan = "";
      $order->save();
      
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
          if(env('APP_ENV')!=='local')
          {
            $message->bcc(['celebgramme.dev@gmail.com','it.axiapro@gmail.com']);
          }
          $message->subject('[Omnifluencer] Order Nomor '.$order_number);
        });

         if($request->ordertype == 0){
            return view('user.pricing.thankyou');
         } else {
            return view('user.pricing.thankyou-ovo');
         }
      
    //}
  }

  /*To check generate random number according on status, payment_type, and total*/
  public function checkUniqueNumber($number,$order_type)
  {
    $check_pricing = Order::where('total','=',$number)
            ->where('order_type','=',$order_type)
            ->where('status',0)
            ->count();

    if($check_pricing > 0){
      return true;
    } else {
      return false;
    }
  }

  /*To generate random number for total*/
  function generateRandomPricingNumber($payment) {
      $number = mt_rand(0, 1000); // better than rand()

      if ($this->checkUniqueNumber($number,$payment) == true) {
          return generateRandomPricingNumber($payment);
      }

      return $number;
  }

  public function index_order(){
    return view('user.order.index');
  }

  public function load_order(Request $request){
    $orders = Order::where('user_id',Auth::user()->id);

    if($request->status=='not-sort'){
      $orders = $orders->orderBy('created_at','descend');
    } else {
      $orders = Helper::sorting($orders,$request->status,$request->act);
    }
                
    $orders = $orders->paginate(15);

    $arr['view'] = (string) view('user.order.content')
                      ->with('orders',$orders);
    $arr['pager'] = (string) view('user.order.pagination')
                      ->with('orders',$orders); 

    return $arr;
  }

  public function confirm_payment_order(Request $request)
  {
      $order = Order::find($request->id_confirm);
      $folder = Auth::user()->email.'/buktibayar';

      if($order->status==0){
        $order->status = 1;

        if($request->hasFile('buktibayar')){
          $path = Storage::disk('s3')->putFileAs($folder, $request->file('buktibayar'),$order->no_order.'.jpg','public');
          
          $order->buktibayar = $path;
        } else {
          $arr['status'] = 'error';
          $arr['message'] = 'Upload file buktibayar terlebih dahulu';
          return $arr;
        }

        $order->keterangan = $request->keterangan;
        $order->save();

        $arr['status'] = 'success';
        $arr['message'] = 'Konfirmasi pembayaran berhasil';
      } else {
        $arr['status'] = 'error';
        $arr['message'] = 'Order telah atau sedang dikonfirmasi oleh admin';
      }

      return $arr;
  }

  public function index_list_order(){
    return view('admin.list-order.index');
  }

  public function load_list_order(Request $request){
    $orders = Order::join(env('DB_DATABASE').'.users','orders.user_id','users.id')  
                ->select('orders.*','users.email')
                ->orderBy('created_at','descend')
                ->get();

    $arr['view'] = (string) view('admin.list-order.content')
                      ->with('orders',$orders);
    /*$arr['pager'] = (string) view('admin.list-order.pagination')
                      ->with('orders',$orders); */

    return $arr;
  }

  public static function add_time($user,$time){
    if(is_null($user->valid_until)){
      $valid = new DateTime($time);
    } else {
      $now = new DateTime();
      $uservalid = new DateTime($user->valid_until);

      if($uservalid<$now){
        $valid = new DateTime($time);
      } else {
        $uservalid = strtotime($user->valid_until);
        $valid = new DateTime (date("Y-m-d", strtotime($time, $uservalid)));
      }
    }

    return $valid;
  }

  public function confirm_order(Request $request){
    $order = Order::find($request->id);
    $order->status = 2;
    
    $user = User::find($order->user_id);
    $valid=null;

    if(substr($order->package,0,3) === "Pro"){
      if($order->package=='Pro Monthly'){
        //$valid = new DateTime("+1 months");
        $valid = $this->add_time($user,"+1 months");
      } else if($order->package=='Pro Yearly'){
        //$valid = new DateTime("+12 months");
        $valid = $this->add_time($user,"+12 months");
      }

      $userlog = new UserLog;
      $userlog->user_id = $user->id;
      $userlog->type = 'membership';
      $userlog->value = 'pro';
      $userlog->keterangan = 'Order '.$order->package.'. From '.$user->membership.'('.$user->valid_until.') to pro('.$valid->format('Y-m-d h:i:s').')';
      //$userlog->keterangan = 'Order '.$order->package.'. From '.$user->membership.'('.$user->valid_until.') to pro('.$valid.')';
      $userlog->save();

      $user->valid_until = $valid;
      $user->membership = 'pro';
    } else if(substr($order->package,0,7) === "Premium"){
      if($order->package=='Premium Monthly'){
        //$valid = new DateTime("+1 months");
        $valid = $this->add_time($user,"+1 months");
      } else if($order->package=='Premium Yearly'){
        //$valid = new DateTime("+12 months");
        $valid = $this->add_time($user,"+12 months");
      }

      $userlog = new UserLog;
      $userlog->user_id = $user->id;
      $userlog->type = 'membership';
      $userlog->value = 'premium';
      $userlog->keterangan = 'Order '.$order->package.'. From '.$user->membership.'('.$user->valid_until.') to premium('.$valid->format('Y-m-d h:i:s').')';
      //$userlog->keterangan = 'Order '.$order->package.'. From '.$user->membership.'('.$user->valid_until.') to premium('.$valid.')';
      $userlog->save();

      $user->valid_until = $valid;
      $user->membership = 'premium';
    }

    $user->save();
    $order->save();

    $notif = new Notification;
    $notif->user_id = $user->id;
    //$notif->notification = 'Order '.$order->no_order.' telah dikonfirmasi';
    $notif->notification = 'Order telah dikonfirmasi';
    $notif->type = 'order';
    $notif->keterangan = 'Order '.$order->no_order.' telah dikonfirmasi oleh admin. Terimakasih dan selamat menikmati layanan kami.';
    $notif->save();

    // Mail::to($user->email)->queue(new ConfirmOrderMail($user,$order));
    $emaildata = [
        'order' => $order,
        'user' => $user,
    ];
    Mail::send('emails.confirm-order', $emaildata, function ($message) use ($user,$order) {
      $message->from('no-reply@omnifluencer.com', 'Omnifluencer');
      $message->to($user->email);
      $message->subject('[Omnifluencer] Konfirmasi Order '.$order->no_order);
    });

    $arr['status'] = 'success';
    $arr['message'] = 'Order berhasil dikonfirmasi';

    return $arr;
  }

  public function index_upgrade(){
    return view('user.upgrade-account.index');
  }
}
