<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Account;
//use App\AccountLog;

use App\Helpers\InstagramHelper;

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

      foreach($accounts as $account)
      {
        //kalo belum ada informasi ig_id ngejalanin pake username di database
        if($account->ig_id !== null){
          // $url = "http://cmx.space/get-user-data-byid/".$account->ig_id;
          $arr_res = json_decode(InstagramHelper::getUserDataByid($account->ig_id),true);
        } else {
          // $url = "http://cmx.space/get-user-data/".$account->username;
          $arr_res = json_decode(InstagramHelper::get_user_data($account->username),true);
        }
      
        // $arr_res = $this->igcallback($url);
        
        // if($arr_res!=null){
        if(is_array($arr_res))
        {
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

          //var_dump($arr_res["username"]);

          $jmlvideoview = InstagramHelper::get_video_views($arr_res["username"]);
          $arr_res2 = InstagramHelper::get_user_profile($arr_res["username"]);
          if ($arr_res2["error_message"]=="") {
            $count = $arr_res2["count"];
            $jmllike = $arr_res2["jmllike"];
            $jmlcomment = $arr_res2["jmlcomment"];
            $private = $arr_res2["private"];
            $lastpost = $arr_res2["lastpost"];

            if($count == 0)
            {
              $count = 1;
            }
              
            //var_dump($arr_res["username"].'-----'.$jmllike.'-----'.$jmlcomment);

            //hitung rata2 like + comment di 20 post terakhir 
            //check akun private atau nggak
            //var_dump('Last post ='.$lastpost);
            if($private==false){
              $ratalike = $jmllike/$count;
              $ratacomment = $jmlcomment/$count;
              $ratavideoview = $jmlvideoview/$count;
            } else {
              $ratalike = 0;
              $ratacomment = 0;
              $ratavideoview = 0;
            }

            $account->lastpost = $lastpost;
            $account->jml_likes = floor($ratalike);
            $account->jml_comments = floor($ratacomment);
            $account->jmlvideoview = $jmlvideoview;
            //$account->eng_rate = ($account->jml_likes + $account->jml_comments)/$account->jml_followers;

            if($account->jml_followers > 0){
              $account->eng_rate = ($jmllike + $jmlcomment)/($account->jml_followers);
              $account->video_view_rate = ($jmlvideoview)/($account->jml_followers);
              $account->total_influenced = $account->eng_rate*$account->jml_followers;
            }
            
            /*
            var_dump('ratalike = '.floor($ratalike));
            var_dump('ratacomment = '.floor($ratacomment));
            var_dump('Eng rate = '.round($account->eng_rate*100,2));
            */

            $account->save();
          }

          #UPDATE NEW DATA

          $dir = storage_path('jsondata');
          if ( !file_exists( $dir ) && !is_dir( $dir ) ) {
              mkdir( $dir,0755 );       
          } 

          if(file_exists(storage_path('jsondata').'/'.$account->id.'.json'))
          {
            $created_json = file_get_contents(storage_path('jsondata').'/'.$account->id.'.json');
            $log = json_decode($created_json,true);
          }
          else
          {
            $log = null;
          }
          

          if(empty($log['created_at']) && $log <> null)
          {
              $created = Date("Y-m-d H:i:s");
          }
          elseif($log <> null)
          {
              $created = $log['created_at'];
          }

          $data = array(
             'account_id'=>$account->id,
             'jml_followers'=>$account->jml_followers,
             'jml_following'=>$account->jml_following,
             'jml_post'=>$account->jml_post,
             'lastpost'=>$account->lastpost,
             'jml_likes'=>$account->jml_likes,
             'jml_comments'=>$account->jml_comments,
             'total_calc'=>$account->total_calc,
             'total_compare'=>$account->total_compare,
             'jmlvideoview'=>$jmlvideoview,
             'ratavideoview'=>$ratavideoview,
             'created_at'=>$created,
             'updated_at'=>Date("Y-m-d H:i:s"),
          );

          if($account->jml_followers>0){
            $data['eng_rate'] = $account->eng_rate;
            $data['video_view_rate'] = $account->video_view_rate;
            $data['total_influenced'] = $account->total_influenced;  
          }

          $json = json_encode($data);

          if ( file_exists( $dir ) && is_dir( $dir ) ) {
              file_put_contents(storage_path('jsondata').'/'.$account->id.'.json', $json);
          }

          #STATISTIC

          #make directory if not available
          $dir_statistic = storage_path('jsonstatistic');
          if( !file_exists( $dir_statistic ) && !is_dir( $dir_statistic ) ) 
          {
              mkdir($dir_statistic,0755);       
          } 

          $previous_file = storage_path('jsonstatistic').'/'.$account->id.'.json';
          $getcontent = $vals = array();

          #get previous file
          if(file_exists($previous_file)) 
          {
             $getcontent = file_get_contents($previous_file);
             $getcontent = json_decode($getcontent,true);
          }

          if(count($getcontent) > 0)
          {
             $vals = array_values($getcontent);
          }
          $previous_total = count($vals);

          if($previous_total > 0)
          {
             $last_array = end($vals);
             $deviationfollower = $arr_res["follower_count"] - $last_array['Total_Followers'];
             $deviationfollowing = $arr_res["following_count"] - $last_array['Total_Following'];
             $deviationpost = $arr_res["media_count"] - $last_array['Total_Post'];
          }
          else
          {
             $deviationfollower = $deviationfollowing = $deviationpost = 0;
          }

          $day_created = Date("Y-m-d");
          $statistic = [$day_created =>[
              'Total_Followers'=>$arr_res["follower_count"],
              'FollowerDeviation'=>$deviationfollower,
              'Total_Following'=>$arr_res["following_count"],
              'FollowingDeviation'=>$deviationfollowing,
              'Total_Post'=>$arr_res["media_count"],
              'PostDeviation'=>$deviationpost,
          ]];

          $recordedstatistic = [];
          $dir_recordedstatistic = $dir_statistic.'/'.$account->id.'.json';
          if(file_exists( $dir_recordedstatistic ) && $previous_total > 0) 
          {
              $recordedstatistic = file_get_contents($dir_recordedstatistic);
              $recordedstatistic = json_decode($recordedstatistic,true);
              $jsonstatistic = $recordedstatistic + $statistic;
              $jsonstatistic = json_encode($jsonstatistic);
          }
          else
          {
              $jsonstatistic = json_encode($statistic);
          }
          
          if(file_exists( $dir_statistic ) && is_dir( $dir_statistic )) 
          {
              file_put_contents(storage_path('jsonstatistic').'/'.$account->id.'.json', $jsonstatistic);
          }

          #END STATISTIC

          /*die('');

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

          */

        }
        sleep(0.5);
      } /* end for */
    /* end function */
    }

/* end class update account */
}
