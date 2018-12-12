<?php 
namespace App\Helpers;

/**
* 
*/

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
}

?>