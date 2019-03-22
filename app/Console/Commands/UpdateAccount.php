<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Account;
use App\AccountLog;

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

    public function igcallback($url,$mode='json'){
      $c = curl_init();

      curl_setopt($c, CURLOPT_URL, $url);
      curl_setopt($c, CURLOPT_REFERER, $url);
      curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
      $page = curl_exec($c);
      curl_close($c);
      
      if($mode=='json'){
        $arr_res = json_decode($page,true);
        return $arr_res;
      } else {
        return $page;
      }
    
    }
    
    public function handle()
    {
      $accounts = Account::orderBy('voting','desc')->get();

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
            $account->username = $arr_res["username"];
          }

          $account->fullname = $arr_res["full_name"];
          $account->prof_pic = $arr_res["hd_profile_pic_url_info"]["url"];
          $account->jml_following = $arr_res["following_count"];
          $account->jml_followers = $arr_res["follower_count"];
          $account->jml_post = $arr_res["media_count"];

          var_dump($arr_res["username"]);

          $count = 0;
          $jmllike = 0;
          $jmlcomment = 0;
          $end_cursor = null;
          $private = false;
          $lastpost = null;
          //var_dump($arr_res2);

          do {
            $url2 = "http://cmx.space/get-user-feed/".$arr_res["username"].'/'.$end_cursor;
            $arr_res2 = $this->igcallback($url2);    

            $url3 = "http://cmx.space/get-user-feed-maxid/".$arr_res["username"].'/'.$end_cursor;
            $arr_res3 = $this->igcallback($url3,'string');
            var_dump('end_cursor = '.$arr_res3);
            $end_cursor = $arr_res3;

            if($end_cursor=='InstagramAPI\Response\UserFeedResponse: Not authorized to view user.'){
              $private = true;
              break;
            }

            if(!is_null($arr_res2) and !empty($arr_res2))
            {
              if($count==0){
                $lastpost = date("Y-m-d h:i:s",$arr_res2[0]["taken_at"]);
              }

              foreach ($arr_res2 as $arr) {
                if($count>=20){
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
            } else {
              if($count==0){
                $private = true;
              }
              break;
            }
          } while ($count<20);
            
          //hitung rata2 like + comment di 20 post terakhir 
          //check akun private atau nggak
          var_dump('Last post ='.$lastpost);
          if($private==false){
            $ratalike = $jmllike/$count;
            $ratacomment = $jmlcomment/$count;
          } else {
            $ratalike = 0;
            $ratacomment = 0;
          }

          $account->lastpost = $lastpost;
          $account->jml_likes = floor($ratalike);
          $account->jml_comments = floor($ratacomment);
          //$account->eng_rate = ($account->jml_likes + $account->jml_comments)/$account->jml_followers;

          if($account->jml_followers>0){
            $account->eng_rate = ($jmllike + $jmlcomment)/($account->jml_followers*20);
            $account->total_influenced = $account->eng_rate*$account->jml_followers;
          }
          
          var_dump('ratalike = '.floor($ratalike));
          var_dump('ratacomment = '.floor($ratacomment));
          var_dump('Eng rate = '.round($account->eng_rate*100,2));
          //var_dump($arr_res2);
          //var_dump($arr_res2["j"]);
          

          $account->save();

          $accountlog = new AccountLog;
          $accountlog->account_id = $account->id;
          $accountlog->jml_followers = $account->jml_followers;
          $accountlog->jml_following = $account->jml_following;
          $accountlog->jml_post = $account->jml_post;
          $accountlog->lastpost = $account->lastpost;
          $accountlog->jml_likes = $account->jml_likes;
          $accountlog->jml_comments = $account->jml_comments;
          $accountlog->total_calc = $account->total_calc;
          $accountlog->total_compare = $account->total_compare;
          if($account->jml_followers>0){
            $accountlog->eng_rate = $account->eng_rate;
            $accountlog->total_influenced = $account->total_influenced;  
          }
          
          $accountlog->save();
        }
        sleep(0.1);
      }
    }
}
