<?php 
namespace App\Helpers;

/**
* 
*/
use Carbon;
use DB, Crypt, App;

use \InstagramAPI\Instagram;

class InstagramHelper
{
	public static function check_login(){
		try {
			$error_message="";
			$i = new Instagram(false,false,[
				"storage"       => "mysql",
        "dbhost"       => config('app.dbhost'),
        "dbname"   => config('app.dbdatabase'),
        "dbusername"   => config('app.dbusername'),
        "dbpassword"   => config('app.dbpassword'),
        "dbtablename"   => 'user_sessions',
			]);	
			
          if ( env('APP_ENV') == "production" ) {
            $i->setProxy('http://michaelsugih:TUhmQPS2erGtEe2@id.smartproxy.io:10001');
          }
					// JANGAN LUPA DILOGIN TERLEBIH DAHULU
					// $i->setProxy('http://208.115.112.100:9999');
					
					
					$i->login("mayyyvitri", "qwerty12345", 300);
					$userData = $i->people->getInfoByName('jajankulinersurabaya')->getUser();

					if (!is_null($userData)) {
					echo "Profile picture: ".$userData->getProfilePicUrl()."<br>";
					echo "Followers: ".$userData->getFollowerCount()."<br>";
					echo "Followings: ".$userData->getFollowingCount()."<br>";
					echo "Private: ".(int) $userData->getIsPrivate()."<br>";
					echo "ID: ".$userData->getPk()."<br>";
											$followData = $i->people->getFriendship($userData->getPk());

						if (!is_null($followData)) {
											$followedBy = $followData->getFollowedBy();
											$following = $followData->getFollowing();						
											$followed_by_viewer = (int) $following;
						echo "followed : ".(int) $followedBy."<br>";
						echo "following : ".(int) $following."<br>";
						}
					}
					dd($userData);

		}  	
			catch (\InstagramAPI\Exception\IncorrectPasswordException $e) {
				//klo error password
				$error_message = $e->getMessage();
			}
			catch (\InstagramAPI\Exception\AccountDisabledException $e) {
				//klo error password
				$error_message = $e->getMessage();
			}
			catch (\InstagramAPI\Exception\CheckpointRequiredException $e) {
				//klo error email / phone verification 
				$error_message = $e->getMessage();
			}
					catch (\InstagramAPI\Exception\InstagramException $e) {
						$is_error = true;
						// if ($e->hasResponse() && $e->getResponse()->isTwoFactorRequired()) {
							// echo "2 Factor perlu dioffkan";
						// } 
						// else {
								// all other login errors would get caught here...
							echo $e->getMessage();
						// }
					}	
			catch (NotFoundException $e) {
				// echo $e->getMessage();
				echo "asd";
			}					
			catch (Exception $e) {
				$error_message = $e->getMessage();
				if ($error_message == "InstagramAPI\Response\LoginResponse: The password you entered is incorrect. Please try again.") {
					$error_message = $e->getMessage();
				} 
				if ( ($error_message == "InstagramAPI\Response\LoginResponse: Challenge required.") || ( substr($error_message, 0, 18) == "challenge_required") || ($error_message == "InstagramAPI\Response\TimelineFeedResponse: Challenge required.") || ($error_message == "InstagramAPI\Response\LoginResponse: Sorry, there was a problem with your request.") ){
					$error_message = $e->getMessage();
				}
			}
		echo "fin ".$error_message;
	}
	
