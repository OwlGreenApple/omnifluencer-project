<?php

namespace App\Http\Middleware;

use Closure;
use App\Coupons;
use Illuminate\Support\Facades\Validator;
use App\Rules\CheckCouponCode;

class CouponValidator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
         $validator = Validator::make($request->all(), [
            'coupon_code'=> ['required',new CheckCouponCode,'numeric'],
            'coupon_discount'=> ['numeric'],
            'coupon_value'=> ['numeric'],
            'valid_until'=> ['required','date'],
        ]);

        if ($validator->fails()) {
            $data['success'] = false;
            $err = $validator->errors();
            $data['coupon_code'] = $err->first('coupon_code');
            $data['coupon_discount'] = $err->first('coupon_discount');
            $data['coupon_value'] = $err->first('coupon_value');
            $data['valid_until'] = $err->first('valid_until');
            $data['coupon_description'] = $err->first('coupon_description');
            return response()->json($data);
        } else {
            return $next($request);
        }
        
    }
}
