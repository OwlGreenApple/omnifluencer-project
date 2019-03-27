<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\UserLog;
use App\Notification;

use App\Mail\ExpiredMembershipMail;

use Mail,DateTime;

class CheckMembership extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:membership';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Membership Valid Until';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $users = User::All();

      foreach ($users as $user) {
        $now = new DateTime();
        $date = new DateTime($user->valid_until);
        $interval = $date->diff($now)->format('%d');
        var_dump($interval);
        var_dump($date<$now);
        if($interval==5){
          Mail::to($user->email)->queue(new ExpiredMembershipMail($user->email,$user));
          
          $notif = new Notification;
          $notif->user_id = $user->id;
          $notif->notification = 'Masa aktif membership akan berakhir';
          $notif->keterangan = 'Masa aktif membership Anda akan berakhir dalam 5 hari. Segera perpanjang melalui order maupun redeem point.';
          $notif->type = 'promo';
          $notif->save();
        }

        if($date < $now){
          Mail::to($user->email)->queue(new ExpiredMembershipMail($user->email,$user));

          $user->membership = 'free';
          $user->valid_until = null;
          $user->save();

          $userlog = new UserLog;
          $userlog->user_id = $user->id;
          $userlog->type = 'membership';
          $userlog->value = $user->membership;
          $userlog->keterangan = 'Cron check membership valid_until';
          $userlog->save();

          $notif = new Notification;
          $notif->user_id = $user->id;
          $notif->notification = 'Masa aktif membership berakhir';
          $notif->keterangan = 'Masa aktif membership Anda telah berakhir. Segera perpanjang melalui order maupun redeem point.';
          $notif->type = 'promo';
          $notif->save();
        }
      }
    }
}
