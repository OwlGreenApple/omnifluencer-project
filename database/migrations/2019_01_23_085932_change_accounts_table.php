<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('accounts', function (Blueprint $table) {
            $table->integer('jml_followers')->default(0)->nullable()->change();
            $table->integer('jml_following')->default(0)->nullable()->change();
            $table->integer('jml_post')->default(0)->nullable()->change();
            $table->integer('jml_likes')->default(0)->nullable()->change();
            $table->integer('jml_comments')->default(0)->nullable()->change();
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
