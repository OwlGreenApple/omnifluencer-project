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

use Auth,Mail,Validator,Storage,DateTime;
use Carbon\Carbon;

class OrderController extends Controller
{
  public function pricing(){
    return view('user.pricing.pricing');
  }

  public function checkout($id){
    return view('user.pricing.checkout')->with(array(
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

    return view('user.pricing.thankyou');
  }

  public function index_order(){
    return view('user.order.index');
  }

  public function load_order(Request $request){
    $orders = Order::where('user_id',Auth::user()->id)
                ->orderBy('created_at','descend')
                ->paginate(15);

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
        }

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
                ->paginate(15);

    $arr['view'] = (string) view('admin.list-order.content')
                      ->with('orders',$orders);
    $arr['pager'] = (string) view('admin.list-order.pagination')
                      ->with('orders',$orders); 

    return $arr;
  }

  public function confirm_order(Request $request){
    $order = Order::find($request->id);
    $order->status = 2;
    
    $user = User::find($order->user_id);
    $valid=null;
    if(substr($order->package,0,3) === "Pro"){
      if($order->package=='Pro Monthly'){
        $valid = new DateTime("+1 months");
      } else if($order->package=='Pro Yearly'){
        $valid = new DateTime("+12 months");
      }
      $user->valid_until = $valid;
      $user->membership = 'pro';

    } else if(substr($order->package,0,7) === "Premium"){
      if($order->package=='Premium Monthly'){
        $valid = new DateTime("+1 months");
      } else if($order->package=='Premium Yearly'){
        $valid = new DateTime("+12 months");
      }
      $user->valid_until = $valid;
      $user->membership = 'premium';
    }

    $user->save();
    $order->save();

    $arr['status'] = 'success';
    $arr['message'] = 'Order berhasil dikonfirmasi';

    return $arr;
  }
}
