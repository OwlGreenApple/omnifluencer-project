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
        return $this->couponCheckUnique($value);
    }

   /* Check coupon code whether unique or not */
    private function couponCheckUnique($coupon_code)
    {
        /* Get coupon code value from form */
        $check_code = count(array_count_values(str_split($coupon_code)));
        if($check_code >= 5){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Kode kupon harus unik';
    }
}
