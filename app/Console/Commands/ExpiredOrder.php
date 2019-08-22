<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;

class ExpiredOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expired:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To make order from users expire if they not make any paid off yet after a day';

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
        $today = Carbon::now();
        $check_time = DB::connection('mysql2')->table('orders')->select('created_at','id')->get();
        foreach($check_time as $tm){
            $expired = Carbon::parse($tm->created_at)->addDay();
            if($today >= $expired) 
            {
                DB::connection('mysql2')->table('orders')->where('id',$tm->id)->update(['status' => 2]);
            }
        }
    }
/* End of class */    
}
