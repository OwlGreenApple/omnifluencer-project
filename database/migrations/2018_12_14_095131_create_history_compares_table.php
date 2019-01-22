<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryComparesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_compares', function (Blueprint $table) {
            $table->increments('id');
            $table->biginteger('user_id');
            $table->biginteger('account_id_1');
            $table->biginteger('account_id_2')->nullable();
            $table->biginteger('account_id_3')->nullable();
            $table->biginteger('account_id_4')->nullable();
            $table->integer('jml_compare')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_compares');
    }
}
