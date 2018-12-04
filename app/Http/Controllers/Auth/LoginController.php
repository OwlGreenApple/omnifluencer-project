<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\User;

use Crypt, Carbon;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function verifyEmail($cryptedcode){
      try {
        $decryptedcode = Crypt::decrypt($cryptedcode);
        $data = json_decode($decryptedcode);
        $user = User::where("email","=",$data->email)->first();
        if (!is_null($user)) {
          // Check customer email and status
          if (!$user->is_confirm){
            // Check Verification Code
            if ($user->confirm_code == $data->confirm_code){
              $reg_date = Carbon::createFromFormat('Y-m-d H:i:s', $data->register_time);
                // Change customer status to verified, then redirect to Home
                $user->is_confirm = 1;
                $user->save();
                
                return redirect('/login')->with("success","Welcome to Omnifluencer! Thank you for confirming your e-mail address.");  
            }
            else{
              return redirect(404);
            }
          }
          else{
            return redirect(404);
          }
        }
        else{
          return redirect(404);
        }
      } catch (DecryptException $e) {
        return redirect(404);
      }
    }
}
