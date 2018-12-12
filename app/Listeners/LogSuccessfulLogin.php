<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;

use App\User;
use Auth, DateTime;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Login $event)
    {
      $currentTime = new DateTime();
      $user = $event->user;
      $last_login = new DateTime($user->last_login);

      /*$gaptime = $last_login->diff($currentTime);
      //dd((int)$gaptime->format("%H"));
      if((int)$gaptime->format("%H") > 0){
        $user->point = $user->point + 1;
        $user->save();
        session()->put('getpoin','');
      }*/
      $user->last_login = date('Y-m-d H:i:s', time());
      $user->save();

      config(['session.lifetime' => 120]);
    }
}
