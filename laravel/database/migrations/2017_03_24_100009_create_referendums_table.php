<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferendumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referendums', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description');
            $table->boolean('isClosed');
            $table->dateTime('startDate');
            $table->dateTime('endDate');
            $table->dateTime('published')->nullable();
            $table->timestamps();
            $table->softDeletes();

            //Relation on candidates table
            $table->integer('candidate_id')->unsigned();
            $table->foreign('candidate_id')->references('id')->on('candidates');

            //Relation on groups table
            $table->integer('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('groups');

            //Relation on votamanagers table
            $table->integer('votemanager_id')->unsigned();
            $table->foreign('votemanager_id')->references('id')->on('votemanagers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referendums');
    }
}
