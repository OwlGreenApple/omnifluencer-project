<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username');
            $table->string('password');
            $table->boolean('gender')->default(0)->nullable();
            $table->integer('point')->nullable();
            $table->boolean('is_admin')->default(0)->nullable();
            $table->boolean('is_confirm')->default(0)->nullable();
            $table->string('confirm_code')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->smallInteger('status_membership')->default(0)->nullable();
            $table->string('referral_link')->nullable();
            // $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
