<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Account;
use App\Http\Controllers\AccountController;

class CrawlFollowing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:following';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To crawl DB data to update following';

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
      //AFTER PASS 1X24 HOURS MAKE CRAWLED 0 AGAIN
      $accounts = Account::all();
      $act = new AccountController;

      foreach($accounts as $row){
         $act->following_pagination($row->ig_id, null,$row->jml_following);
      }
    }
}
