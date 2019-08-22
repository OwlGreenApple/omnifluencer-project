<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupons;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Rules\CheckCouponCode;

class CouponController extends Controller
{

    /* Display coupon's code */
    public function index()
    {
    	return View('admin.list-coupons.index');
    }

    /* Add coupon */
    public function addCoupon(Request $request)
    {
    	$data['success'] = true;
    	$valid_until = date("Y-m-d",strtotime($request->valid_until));
    	$coupon = new Coupons;
    	$coupon->coupon_description = $request->coupon_description;
    	$coupon->coupon_code = $request->coupon_code;
    	$coupon->discount = $request->coupon_discount;
    	$coupon->value = $request->coupon_value;
    	$coupon->valid_until = $valid_until;
    	$coupon->save();

    	if($coupon->save() == true){
    		$data['message'] = 'Data kupon telah berhasil di masukkan';
    	} else {
    		$data['message'] = 'Error!! data kupon gagal di masukkan';
    	}
    	return response()->json($data);
    }

    /* See coupon list on data table  */

    public function couponList(Request $request)
    {
    	$no = 1;
    	$draw = $request->input('draw');
    	$start = $request->input('start');
    	$length =  $request->input('length');
    	$search = $request->input('search')['value'];

    	if(!empty($search))
    	{
			/* Search according on : coupon code, and valid until */
    		$getcoupon = Coupons::where([
    			['coupon_code','=',$search],
    			['valid_until','=',$search],
    		])->get();
    	} else {
    		$getcoupon = Coupons::skip($start)->take($length)->get();
    	}

    	if($getcoupon->count() == 0){
    		$getcoupon = Coupons::skip($start)->take($length)->get();
    	}	

		foreach($getcoupon as $row){
    	  $data['data'][] = 
    	  	array(
				"no" => $no,
		      	"coupon_code" => $row->coupon_code,
		     	"percent" => $row->discount,
		      	"value" => number_format($row->value,2),
		      	"valid" => $row->valid_until,
		      	"created" => date_format($row->created_at,'Y-m-d H:i:s'),
		      	"updated" =>date_format($row->updated_at,'Y-m-d H:i:s'),
		      	"description" =>$row->coupon_description
    	  	)
    	  ;	
		  $no++;
    	}
    	return response()->json($data);

    }
}
