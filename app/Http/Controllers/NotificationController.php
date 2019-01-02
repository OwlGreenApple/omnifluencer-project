<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;

use Auth;

class NotificationController extends Controller
{
    public function index(){
      $updatenotif = Notification::where('user_id',Auth::user()->id)
                      ->where('is_read',0)
                      ->update(array('is_read' => 1));

      $notif = Notification::where('user_id',Auth::user()->id)
                ->orderBy('created_at','desc')
                ->paginate(15);

      return view('user.notifications.index')
              ->with('notification',$notif);
    }
}
