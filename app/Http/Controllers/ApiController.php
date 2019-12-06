<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use App\AccountLog;
use App\HistorySearch;
use App\User;
use App\Group;
use App\Save;
use App\Subscribe;
use App\Coupon;
use App\User;

use App\Helpers\Helper;
use App\Helpers\InstagramHelper;

use App\Mail\ProfileEmail;
use App\Mail\ProfileBulkEmail;

use Auth,PDF,Excel,Mail,Validator,Carbon,Datetime;

class ApiController extends Controller
{
  public function generate_coupon(Request $request)
  {
    $data = json_decode($request->getContent(),true);

    $user = User::where("email",$data['email'])->first();
    if (!is_null($user)) {
      do
      {
        $karakter= 'abcdefghjklmnpqrstuvwxyz123456789';
        $string = 'special-';
        for ($i = 0; $i < 7 ; $i++) {
          $pos = rand(0, strlen($karakter)-1);
          $string .= $karakter{$pos};
        }
        $coupon = Coupon::where("kodekupon","=",$string)->first();
      } while (!is_null($coupon));
      $coupon = new Coupon;
      $coupon->kodekupon = $string;
      $coupon->diskon_value = 0;
      $coupon->diskon_percent = 0;
      $coupon->valid_until = new DateTime('+2 days');
      $coupon->valid_to = $data['package'];
      $coupon->keterangan = "Kupon AutoGenerate Package User";
      $coupon->package_id = 4;
      $coupon->user_id = $user->id;
      $coupon->save();
    }
    else {
      $arr['coupon_code'] = "";
      $arr['is_error'] = 1;
      return json_encode($arr);
    }
    
    $arr['coupon_code'] = $string;
    $arr['is_error'] = 0;
    return json_encode($arr);
  }
}
