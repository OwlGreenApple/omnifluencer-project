<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use App\AccountLog;
use App\HistorySearch;
use App\Group;
use App\Save;
use App\Subscribe;
use App\Coupons;
use App\User;

use App\Helpers\Helper;
use App\Mail\SendMailActivWA;

use Auth,PDF,Excel,Mail,Validator,Carbon,Datetime;

class ApiController extends Controller
{
  public function generate_coupon(Request $request)
  {
    $data = json_decode($request->getContent(),true);

    $user = User::where("email",$data['email'])->first();
    if (!is_null($user)) {
      $coupon = Coupon::where("valid_to",$data['package'])
                ->where("user_id",$user->id)
                ->first();
      if (!is_null($coupon)) {
        $arr['coupon_code'] = $coupon->coupon_code;
        $arr['is_error'] = 0;
        return json_encode($arr);
      }
      else {
        do
        {
          $karakter= 'abcdefghjklmnpqrstuvwxyz123456789';
          $string = 'special-';
          for ($i = 0; $i < 7 ; $i++) {
            $pos = rand(0, strlen($karakter)-1);
            $string .= $karakter{$pos};
          }
          $coupon = Coupons::where("coupon_code","=",$string)->first();
        } while (!is_null($coupon));
        $coupon = new Coupons;
        $coupon->coupon_code = $string;
        $coupon->value = 0;
        $coupon->discount = 0;
        $coupon->valid_until = new DateTime('+2 days');
        $coupon->valid_to = $data['package'];
        $coupon->coupon_description = "Kupon AutoGenerate Package User";
        $coupon->package_id = 0;
        $coupon->user_id = $user->id;
        $coupon->save();
      }
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

  public function sendmailfromactivwa(Request $request)
  {
      $data = json_decode($request->getContent(),true);
      Mail::to($data['mail'])->bcc("celebgramme.dev@gmail.com")->queue(new SendMailActivWA($data['emaildata'],$data['subject']));
  }

  public function testmail()
    {
        $curl = curl_init();
        $data = array(
            'mail'=>'Papercut@user.com',
            'emaildata'=>'package-premium-6',
            'subject'=>'package',
        );
        $url = 'http://localhost/omnifluencer/sendmailfromactivwa';

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
          echo $response;
          //return json_decode($response,true);
        }
    }

/* end class */  
}
