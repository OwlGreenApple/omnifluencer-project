<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Account;
use App\ListFollowing;

use App\Http\Controllers\AccountController;
use App\Helpers\Helper;
use App\Helpers\InstagramHelper;

class FollowingList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'list:following';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To run instagram calculate by username';

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
        $act = new AccountController;
        $followinglist = ListFollowing::where('is_executed',0)->get();

        if($followinglist->count() > 0)
        {
            foreach($followinglist as $rows) 
            {
                $arr_res = json_decode(InstagramHelper::get_user_data($rows->username),true);
                if(is_array($arr_res))
                {
                    $act->create_account($arr_res);
                    ListFollowing::where('username',$rows->username)->update(['is_executed'=>1]);
                } 
                sleep(2);
            }
        }
    }

/* end command class */    
}
