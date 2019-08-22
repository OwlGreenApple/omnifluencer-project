<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AutoConfirm;
use App\Order;

class AutoConfirmController extends Controller
{
    /* Test rest API as example in the case to obtain json data result */
	public function virtualRestApi()
	{
		//API URL
		$url = 'http://localhost/omnifluencer/autoconfirm';

		//Initiate cURL.
		$ch = curl_init($url);
		 
		//The JSON data.
		$jsonData = array(
		    'action' => 'payment_report',
		    'content' => array(
		    	'service_name'=>"BCA",
		    	'service_code'=>"bca",
		    	'account_number'=>"8290981477",
		    	'account_name'=>"test 2",
		    	'data'=>array(array(
			    	'unix_timestamp'=>1565941739,
			    	'type'=>'credit',
			    	'amount'=>'	300000.00',
			    	'description'=>'Test No Coupon',
			    	'balance'=>'1.00',
			    	)
			    )
			),    
		);
		 
		//Encode the array into JSON.
		$jsonDataEncoded = json_encode($jsonData);
		 
		//Tell cURL that we want to send a POST request.
		curl_setopt($ch, CURLOPT_POST, 1);
		 
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		 
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
		 
		//Execute the request
		$result = curl_exec($ch);
	}

    public function confirm(Request $request)
    {

    	$valid = false;
    	$check_json = AutoConfirm::where('callback',$request->getContent())->count();

    	if(env('APP_ENV')!=='local'){
    		$config["cekmutasi_api_signature"] = "55a860e4bb5d9fc6da6a0657afdb594bbc367b72";

			$incomingApiSignature = isset($_SERVER['HTTP_API_SIGNATURE']) ? $_SERVER['HTTP_API_SIGNATURE'] : '';
    	}

    	// validasi API Signature
		if( env('APP_ENV')!=='local' && !hash_equals($config['cekmutasi_api_signature'], $incomingApiSignature) ) {
		    exit("Invalid Signature");
		}
		
		if($check_json == 0){
	    	$valid = true;
	    } else {
			exit('Data already exists!');
		}	

		$post = $request->getContent();
		$json = json_decode($post, true);

		if(env('APP_ENV')!=='local' && (json_last_error() !== JSON_ERROR_NONE)){
		    exit("Invalid JSON");
		}

		/* Retrieve user's unique pricing amount */
		$uniqueprice = $json['content']['data'][0]['amount'];

		/* Check user's pricing amount matched or not */
		$checkunique = Order::where('total',$uniqueprice)->count();

		if($checkunique > 0 && $valid == true){
			Order::where('total',$uniqueprice)->update(['status' => 1]);
			$is_executed = 1;
		} else {
			$is_executed = 0;
		}

		/* Save user's json as a proof */
		$confirm = new AutoConfirm;
		$confirm->callback = $post;
		$confirm->is_executed = $is_executed;
		$confirm->save();
    }

}
