<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            //Relation on Referendums table
            $table->integer('referendum_id')->unsigned()->nullable();
            $table->foreign('referendum_id')->references('id')->on('referendums');

            //Relation on Referendums table
            $table->integer('election_id')->unsigned()->nullable();
            $table->foreign('election_id')->references('id')->on('elections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('histories');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

//        Schema::dropIfExists('history');
    }
}
