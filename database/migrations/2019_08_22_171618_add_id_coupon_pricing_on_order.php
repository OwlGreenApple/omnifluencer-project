<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdCouponPricingOnOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('mysql2')->statement('ALTER TABLE orders ADD id_coupon bigint(20) DEFAULT 0 AFTER jmlpoin');
        DB::connection('mysql2')->statement('ALTER TABLE orders ADD pricing DOUBLE(16,2) AFTER id_coupon'); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
