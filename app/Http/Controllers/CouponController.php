<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;

use Validator;

class CouponController extends Controller
{ 
    protected function validator(array $data)
    {
      return Validator::make($data, [
        'kodekupon' => ['required','string','unique:coupons'],
        'diskon_value' => ['required','integer','min:0'],
        'diskon_percent' => ['required','integer','min:0','max:100'],
        'valid_until' => ['required','date','after:today'],
      ]);
    }

    public function index(){
      return view('admin.list-coupon.index');
    }

    public function load_coupon(Request $request){
      $coupons = Coupon::All();

      $arr['view'] = (string) view('admin.list-coupon.content')
              ->with('coupons',$coupons);  
      return $arr;
    }

    public function add_coupon(Request $request){
      $validator = $this->validator($request->all());

      if(!$validator->fails()){
        $coupon = new Coupon;
        $coupon->kodekupon = $request->kodekupon;
        $coupon->diskon_value = $request->diskon_value;
        $coupon->diskon_percent = $request->diskon_percent;
        $coupon->valid_until = $request->valid_until;
        $coupon->valid_to = $request->valid_to;
        $coupon->keterangan = $request->keterangan;
        $coupon->package_id = $request->package_id;
        $coupon->save();

        $arr['status'] = 'success';
        $arr['message'] = 'Kupon berhasil ditambahkan';
      } else {
        $arr['status'] = 'error';
        $arr['message'] = $validator->errors()->first();
      }

      return $arr;
    }

    public function edit_coupon(Request $request){
      $validator = $this->validator($request->all());

      if($validator->fails()){
        $failedRules = $validator->failed();

        if(isset($failedRules['kodekupon']['Unique'])){
        } else {
          $arr['status'] = 'error';
          $arr['message'] = $validator->errors()->first();
          return $arr;
        }
      }

      $coupon = Coupon::find($request->id_edit);
      $coupon->kodekupon = $request->kodekupon;
      $coupon->diskon_value = $request->diskon_value;
      $coupon->diskon_percent = $request->diskon_percent;
      $coupon->valid_until = $request->valid_until;
      $coupon->valid_to = $request->valid_to;
      $coupon->keterangan = $request->keterangan;
      $coupon->package_id = $request->package_id;
      $coupon->save();

      $arr['status'] = 'success';
      $arr['message'] = 'Kupon berhasil diedit';
      return $arr;
    }

    public function delete_coupon(Request $request){
      $coupon = Coupon::find($request->id)
                  ->delete();

      $arr['status'] = 'success';
      $arr['message'] = 'Delete kupon berhasil';

      return $arr;
    }
}
