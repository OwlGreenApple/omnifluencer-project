<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:account';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update data account';

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

    public function igcallback($url){
      $c = curl_init();

      curl_setopt($c, CURLOPT_URL, $url);
      curl_setopt($c, CURLOPT_REFERER, $url);
      curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
      $page = curl_exec($c);
      curl_close($c);
        
      $arr_res = json_decode($page,true);
      return $arr_res;
    }
    
    public function handle()
    {
      $accounts = IG_Account::orderBy('voting','desc')->get();

      foreach($accounts as $account){
        //kalo belum ada informasi ig_id ngejalanin pake username di database
        if($account->ig_id!=null){
          $url = "http://cmx.space/get-user-data-byid/".$account->ig_id;
        } else {
          $url = "http://cmx.space/get-user-data/".$account->username;
        }
      
        $arr_res = $this->igcallback($url);
        
        if($arr_res!=null){
          $account->ig_id = $arr_res["pk"];
          //replace username di database kalo beda sama yang diambil
          if($account->username!=$arr_res["username"]){
            //ngecek kalo username clb nya udah diganti sama user atau belum
            if($account->username==$account->username_clb){
              $account->username_clb = $arr_res["username"];
            }

            $account->username = $arr_res["username"];
          }

          $account->profpic = $arr_res["hd_profile_pic_url_info"]["url"];
          $account->profpic_clb = $arr_res["hd_profile_pic_url_info"]["url"];
          $account->following = $arr_res["following_count"];
          $account->followers = $arr_res["follower_count"];
          $account->jmlpost = $arr_res["media_count"];
          //var_dump($arr_res);
          var_dump($arr_res["username"]);

          $url2 = "http://cmx.space/get-user-feed/".$arr_res["username"];
          $arr_res2 = $this->igcallback($url2);

          if($arr_res2!=null){
            $count = 0;
            $jmllike = 0;
            $jmlcomment = 0;
            //var_dump($arr_res2);
            foreach ($arr_res2 as $arr) {
              var_dump($count);
              if($count>=6){
                break;
              } else {
                $jmllike = $jmllike + $arr["like_count"];
                var_dump('like = '.$arr["like_count"]);
                if(array_key_exists('comment_count', $arr)){
                  $jmlcomment = $jmlcomment + $arr["comment_count"];  
                  var_dump('comment = '.$arr["comment_count"]);
                } 
                $count++;
              }
            }
            //hitung rata2 like + comment di 6 post terakhir 
            $ratalike = $jmllike/$count;
            $ratacomment = $jmlcomment/$count;

            var_dump("taken = ".$arr_res2[0]["taken_at"]);
            var_dump(date("d/m/Y",$arr_res2[0]["taken_at"]));

            $account->lastpost = date("Y-m-d h:i:s",$arr_res2[0]["taken_at"]);
            $account->jmllike = floor($ratalike);
            $account->jmlcomment = floor($ratacomment);
          
            var_dump('ratalike = '.floor($ratalike));
            var_dump('ratacomment = '.floor($ratacomment));
            //var_dump($arr_res2);
            //var_dump($arr_res2["j"]);
          }

          $account->save();
        }
        sleep(0.1);
      }
    }
}
