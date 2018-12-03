<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('orders', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('no_order');
          $table->bigInteger('user_id');
          $table->integer('jmlpoin');
          $table->double('total');
          $table->timestamp('tanggal_pesan');
          $table->smallInteger('status')->default(0);
          $table->text('buktibayar')->nullable();
          $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
