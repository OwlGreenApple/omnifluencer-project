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
use App\Coupons;
use DB;
use Session;

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

  public function thankyou_ovo(){
    return view('user.pricing.thankyou-ovo');
  }

  public function cekharga($namapaket, $price){
    $paket = array(
      'Pro Monthly' => 197000,
      'Premium Monthly' => 297000,
      'Pro Yearly' => 708000,
      'Premium Yearly' => 1068000,
      'Pro 15 hari' => 98500,
      
      'Premium 1 Months' => 197000,
      'Premium 2 Months' => 297000,
      'Premium 4 Months' => 397000,
      'Premium 6 Months' => 497000,
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
    Session::reflash();
    $stat = $this->cekharga($request->namapaket,$request->price);

    if($stat==false){
      return redirect("checkout/1")->with("error", "Paket dan harga tidak sesuai. Silahkan order kembali.");
    }

     /*$checkordertype = $this->checkOrderTypeValue($request->ordertype);
     if($checkordertype == false){
        return redirect("checkout/1")->with("error", "Mohon untuk tidak untuk mengubah value");
     }
     */
    
    return view('auth.register')->with(array(
			"price"=>$request->price,
			"namapaket"=>$request->namapaket,
      "coupon_code"=>$request->coupon_code,
		));
  }
  
  public function login_payment(Request $request){
    Session::reflash();
    $stat = $this->cekharga($request->namapaket,$request->price);

    if($stat==false){
      return redirect("checkout/1")->with("error", "Paket dan harga tidak sesuai. Silahkan order kembali.");
    }

     /*$checkordertype = $this->checkOrderTypeValue($request->ordertype);
     if($checkordertype == false){
        return redirect("checkout/1")->with("error", "Mohon untuk tidak untuk mengubah value");
     }
     */

    return view('auth.login')->with(array(
      "price"=>$request->price,
      "namapaket"=>$request->namapaket,
      "coupon_code"=>$request->coupon_code,
      /*"order_type"=>$request->ordertype,*/
    ));  
  }
 
  public function confirm_payment(Request $request){
    $stat = $this->cekharga($request->namapaket,$request->price);

    if($stat==false){
      return redirect("checkout/1")->with("error", "Paket dan harga tidak sesuai. Silahkan order kembali.");
    }

    /*
    $checkordertype = $this->checkOrderTypeValue($request->ordertype);

    if($checkordertype == false){
       return redirect("checkout/1")->with("error", "Mohon untuk tidak untuk mengubah value");
    } else {
        $ordertype = $this->orderValue($request->ordertype);
    }
    */

    /* check coupon and count total payment */
    $pricing = $request->price;
    $coupon = Session::get('coupon');
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
      $order->status = 0;
      $order->buktibayar = "";
      $order->keterangan = "";
      $order->pricing = $request->price;
      $order->id_coupon = $coupon['id_coupon'];
      $order->total = $coupon['total'];
      $order->discount = $coupon['discount'];
      $order->order_type = 0;
      $order->save();
      
      //mail order to user 
      $emaildata = [
          'order' => $order,
          'user' => $user,
          'nama_paket' => $request->namapaket,
          'no_order' => $order_number,
      ];

         Mail::send('emails.order', $emaildata, function ($message) use ($user,$order_number) {
          $message->from('info@omnifluencer.com', 'Omnifluencer');
          $message->to($user->email);
          if(env('APP_ENV')!=='local')
          {
            $message->bcc(['celebgramme.dev@gmail.com','it.axiapro@gmail.com']);
          }
          $message->subject('[Omnifluencer] Order Nomor '.$order_number);
        });
        if (!is_null($user->wa_number)){
            $message = null;
            $message .= '*Hi '.$user->name.'*,'."\n\n";
            $message .= "Berikut info pemesanan Omnilinkz :\n";
            $message .= '*No Order :* '.$order->no_order.''."\n";
            $message .= '*Nama :* '.$user->name.''."\n";
            $message .= '*Paket :* '.$order->package.''."\n";
            // $message .= '*Tgl Pembelian :* '.$dt->format('d-M-Y').''."\n";
            $message .= '*Total Biaya :*  Rp. '.str_replace(",",".",number_format($order->grand_total))."\n";

            $message .= "Silahkan melakukan pembayaran dengan bank berikut : \n\n";
            $message .= 'BCA (Sugiarto Lasjim)'."\n";
            $message .= '8290-812-845'."\n\n";
            
            $message .= "Harus diperhatikan juga, kalau jumlah yang di transfer harus *sama persis dengan nominal diatas* supaya _*kami lebih mudah memproses pembelianmu*_.\n\n";

            $message .= '*Sesudah transfer:*'."\n";
            $message .= '- *Login* ke https://omnilinkz.com'."\n";
            $message .= '- *Klik* Profile'."\n";
            $message .= '- Pilih *Order & Confirm*'."\n";
            $message .= '- *Upload bukti konfirmasi* disana'."\n\n";

            $message .= 'Terima Kasih,'."\n\n";
            $message .= 'Team Omnilinkz'."\n";
            $message .= '_*Omnilinkz is part of Activomni.com_';
            
            Helper::send_message_queue_system($user->wa_number,$message);
        }

        return view('user.pricing.thankyou');
         /*
         if($ordertype == 0){
            return view('user.pricing.thankyou');
         } else {
            return view('user.pricing.thankyou-ovo');
         }
         */
      
    //}
  }

  /* To check whether coupon available or not */
  public function checkCoupon(Request $request){
    /* Check whether coupon is valid or not And is empty or not */
    $coupon = $request->kupon;
    $pricing = $request->harga;
    $idpaket = $request->idpaket;
    $total = $pricing + $this->generateRandomPricingNumber($pricing);

    if(!empty($coupon))
    {
        $coupon_available = DB::table('coupons')->where(array(
            ['coupon_code','=',$coupon],
        ))->first();
    } else {
        $data['status'] = 'success';
        $data['total'] = str_replace(",",".",number_format($total));
        $coupon['id_coupon'] = 0;
        $coupon['discount'] = 0;
        $coupon['total'] = $total;
        Session::flash('coupon',$coupon);
        //Session::reflash();

        return response()->json($data);
    }

    if(is_null($coupon_available)){
       $data['status'] = 'error';
       $data['message'] = 'Kupon tidak tersedia';
       return response()->json($data);
    } else {
       return $this->getTotal($pricing,$coupon);
    }
  }

  /* get discount and total price after count with discount */
  public function getTotal($pricing,$coupon_code){
      $today = Carbon::now()->toDateString();
      $coupon = DB::table('coupons')->where(array(
            ['coupon_code','=',$coupon_code],
        ))->first();


      if(substr($coupon->valid_to,0,7)=='package'){
        $total = 0;
        $diskon = 0;
        $paket = "";
        $paketid = 0;
        $dataPaket = "";

        if ($coupon->valid_to == "package-premium-1") {
          $total = 197000;
          $paket = "Paket Premium 1 Bulan";
          $paketid = 5;
          $dataPaket = "Premium 1 Months";
        }
        if ($coupon->valid_to == "package-premium-2") {
          $total = 297000;
          $paket = "Paket Premium 2 Bulan";
          $paketid = 6;
          $dataPaket = "Premium 2 Months";
        }
        if ($coupon->valid_to == "package-premium-4") {
          $total = 397000;
          $paket = "Paket Premium 4 Bulan";
          $paketid = 7;
          $dataPaket = "Premium 4 Months";
        }
        if ($coupon->valid_to == "package-premium-6") {
          $total = 497000;
          $paket = "Paket Premium 6 Bulan";
          $paketid = 8;
          $dataPaket = "Premium 6 Months";
        }
        

        $data = array(
              'id_coupon' => $coupon->id,
              'discount' => 0,
              'total' => str_replace(",",".",number_format($total + $this->generateRandomPricingNumber($total))),
        );
        // selectbox ditambah dengan paket kupon 
        $data['status'] = 'success-paket';
        $data['message'] = 'Kupon berhasil dipakai & berlaku sekarang';
        $data['paket'] = $paket;
        $data['paketid'] = $paketid;
        $data['dataPaket'] = $dataPaket;
        $data['dataPrice'] = $total;
        
        Session::flash('coupon',$data);
        return response()->json($data);
      }
      else if($coupon->valid_to==''){
      }


      /* if valid then get discount from coupon */
      if($today <= $coupon->valid_until)
      {
          $discount_percent = $coupon->discount;
          $discount_value = $coupon->value;
      } else {
          $discount_percent = 0;
          $discount_value = null;
      } 

      /* determine which discount is available */
      if($discount_percent !== 0)
      {
          $discount = ($discount_percent/100) * $pricing;
          $total = $pricing - $discount;
      } 
      elseif($discount_value !== null)
      {
          $discount = $discount_value;
          $total = $pricing - $discount;
      } else {
          $discount = 0;
          $total = $pricing;
      }

       $data = array(
              'status'=>'success',
              'id_coupon' => $coupon->id,
              'discount' => $discount,
              'total' => str_replace(",",".",number_format($total + $this->generateRandomPricingNumber($total))),
        );
        Session::flash('coupon',$data);
        return response()->json($data);
    }

  /*To check generate random number according on status, payment_type, and total*/
  public function checkUniqueNumber($number,$order_type)
  {
    $check_pricing = Order::where('total','=',$number)
            ->where('order_type','=',$order_type)
            ->where('status','=',0)
            ->count();

    if($check_pricing > 0){
      return true;
    } else {
      return false;
    }
  }

  /*To generate random number for total*/
  function generateRandomPricingNumber($total) {
      $number = mt_rand(0, 1000); // better than rand()

      if ($this->checkUniqueNumber($number,$total) == true) {
          return generateRandomPricingNumber($total);
      }

      return $number;
  }

  /* Check valid value from bank order payment type */
  public function checkOrderTypeValue($ordertype)
  {
    if($ordertype == 'bt'){
      return true;
    } else {
      return false;
    }
  }

  public function orderValue($ordertype){
     if($ordertype == 'bt')
    {
       $ordervalue = 0;
    } /*elseif($ordertype == 'ov') {
       $ordervalue = 1;
    }*/
    return $ordervalue;
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
                ->leftJoin(env('DB_DATABASE').'.coupons', 'orders.id_coupon', '=', 'coupons.id') 
                ->select('orders.*','users.email','coupons.coupon_code')
                ->orderBy('orders.created_at','descend')
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
    } 
    else if(substr($order->package,0,7) === "Premium"){
      if($order->package=='Premium Monthly'){
        //$valid = new DateTime("+1 months");
        $valid = $this->add_time($user,"+1 months");
      } else if($order->package=='Premium Yearly'){
        //$valid = new DateTime("+12 months");
        $valid = $this->add_time($user,"+12 months");
      }
      else if($order->package=='Premium 1 Months'){
        $valid = $this->add_time($user,"+1 months");
      }
      else if($order->package=='Premium 2 Months'){
        $valid = $this->add_time($user,"+2 months");
      }
      else if($order->package=='Premium 4 Months'){
        $valid = $this->add_time($user,"+4 months");
      }
      else if($order->package=='Premium 6 Months'){
        $valid = $this->add_time($user,"+6 months");
      }

      /*'Premium 1 Months' => 197000,
      'Premium 2 Months' => 297000,
      'Premium 4 Months' => 397000,
      'Premium 6 Months' => 497000,*/

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

    // Mail::to($user->email)->bcc("celebgramme.dev@gmail.com")->queue(new ConfirmOrderMail($user,$order));
    $emaildata = [
        'order' => $order,
        'user' => $user,
    ];
    Mail::send('emails.confirm-order', $emaildata, function ($message) use ($user,$order) {
      $message->from('info@omnifluencer.com', 'Omnifluencer');
      $message->to($user->email);
      $message->subject('[Omnifluencer] Konfirmasi Order '.$order->no_order);
    });

    $arr['status'] = 'success';
    $arr['message'] = 'Order berhasil dikonfirmasi';
    $arr['response'] = $this->IsPay($user->email,18,1);

    return $arr;
  }

  public function index_upgrade(){
    return view('user.upgrade-account.index');
  }

  private function IsPay($email,$list_id,$is_pay)
    {
        $curl = curl_init();
        $data = array(
            'email'=>$email,
            'list_id'=>$list_id,
            'is_pay'=>$is_pay
        );

        if(env('APP_ENV') == 'local')
        {
          $url = 'http://192.168.88.177/wa-project/is_pay';
        }
        else
        {
          $url = 'https://activwa.com/dashboard/is_pay';
        }
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTREDIR => 3,
          CURLOPT_POSTFIELDS => json_encode($data),
          CURLOPT_HTTPHEADER => array('Content-Type:application/json'),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          $response = json_decode($response,true);
          return $response['response'];
        }
    }

/* end class */  
}
