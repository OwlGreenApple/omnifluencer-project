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
        "dbhost"       => env('DB_HOST', '127.0.0.1'),
        "dbname"   => env('DB_DATABASE', ''),
        "dbusername"   => env('DB_USERNAME', ''),
        "dbpassword"   => env('DB_PASSWORD', ''),
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
        "dbhost"       => env('DB_HOST', '127.0.0.1'),
        "dbname"   => env('DB_DATABASE', ''),
        "dbusername"   => env('DB_USERNAME', ''),
        "dbpassword"   => env('DB_PASSWORD', ''),
      ]);	
      
          // $i->setProxy('http://sugiarto:sugiarto12@196.18.172.66:57159');
          // JANGAN LUPA DILOGIN TERLEBIH DAHULU
          if ( env('APP_ENV') == "production" ) {
            $i->setProxy('http://208.115.112.100:9999');
          }
          
          if ( env('APP_ENV') == "local" ) {
            $i->login("mayyyvitri", "qwerty12345", 300);
          } 
          else {
            $i->login("mayymayyaa", "qwerty12345", 300);
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
			$i = new Instagram(false,false,[
				"storage"       => "mysql",
        "dbhost"       => env('DB_HOST', '127.0.0.1'),
        "dbname"   => env('DB_DATABASE', ''),
        "dbusername"   => env('DB_USERNAME', ''),
        "dbpassword"   => env('DB_PASSWORD', ''),
			]);	
			
					// $i->setProxy('http://sugiarto:sugiarto12@196.18.172.66:57159');
					// JANGAN LUPA DILOGIN TERLEBIH DAHULU
          if ( env('APP_ENV') == "production" ) {
            $i->setProxy('http://208.115.112.100:9999');
          }
					
					
          if ( env('APP_ENV') == "local" ) {
            $i->login("mayyyvitri", "qwerty12345", 300);
          } 
          else {
            $i->login("mayymayyaa", "qwerty12345", 300);
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
	
 	public static function get_user_feed($username,$maxid = null){
		try {
			$error_message="";
			$i = new Instagram(false,false,[
				"storage"       => "mysql",
        "dbhost"       => env('DB_HOST', '127.0.0.1'),
        "dbname"   => env('DB_DATABASE', ''),
        "dbusername"   => env('DB_USERNAME', ''),
        "dbpassword"   => env('DB_PASSWORD', ''),
			]);	
			
					// $i->setProxy('http://sugiarto:sugiarto12@196.18.172.66:57159');
					// JANGAN LUPA DILOGIN TERLEBIH DAHULU
          if ( env('APP_ENV') == "production" ) {
            $i->setProxy('http://208.115.112.100:9999');
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
        "dbhost"       => env('DB_HOST', '127.0.0.1'),
        "dbname"   => env('DB_DATABASE', ''),
        "dbusername"   => env('DB_USERNAME', ''),
        "dbpassword"   => env('DB_PASSWORD', ''),
			]);	
			
					// $i->setProxy('http://sugiarto:sugiarto12@196.18.172.66:57159');
					// JANGAN LUPA DILOGIN TERLEBIH DAHULU
          if ( env('APP_ENV') == "production" ) {
            $i->setProxy('http://208.115.112.100:9999');
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

}

?>
