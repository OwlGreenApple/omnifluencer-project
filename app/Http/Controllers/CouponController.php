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
    	$coupon->discount = $request->discount;
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

    /* See coupon list 

    public function couponList()
    {
    	$getcoupon = Coupon::all();
    	return View('product_order.admin_coupon_list',['data'=>$getcoupon]);
    }

    */
}
