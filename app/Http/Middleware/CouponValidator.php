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

        /* To check if admin choose discount type if page is edit page  */
        $error = true;
        $get_coupon_code = null;
        if(empty($request->edit_coupon_value) && $request->edit_coupon_discount == 0 && $request->editable == 1)
        {
             $data['success'] = false;
             $data['error'] = 'Anda harus memilih salah satu dari diskon % atau value';
             return response()->json($data);
        } else {
              $error = false;
        }


        /* To check if admin choose discount type if page is add page  */
        if(empty($request->coupon_value) && $request->coupon_discount == 0 && empty($request->editable)) {
             $data['success'] = false;
             $data['error'] = 'Anda harus memilih salah satu dari diskon % atau value';
             return response()->json($data);
        } else {
              $error = false;
        } 

        /* Custom message */
        $customMessages = [
            'required' => 'Kolom tidak boleh kosong.',
            'numeric' => 'Kolom harus berupa angka.',
            'date' => 'Kolom harus berupa tanggal.',
            'unique' => 'Kode kupon sudah terpakai.',
            'min' => 'Kolom paling sedikit :min karakter.',
            'max' => 'Kolom maksimal adalah :max karakter.',
        ];

        /* Check coupon code to determine code is available or not, 
            if available it will pass, but if not it will check the code
        */
        if($request->editable == 1){
            $check_coupon_code = Coupons::where('id','=',$request->edit_id)->first();
            $get_coupon_code = $check_coupon_code->coupon_code;
        } 

        /* if coupon code match then it would be pass */
        if( $get_coupon_code == $request->edit_coupon_code && $request->editable == 1){
            $arr_rule = [];
        } else {
            $arr_rule = ['required','unique:coupons,coupon_code','min:5','max:190',new CheckCouponCode];
        }
    
        /* if page is edited ($request->editable == 1) then use first rule */
        if($request->editable == 1){
             $rules = [
                'edit_coupon_code'=>$arr_rule,
                'edit_coupon_discount'=> ['numeric'],
                'edit_coupon_value'=> ['numeric','nullable'],
                'edit_valid_until'=> ['required','date'],
            ];
        } else {
             $rules = [
                'coupon_code'=> ['required','unique:coupons,coupon_code','min:5','max:190',new CheckCouponCode],
                'coupon_discount'=> ['numeric'],
                'coupon_value'=> ['numeric','nullable'],
                'valid_until'=> ['required','date'],
            ];
        }

         $validator = Validator::make($request->all(), $rules, $customMessages);

        if ($validator->fails() && $request->editable == 1 &&  $error == false) {
            $data['success'] = false;
            $err = $validator->errors();
            $data['edit_coupon_code'] = $err->first('edit_coupon_code');
            $data['edit_coupon_discount'] = $err->first('edit_coupon_discount');
            $data['edit_coupon_value'] = $err->first('edit_coupon_value');
            $data['edit_valid_until'] = $err->first('edit_valid_until');
            $data['error'] = null;
            return response()->json($data);
        } else if($validator->fails() && $error == false) {
            $data['success'] = false;
            $err = $validator->errors();
            $data['coupon_code'] = $err->first('coupon_code');
            $data['coupon_discount'] = $err->first('coupon_discount');
            $data['coupon_value'] = $err->first('coupon_value');
            $data['valid_until'] = $err->first('valid_until');
            $data['error'] = null;
            return response()->json($data);
        } else {
            return $next($request);
        }
        
    }

/* End validator */    
}
