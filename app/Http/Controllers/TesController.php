<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\AccountController;

use App\Helpers\InstagramHelper;

class TesController extends Controller
{
    public function tes_igcallback(){
      // $url = "http://cmx.space/get-user-data/heiwahyu_";
      // $arr_res = AccountController::igcallback($url);
      $arr_res = json_decode(InstagramHelper::get_user_data("heiwahyu_"),true);

      $count = 0;
      $jmllike = 0;
      $jmlcomment = 0;
      $end_cursor = null;
      $private = false;
      $lastpost = null;
      // dd($arr_res);
      // echo $arr_res["username"];
      // exit;
      do {
        // $url2 = "http://cmx.space/get-user-feed/".$arr_res["username"].'/'.$end_cursor;
        // $arr_res2 = AccountController::igcallback($url2);    
        dd(InstagramHelper::get_user_feed($arr_res["username"],$end_cursor));
        $arr_res2 = json_decode(InstagramHelper::get_user_feed($arr_res["username"],$end_cursor),true);

        // $url3 = "http://cmx.space/get-user-feed-maxid/".$arr_res["username"].'/'.$end_cursor;
        // $arr_res3 = AccountController::igcallback($url3,'string');
        $arr_res3 = InstagramHelper::get_user_feed_maxid($arr_res["username"],$end_cursor);
        $end_cursor = $arr_res3;

        if($end_cursor=='InstagramAPI\Response\UserFeedResponse: Not authorized to view user.'){
            $private = true;
            break;
        }

        if(!is_null($arr_res2) and !empty($arr_res2)){
          if($count==0){
            $lastpost = date("Y-m-d h:i:s",$arr_res2[0]["taken_at"]);
          }

          foreach ($arr_res2 as $arr) {
            if($count>=20){
              break;
            } else {
              $jmllike = $jmllike + $arr["like_count"];
              if(array_key_exists('comment_count', $arr)){
                $jmlcomment = $jmlcomment + $arr["comment_count"];  
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
      if($private==false){
        $ratalike = $jmllike/$count;
        $ratacomment = $jmlcomment/$count;
      } else {
        $ratalike = 0;
        $ratacomment = 0;
      }

      if($arr_res["follower_count"]>0){
        $eng_rate = ($jmllike + $jmlcomment)/($arr_res["follower_count"]*20);
      }

      var_dump('Likes = '.$jmllike);
      var_dump('Comment = '.$jmlcomment);
      var_dump('Followers = '.$arr_res["follower_count"]);
      // var_dump('Eng rate = '.$eng_rate*100);
    }
}
