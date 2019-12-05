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

    $user_id = UserList::where('id',$data['list_id'])->first();
    if(is_null($user_id))
    {
      $msg['is_error'] = 'Id not available, it may Deleted!!!';
      return json_encode($msg);
    }
    $userid = $user_id->user_id;
    $cust = new Customer;
    $cust->user_id = $userid;
    $cust->list_id = $data['list_id'];
    $cust->name = $data['name'];
    $cust->wa_number = $data['wa_no'];
    $cust->save();

    if($cust->save())
    {
      $msg['is_error'] = 0;
    }
    else
    {
      $msg['is_error'] = 1;
    }
    return json_encode($msg);
  }
}
