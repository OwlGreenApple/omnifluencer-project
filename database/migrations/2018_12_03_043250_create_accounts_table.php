<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ig_id')->nullable();
            $table->string('username');
            $table->integer('user_id');
            $table->string('prof_pic')->nullable();
            $table->integer('voting')->nullable();
            $table->string('categories')->nullable();
            $table->integer('jml_followers')->nullable();
            $table->integer('jml_following')->nullable();
            $table->integer('jml_post')->nullable();
            $table->timestamp('lastpost')->default(null)->nullable();
            $table->integer('jml_likes')->nullable();
            $table->integer('jml_comments')->nullable();
            $table->double('eng_rate',8,2)->nullable();
            $table->string('twitter')->nullable();
            $table->string('web')->nullable();
            $table->string('nohp')->nullable();
            $table->string('email')->nullable();
            $table->string('location')->nullable();
            $table->string('youtube')->nullable();
            $table->text('about')->nullable();
            $table->smallInteger('status')->default(0)->nullable();
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
        Schema::dropIfExists('accounts');
    }
}
