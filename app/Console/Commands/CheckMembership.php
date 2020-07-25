<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\UserLog;
use App\Notification;
use App\Helpers\Helper;

use Carbon\Carbon;

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
        
        $interval = Carbon::parse($user->valid_until)->diffInDays(Carbon::now());
        
        /* old code $now = new DateTime();
        $date = new DateTime($user->valid_until);
        $interval = $date->diff($now)->format('%d');
        var_dump($interval);
        var_dump($date<$now);*/
        
        if($interval==5){
          Mail::to($user->email)->queue(new ExpiredMembershipMail($user->email,$user));
          
          $notif = new Notification;
          $notif->user_id = $user->id;
          $notif->notification = 'Masa aktif membership akan berakhir';
          $notif->keterangan = 'Masa aktif membership Anda akan berakhir dalam 5 hari. Segera perpanjang melalui order maupun redeem point.';
          $notif->type = 'promo';
          $notif->save();
          if (!is_null($user->wa_number)){
              $message = null;
              $message .= "*Selamat ".$user->name.",* \n\n";
              $message .= "Gimana kabarnya? \n \n";
              $message .= "Kami mau kasih tau kalau *waktu berlangganan kamu akan habis 5 hari lagi*. \n \n";
              $message .= "Jangan sampai kamu _kehabisan waktu berlangganan saat menggunakan Omnilinkz_ yah \n \n";
              $message .= "Kamu bisa langsung perpanjang dengan klik link dibawah ini \n";
              $message .= "*►https://omnifluencer.com/pricing* \n \n";

              $message .= "_Oh iya, kalau kamu pertanyaan jangan ragu untuk menghubungi kami di_  \n";
              $message .= "*WA 0817-318-368* \n\n";

              $message .= 'Terima Kasih,'."\n\n";
              $message .= 'Team Omnifluencer'."\n";
              $message .= '_*Omnifluencer is part of Activomni.com_';
              Helper::send_message_queue_system($user->wa_number,$message);
          }
        }

        // if($date < $now){
        if( Carbon::parse($user->valid_until)->lt(Carbon::now()) && !is_null($user->valid_until) ){
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
