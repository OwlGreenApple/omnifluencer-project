<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use App\HistorySearch;
use App\User;
use App\Group;
use App\Save;
use App\Order;

use App\Helpers\Helper;

use Auth,Mail,Validator;
use Carbon\Carbon;

class OrderController extends Controller
{
  protected $cookie_search = "history_search";
  protected $cookie_delete = "delete_search";

  public function pricing(){
    return view('user.order.pricing');
  }

  public function checkout($id){
    return view('user.order.checkout')->with(array(
			'id'=>$id,		
		));
  }
  
  public function register_payment(Request $request){
    return view('auth.register')->with(array(
			"price"=>$request->price,
			"namapaket"=>$request->namapaket,
		));
  }
  
  public function confirm_payment(Request $request){
    $user = Auth::user();
    
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
      $message->subject('[Omnifluencer] Order Nomor '.$order_number);
    });

    return view('user.order.thankyou');
  }
}
