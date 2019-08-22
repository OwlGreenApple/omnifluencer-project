<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $connection = 'mysql2';

    /*
	status :
	0 => hasn't paid off
	1 => paid off
	2 => expired
    */

    /*
	order_type :
	0 => bank transfer
	1 => ovo
    */

}
