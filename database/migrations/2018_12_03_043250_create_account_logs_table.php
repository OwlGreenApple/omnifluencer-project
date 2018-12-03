<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id');
            $table->integer('jml_followers')->nullable();
            $table->integer('jml_following')->nullable();
            $table->integer('jml_post')->nullable();
            $table->timestamp('lastpost')->default(null)->nullable();
            $table->integer('jml_likes')->nullable();
            $table->integer('jml_comments')->nullable();
            $table->double('eng_rate',8,2)->nullable();
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
        Schema::dropIfExists('account_logs');
    }
}
