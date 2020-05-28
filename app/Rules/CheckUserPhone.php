<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\User;

class CheckUserPhone implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $code_country;
    public $userid;
    public function __construct($code_country)
    {
        $this->code_country = $code_country;
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
        $phone = $this->code_country.$value;
        $user = User::where('wa_number',$phone)->first();

        if(is_null($user))
        {
            return true;
        }
        else
        {   
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
        return 'Phone number had registered already.';
    }
}
