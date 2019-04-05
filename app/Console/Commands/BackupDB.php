<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

class BackupDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup Database';

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
      $hour = date('H');
      //$datas = DB::connection('mysql')->statement("CREATE DATABASE IF NOT EXISTS `activpos_affiliate_".$hour."` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;");

      //$database = $this->argument('activpos_affiliate_'.$hour);
      //$password = $this->argument('');
      //$command = sprintf('mysqldump <newproject> -u forge -p\'%s\' | mysql new %s', $password, $database);
      $command = sprintf('mysqldump newproject | mysql activpos_affiliate_1');
      exec($command);
    }
}
