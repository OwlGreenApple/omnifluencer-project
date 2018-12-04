<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Referral;

use Auth;

class ReferralController extends Controller
{
  protected $cookie_name = "referral_link";

  public function index() {
    return view('user.referral.index')
            ->with('user',Auth::user());
  }

  public function load_referral(Request $request){
    $user_takers = Referral::join('users','referrals.user_id_taker','=','users.id')
              ->select('referrals.*','users.name','users.email')
              ->where(function($query) use ($request) {
                  $query->where('email','like','%'.$request->keywords.'%')
                        ->orWhere('name','like','%'.$request->keywords.'%'); 
                  })
              ->where('referrals.user_id_giver',Auth::user()->id)->paginate(15);

    $arr['view'] = (string) view('user.referral.content')
                            ->with('user_takers',$user_takers); 
    $arr['pager'] = (string) view('user.referral.pagination')
                            ->with('user_takers',$user_takers); 
    return $arr;
  }

  public function refer($rand) {
    //dd(User::where('referral_link',$rand)->exists());
    if(!User::where('referral_link',$rand)->exists()) {
      return redirect('/');
    } else if(!Auth::check()){
      if(!isset($_COOKIE[$this->cookie_name]) || $_COOKIE[$this->cookie_name]!=$rand) {
        $cookie_value = $rand;
        // set cookie for 30days, 86400 = 1 day
        setcookie($this->cookie_name, $cookie_value, time() + (86400 * 30), "/");
      }
      return redirect('/register');
    } else {
      return redirect('/');
    }
  }
}
