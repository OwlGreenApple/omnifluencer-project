<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Coupons;

class CheckCouponCode implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->couponCheck($value);
    }

   /* Check coupon code */
    private function couponCheck($coupon_code)
    {
        /* Get coupon code data */
        $check_code = Coupons::where([
            ['coupon_code','=',$coupon_code],
        ])->count();

        /* Check whether coupon code had used or not  */
        if($check_code > 0){
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Kode Kupon Telah Terpakai! Silahkan Buat Yang Lain';
    }
}
