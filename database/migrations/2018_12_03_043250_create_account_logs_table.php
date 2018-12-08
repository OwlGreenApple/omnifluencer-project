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
            $table->integer('jml_followers')->default(0);
            $table->integer('jml_following')->default(0);
            $table->integer('jml_post')->default(0);
            $table->timestamp('lastpost')->default(null)->nullable();
            $table->integer('jml_likes')->default(0);
            $table->integer('jml_comments')->default(0);
            $table->double('eng_rate',8,4)->default(0);
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
