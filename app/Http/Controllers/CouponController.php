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
    	$getcoupon = Coupons::all();
    	return View('admin.list-coupons.index',['coupons'=>$getcoupon]);
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

    /* Display coupons data on edit form */
    public function getCoupon(Request $request)
    {
    	$id = $request->id_coupon;
    	$getcoupon = Coupons::where('id','=',$id)->first();
    	$data = array(
    		'id'=>$id,
    		'code'=>$getcoupon->coupon_code,
    		'coupon_discount'=>$getcoupon->discount,
    		'coupon_value'=>$getcoupon->value,
    		'valid_until'=>$getcoupon->valid_until,
    		'description'=>$getcoupon->coupon_description,
    	);
    	return response()->json($data);
    }

    /* Update coupon data */
    public function updateCoupon(Request $request)
    {

    	/* Change value or percent if admin change from % to value and otherwise */
    	if($request->edit_discount == 0){
    		$percent = $request->edit_coupon_discount;
    		$value = null;
    	} else {
    		$percent = 0;
    		$value = $request->edit_coupon_value;
    	}
    	$coupon = Coupons::where('id','=',$request->edit_id)->update([
    		'coupon_code'=>$request->edit_coupon_code,
    		'discount'=> $percent,
    		'value'=>$value,
    		'valid_until'=>$request->edit_valid_until,
    		'coupon_description'=>$request->edit_coupon_description,
    	]);

    	if($coupon == true)
    	{
    		$data['message'] = 'Data kupon telah berhasil diubah';
    	} else {
    		$data['message'] = 'Error! data kupon gagal diubah';
    	}
    	return response()->json($data);
    }

/* end CouponController */
}
