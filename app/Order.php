<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $connection = 'mysql2';

    /*
	status :
	0 => pending
	1 => user has confirmed
	2 => admin confirm / autoconfirm
	3 => expired
    */

    /*
	order_type :
	0 => bank transfer
	1 => ovo
    */

}