  public static function getUserDataByid($id){
    try {
      $error_message="";
      $i = new Instagram(false,false,[
        "storage"       => "mysql",
        "dbhost"       => config('app.dbhost'),
        "dbname"   => config('app.dbdatabase'),
        "dbusername"   => config('app.dbusername'),
        "dbpassword"   => config('app.dbpassword'),
        "dbtablename"   => 'user_sessions',
      ]);	
      
          // $i->setProxy('http://sugiarto:sugiarto12@196.18.172.66:57159');
          // JANGAN LUPA DILOGIN TERLEBIH DAHULU
          /*if ( env('APP_ENV') == "production" ) {
            // $i->setProxy('http://208.115.112.100:9999');
            $i->setProxy('http://michaelsugih:TUhmQPS2erGtEe2@id.smartproxy.io:10001');
          }*/
          
          if ( env('APP_ENV') == "local" ) {
            $i->login("mayyyvitri", "qwerty12345", 300);
          } 
          else if ( env('APP_ENV') == "production" ) {
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24470",
              "username"=>"melodianaelisa",
              "password"=>"qazwsx123",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24471",
              "username"=>"dessiarumi",
              "password"=>"abcde12345",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24472",
              "username"=>"renawilliams222",
              "password"=>"abcde12345",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24473",
              "username"=>"marianalaskmi",
              "password"=>"qwerty12345",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24474",
              "username"=>"magdalenapeter96",
              "password"=>"qazwsx123",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24475",
              "username"=>"felysamora",
              "password"=>"abcde12345",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24476",
              "username"=>"nithaasyari",
              "password"=>"qweasdzxc123",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24477",
              "username"=>"thalianasarifernand",
              "password"=>"987456321qwerty",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24478",
              "username"=>"naningtyasa",
              "password"=>"qwerty12345",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24479",
              "username"=>"mayymayyaa",
              "password"=>"qwerty12345",
            ];			
        
            $arr_user = $arr_users[array_rand($arr_users)];
          
            
            // $i->setProxy('http://michaelsugih:TUhmQPS2erGtEe2@id.smartproxy.io:10001');
            // $i->login("mayymayyaa", "qwerty12345", 300);
            /*$i->setProxy("http://".$arr_user['proxy'].":".$arr_user['port']);
            $i->setProxy("http://michaelsugih:69682micro@".$arr_user['proxy'].":".$arr_user['port']);*/
            $i->setProxy("http://celebgramme:Ls3gX0Op@".$arr_user['proxy'].":".$arr_user['port']);
            $i->login($arr_user["username"], $arr_user["password"], 300);
          }
          $userData = $i->people->getInfoById($id)->getUser();

          return json_encode($userData);

    }  	
    catch (\InstagramAPI\Exception\IncorrectPasswordException $e) {
      //klo error password
      $error_message = $e->getMessage();
    }
    catch (\InstagramAPI\Exception\AccountDisabledException $e) {
      //klo error password
      $error_message = $e->getMessage();
    }
    catch (\InstagramAPI\Exception\CheckpointRequiredException $e) {
      //klo error email / phone verification 
      $error_message = $e->getMessage();
    }
    catch (\InstagramAPI\Exception\InstagramException $e) {
      $is_error = true;
      // if ($e->hasResponse() && $e->getResponse()->isTwoFactorRequired()) {
        // echo "2 Factor perlu dioffkan";
      // } 
      // else {
          // all other login errors would get caught here...
        echo $e->getMessage();
      // }
    }	
    catch (NotFoundException $e) {
      // echo $e->getMessage();
      echo "asd";
    }					
    catch (Exception $e) {
      $error_message = $e->getMessage();
      if ($error_message == "InstagramAPI\Response\LoginResponse: The password you entered is incorrect. Please try again.") {
        $error_message = $e->getMessage();
      } 
      if ( ($error_message == "InstagramAPI\Response\LoginResponse: Challenge required.") || ( substr($error_message, 0, 18) == "challenge_required") || ($error_message == "InstagramAPI\Response\TimelineFeedResponse: Challenge required.") || ($error_message == "InstagramAPI\Response\LoginResponse: Sorry, there was a problem with your request.") ){
        $error_message = $e->getMessage();
      }
    }
    return $error_message;
  }
  
	public static function get_user_data($username){
		try {
			$error_message="";
      // require __DIR__.'vendor/autoload.php';
			$i = new Instagram(false,false,[
			// $i = new \InstagramAPI\Instagram(false,false,[
				"storage"       => "mysql",
        "dbhost"       => config('app.dbhost'),
        "dbname"   => config('app.dbdatabase'),
        "dbusername"   => config('app.dbusername'),
        "dbpassword"   => config('app.dbpassword'),
        "dbtablename"   => 'user_sessions',
			]);	
			
					// $i->setProxy('http://sugiarto:sugiarto12@196.18.172.66:57159');
					// JANGAN LUPA DILOGIN TERLEBIH DAHULU
          /*if ( env('APP_ENV') == "production" ) {
            // $i->setProxy('http://208.115.112.100:9999');
            $i->setProxy('http://michaelsugih:TUhmQPS2erGtEe2@id.smartproxy.io:10001');
          }*/
					
					
          if ( env('APP_ENV') == "local" ) {
            $i->login("mayyyvitri", "qwerty12345", 300);
          } 
          else if ( env('APP_ENV') == "production" ) {
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24470",
              "username"=>"melodianaelisa",
              "password"=>"qazwsx123",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24471",
              "username"=>"dessiarumi",
              "password"=>"abcde12345",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24472",
              "username"=>"renawilliams222",
              "password"=>"abcde12345",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24473",
              "username"=>"marianalaskmi",
              "password"=>"qwerty12345",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24474",
              "username"=>"magdalenapeter96",
              "password"=>"qazwsx123",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24475",
              "username"=>"felysamora",
              "password"=>"abcde12345",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24476",
              "username"=>"nithaasyari",
              "password"=>"qweasdzxc123",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24477",
              "username"=>"thalianasarifernand",
              "password"=>"987456321qwerty",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24478",
              "username"=>"naningtyasa",
              "password"=>"qwerty12345",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24479",
              "username"=>"mayymayyaa",
              "password"=>"qwerty12345",
            ];			
        
            $arr_user = $arr_users[array_rand($arr_users)];
          
            
            // $i->setProxy('http://michaelsugih:TUhmQPS2erGtEe2@id.smartproxy.io:10001');
            // $i->login("mayymayyaa", "qwerty12345", 300);
            /*$i->setProxy("http://".$arr_user['proxy'].":".$arr_user['port']);
            $i->setProxy("http://michaelsugih:69682micro@".$arr_user['proxy'].":".$arr_user['port']);*/
            // $i->setProxy("http://".$arr_user['username'].":".$arr_user['password']."@".$arr_user['proxy'].":".$arr_user['port']);
            $i->setProxy("http://celebgramme:Ls3gX0Op@".$arr_user['proxy'].":".$arr_user['port']);
            $i->login($arr_user["username"], $arr_user["password"], 300);
          }
					$userData = $i->people->getInfoByName($username)->getUser();

					return json_encode($userData);

		}  	
		catch (\InstagramAPI\Exception\IncorrectPasswordException $e) {
			//klo error password
			$error_message = $e->getMessage();
		}
		catch (\InstagramAPI\Exception\AccountDisabledException $e) {
			//klo error password
			$error_message = $e->getMessage();
		}
		catch (\InstagramAPI\Exception\CheckpointRequiredException $e) {
			//klo error email / phone verification 
			$error_message = $e->getMessage();
		}
		catch (\InstagramAPI\Exception\InstagramException $e) {
			$is_error = true;
			// if ($e->hasResponse() && $e->getResponse()->isTwoFactorRequired()) {
				// echo "2 Factor perlu dioffkan";
			// } 
			// else {
					// all other login errors would get caught here...
				// echo $e->getMessage();
        $error_message = $e->getMessage();
			// }
		}	
		catch (NotFoundException $e) {
			// echo $e->getMessage();
      $error_message = $e->getMessage();
		}					
		catch (Exception $e) {
			$error_message = $e->getMessage();
			if ($error_message == "InstagramAPI\Response\LoginResponse: The password you entered is incorrect. Please try again.") {
				$error_message = $e->getMessage();
			} 
			if ( ($error_message == "InstagramAPI\Response\LoginResponse: Challenge required.") || ( substr($error_message, 0, 18) == "challenge_required") || ($error_message == "InstagramAPI\Response\TimelineFeedResponse: Challenge required.") || ($error_message == "InstagramAPI\Response\LoginResponse: Sorry, there was a problem with your request.") ){
				$error_message = $e->getMessage();
			}
		}
		return $error_message;
	}
	
 	public static function get_user_feed($username,$maxid = null){
		try {
			$error_message="";
			$i = new Instagram(false,false,[
				"storage"       => "mysql",
        "dbhost"       => config('app.dbhost'),
        "dbname"   => config('app.dbdatabase'),
        "dbusername"   => config('app.dbusername'),
        "dbpassword"   => config('app.dbpassword'),
        "dbtablename"   => 'user_sessions',
			]);	
			
					// $i->setProxy('http://sugiarto:sugiarto12@196.18.172.66:57159');
					// JANGAN LUPA DILOGIN TERLEBIH DAHULU
          if ( env('APP_ENV') == "production" ) {
            // $i->setProxy('http://208.115.112.100:9999');
            $i->setProxy('http://michaelsugih:TUhmQPS2erGtEe2@id.smartproxy.io:10001');
          }
					
					
          if ( env('APP_ENV') == "local" ) {
            $i->login("mayyyvitri", "qwerty12345", 300);
          } 
          else {
            $i->login("mayymayyaa", "qwerty12345", 300);
          }
					$feed = $i->timeline->getUserFeed($i->people->getUserIdForName($username),$maxid);

					return json_encode($feed->getItems());

		}  	
		catch (\InstagramAPI\Exception\IncorrectPasswordException $e) {
			//klo error password
			$error_message = $e->getMessage();
		}
		catch (\InstagramAPI\Exception\AccountDisabledException $e) {
			//klo error password
			$error_message = $e->getMessage();
		}
		catch (\InstagramAPI\Exception\CheckpointRequiredException $e) {
			//klo error email / phone verification 
			$error_message = $e->getMessage();
		}
		catch (\InstagramAPI\Exception\InstagramException $e) {
			$is_error = true;
			// if ($e->hasResponse() && $e->getResponse()->isTwoFactorRequired()) {
				// echo "2 Factor perlu dioffkan";
			// } 
			// else {
					// all other login errors would get caught here...
				// echo $e->getMessage();
			// }
		}	
		catch (NotFoundException $e) {
			// echo $e->getMessage();
			// echo "asd";
		}					
		catch (Exception $e) {
			$error_message = $e->getMessage();
			if ($error_message == "InstagramAPI\Response\LoginResponse: The password you entered is incorrect. Please try again.") {
				$error_message = $e->getMessage();
			} 
			if ( ($error_message == "InstagramAPI\Response\LoginResponse: Challenge required.") || ( substr($error_message, 0, 18) == "challenge_required") || ($error_message == "InstagramAPI\Response\TimelineFeedResponse: Challenge required.") || ($error_message == "InstagramAPI\Response\LoginResponse: Sorry, there was a problem with your request.") ){
				$error_message = $e->getMessage();
			}
		}
		// return $error_message;
	}

	public static function get_user_feed_maxid($username,$maxid = null){
		try {
			$error_message="";
			$i = new Instagram(false,false,[
				"storage"       => "mysql",
        "dbhost"       => config('app.dbhost'),
        "dbname"   => config('app.dbdatabase'),
        "dbusername"   => config('app.dbusername'),
        "dbpassword"   => config('app.dbpassword'),
        "dbtablename"   => 'user_sessions',
			]);	
			
					// $i->setProxy('http://sugiarto:sugiarto12@196.18.172.66:57159');
					// JANGAN LUPA DILOGIN TERLEBIH DAHULU
          if ( env('APP_ENV') == "production" ) {
            // $i->setProxy('http://208.115.112.100:9999');
            $i->setProxy('http://michaelsugih:TUhmQPS2erGtEe2@id.smartproxy.io:10001');
          }
					
					
          if ( env('APP_ENV') == "local" ) {
            $i->login("mayyyvitri", "qwerty12345", 300);
          } 
          else {
            $i->login("mayymayyaa", "qwerty12345", 300);
          }
					$feed = $i->timeline->getUserFeed($i->people->getUserIdForName($username),$maxid);

					return $feed->getNextMaxId();

		}  	
		catch (\InstagramAPI\Exception\IncorrectPasswordException $e) {
			//klo error password
			$error_message = $e->getMessage();
		}
		catch (\InstagramAPI\Exception\AccountDisabledException $e) {
			//klo error password
			$error_message = $e->getMessage();
		}
		catch (\InstagramAPI\Exception\CheckpointRequiredException $e) {
			//klo error email / phone verification 
			$error_message = $e->getMessage();
		}
		catch (\InstagramAPI\Exception\InstagramException $e) {
			$is_error = true;
			// if ($e->hasResponse() && $e->getResponse()->isTwoFactorRequired()) {
				// echo "2 Factor perlu dioffkan";
			// } 
			// else {
					// all other login errors would get caught here...
				echo $e->getMessage();
			// }
		}	
		catch (NotFoundException $e) {
			// echo $e->getMessage();
			echo "asd";
		}					
		catch (Exception $e) {
			$error_message = $e->getMessage();
			if ($error_message == "InstagramAPI\Response\LoginResponse: The password you entered is incorrect. Please try again.") {
				$error_message = $e->getMessage();
			} 
			if ( ($error_message == "InstagramAPI\Response\LoginResponse: Challenge required.") || ( substr($error_message, 0, 18) == "challenge_required") || ($error_message == "InstagramAPI\Response\TimelineFeedResponse: Challenge required.") || ($error_message == "InstagramAPI\Response\LoginResponse: Sorry, there was a problem with your request.") ){
				$error_message = $e->getMessage();
			}
		}
		return $error_message;
	}

  // get_user_feed + get_user_feed_maxid
 	public static function get_user_profile($username){
		try {
			$error_message="";
      $count = 0;
      $jmllike = 0;
      $jmlcomment = 0;
      $private = false;
      $lastpost = null;
      $maxid = null;
			$i = new Instagram(false,false,[
				"storage"       => "mysql",
        "dbhost"       => config('app.dbhost'),
        "dbname"   => config('app.dbdatabase'),
        "dbusername"   => config('app.dbusername'),
        "dbpassword"   => config('app.dbpassword'),
        "dbtablename"   => 'user_sessions',
			]);	
			
      // $i->setProxy('http://sugiarto:sugiarto12@196.18.172.66:57159');
      // JANGAN LUPA DILOGIN TERLEBIH DAHULU
      // if ( env('APP_ENV') == "production" ) {
        // $i->setProxy('http://michaelsugih:TUhmQPS2erGtEe2@id.smartproxy.io:10001');
      // }

      if ( env('APP_ENV') == "local" ) {
        $i->login("mayyyvitri", "qwerty12345", 300);
      } 
      else if ( env('APP_ENV') == "production" ) {
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24470",
              "username"=>"melodianaelisa",
              "password"=>"qazwsx123",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24471",
              "username"=>"dessiarumi",
              "password"=>"abcde12345",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24472",
              "username"=>"renawilliams222",
              "password"=>"abcde12345",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24473",
              "username"=>"marianalaskmi",
              "password"=>"qwerty12345",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24474",
              "username"=>"magdalenapeter96",
              "password"=>"qazwsx123",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24475",
              "username"=>"felysamora",
              "password"=>"abcde12345",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24476",
              "username"=>"nithaasyari",
              "password"=>"qweasdzxc123",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24477",
              "username"=>"thalianasarifernand",
              "password"=>"987456321qwerty",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24478",
              "username"=>"naningtyasa",
              "password"=>"qwerty12345",
            ];			
            
            $arr_users[] = [
              "proxy"=>"107.181.187.190",
              "port"=>"24479",
              "username"=>"mayymayyaa",
              "password"=>"qwerty12345",
            ];			
        
        $arr_user = $arr_users[array_rand($arr_users)];
			
        
        // $i->setProxy('http://michaelsugih:TUhmQPS2erGtEe2@id.smartproxy.io:10001');
        // $i->login("mayymayyaa", "qwerty12345", 300);
        /*$i->setProxy("http://".$arr_user['proxy'].":".$arr_user['port']);
        $i->setProxy("http://michaelsugih:69682micro@".$arr_user['proxy'].":".$arr_user['port']);*/
        // $i->setProxy("http://".$arr_user['username'].":".$arr_user['password']."@".$arr_user['proxy'].":".$arr_user['port']);
        $i->setProxy("http://celebgramme:Ls3gX0Op@".$arr_user['proxy'].":".$arr_user['port']);
        $i->login($arr_user["username"], $arr_user["password"], 300);
      }
      
      //var_dump($arr_res2);

      $username = str_replace("@", "", $username);
      if (!$i->account->checkUsername($username)->getAvailable()) {
        $userData = $i->people->getInfoByName($username)->getUser();
        if (!is_null($userData)) {
          //new
          $private = (int) $userData->getIsPrivate();
        }
      }
      
      if (!$private){
        do {
          /*$feed = $i->timeline->getUserFeed($i->people->getUserIdForName($username),$maxid);
          $temp = json_encode($feed->getItems());
          // $maxid = $feed->getNextMaxId();
          $arr_res2 = json_decode($temp,true);
          // dd($arr_res2);
          // var_dump('end_cursor = '.$maxid);

          if(!is_null($arr_res2) and !empty($arr_res2))
          {
            if($count==0){
              $lastpost = date("Y-m-d h:i:s",$arr_res2[0]["taken_at"]);
            }

            foreach ($arr_res2 as $arr) {
              if($count>=12){
                break;
              } else {
                $jmllike = $jmllike + $arr["like_count"];
                // var_dump('like = '.$arr["like_count"]);
                if(array_key_exists('comment_count', $arr)){
                  $jmlcomment = $jmlcomment + $arr["comment_count"];  
                  // var_dump('comment = '.$arr["comment_count"]);
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
          */
          $userFeed = $i->timeline->getUserFeed($i->people->getUserIdForName($username),$maxid);
          $userFeedItems = $userFeed->getItems();


          if(!is_null($userFeedItems) and !empty($userFeedItems))
          {

            foreach($userFeedItems as $item) {
              if($count==0){
                $itemInfo = $i->media->getInfo($item->getId());
                $lastpost = date("Y-m-d h:i:s",$itemInfo->getItems()[0]->getTakenAt());
              }
              
              if($count>=12){
                break;
              } else {
                $itemInfo = $i->media->getInfo($item->getId());
                $jmllike += $itemInfo->getItems()[0]->getLikeCount();
                $jmlcomment += $itemInfo->getItems()[0]->getCommentCount();
                $count++;
              }
            }
          } else {
            if($count==0){
              $private = true;
            }
            break;
          }

        } while ($count<12);
      }
      

		}  	
		catch (\InstagramAPI\Exception\IncorrectPasswordException $e) {
			//klo error password
			$error_message = $e->getMessage();
		}
		catch (\InstagramAPI\Exception\AccountDisabledException $e) {
			//klo error password
			$error_message = $e->getMessage();
		}
		catch (\InstagramAPI\Exception\CheckpointRequiredException $e) {
			//klo error email / phone verification 
			$error_message = $e->getMessage();
		}
		catch (\InstagramAPI\Exception\InstagramException $e) {
			$is_error = true;
			$error_message = $e->getMessage();
			// if ($e->hasResponse() && $e->getResponse()->isTwoFactorRequired()) {
				// echo "2 Factor perlu dioffkan";
			// } 
			// else {
					// all other login errors would get caught here...
				// echo $e->getMessage();
			// }
		}	
		catch (NotFoundException $e) {
			$error_message = $e->getMessage();
			// echo $e->getMessage();
			// echo "asd";
		}					
		catch (Exception $e) {
			$error_message = $e->getMessage();
			if ($error_message == "InstagramAPI\Response\LoginResponse: The password you entered is incorrect. Please try again.") {
				$error_message = $e->getMessage();
			} 
			if ( ($error_message == "InstagramAPI\Response\LoginResponse: Challenge required.") || ( substr($error_message, 0, 18) == "challenge_required") || ($error_message == "InstagramAPI\Response\TimelineFeedResponse: Challenge required.") || ($error_message == "InstagramAPI\Response\LoginResponse: Sorry, there was a problem with your request.") ){
				$error_message = $e->getMessage();
			}
		}
    
    $arr_res = [
      "count"=>$count,
      "jmllike"=>$jmllike,
      "jmlcomment"=>$jmlcomment,
      "private"=>$private,
      "lastpost"=>$lastpost,
      "error_message"=>$error_message,
    ];

		return $arr_res;
	}

}

?>
