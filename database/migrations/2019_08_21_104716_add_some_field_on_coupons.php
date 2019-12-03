<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSomeFieldOnCoupons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE coupons CHANGE id id BIGINT(20)');
        DB::statement('ALTER TABLE coupons CHANGE kodekupon coupon_code VARCHAR(191)');
        DB::statement('ALTER TABLE coupons ADD coupon_name VARCHAR(191) AFTER id');
        DB::statement('ALTER TABLE coupons CHANGE diskon discount SMALLINT(6) DEFAULT 0');
        DB::statement('ALTER TABLE coupons ADD value DOUBLE(16,2) DEFAULT 0 AFTER discount');
        DB::statement('ALTER TABLE coupons ADD valid_until DATE AFTER value');
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
