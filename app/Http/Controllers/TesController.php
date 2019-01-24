<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\AccountController;

class TesController extends Controller
{
    public function tes_igcallback(){
      $url2 = "http://cmx.space/get-user-feed/kafilahgadget";
      $arr_res2 = AccountController::igcallback($url2);

      if(!is_null($arr_res2) and !empty($arr_res2)){
        return $arr_res2;
      } else {
        return 'false';
      }
    }
}
