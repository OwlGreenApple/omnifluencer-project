<?php 
namespace App\Helpers;

/**
* 
*/
use Carbon;
use DB, Crypt, App;

class Helper
{
  public static function abbreviate_number($n,$precision){
    if ($n < 999) {
      // 0 - 900
      $n_format = number_format($n, $precision);
      $suffix = '';
    } else if ($n < 999999) {
      // 0.9k-850k
      $n_format = number_format($n / 1000, $precision);
      $suffix = 'k';
    } else if ($n < 999999999) {
      // 0.9m-850m
      $n_format = number_format($n / 1000000, $precision);
      $suffix = 'm';
    } else if ($n < 999999999999) {
      // 0.9b-850b
      $n_format = number_format($n / 1000000000, $precision);
      $suffix = 'b';
    } else {
      // 0.9t+
      $n_format = number_format($n / 1000000000000, $precision);
      $suffix = 't';
    }
    // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
    // Intentionally does not affect partials, eg "1.50" -> "1.50"
    if ( $precision > 0 ) {
      $dotzero = '.' . str_repeat( '0', $precision );
      $n_format = str_replace( $dotzero, '', $n_format );
    }

    return $n_format . $suffix;
  }

  public static function getTimeAgo($created_at){
    $time = Carbon::createFromTimeStamp(strtotime($created_at))->diffForHumans();   
    $time = str_replace('ago', '', $time);
    $arr_time = explode(' ', $time);
    
    $diff = $arr_time[1][0];

    if($arr_time[1]=='minute'||$arr_time[1]=='minutes'){
      $diff = substr($arr_time[1], 0,3);
    }
    if($arr_time[1]=='month'||$arr_time[1]=='months'){
      $diff = substr($arr_time[1], 0,2);
    }

    $newtime = $arr_time[0].$diff;

    return $newtime;
  }

  public static function autoGenerateID($model, $field, $search, $pad_length, $pad_string = '0')
  {
    $tb = $model->select(DB::raw("substr(".$field.", ".strval(strlen($search)+1).") as lastnum"))
								->whereRaw("substr(".$field.", 1, ".strlen($search).") = '".$search."'")
								->orderBy('id', 'DESC')
								->first();
		if ($tb == null){
			$ctr = 1;
		}
		else{
			$ctr = intval($tb->lastnum) + 1;
		}
		return $search.str_pad($ctr, $pad_length, $pad_string, STR_PAD_LEFT);
  }
	
}

?>