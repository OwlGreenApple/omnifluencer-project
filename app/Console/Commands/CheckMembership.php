<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use DateTime;

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

        if($date < $now){
          $user->membership = 'free';
          $user->valid_until = null;
          $user->save();
        }
      }
    }
}
