<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalCalcTableAccountLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('account_logs', function (Blueprint $table) {
        $table->bigInteger('total_calc')->default(0)->after('total_influenced');
        $table->bigInteger('total_compare')->default(0)->after('total_calc');
      });
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
