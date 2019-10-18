<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidateElectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_elections', function (Blueprint $table) {
            $table->increments('id');
            $table->double('score');
            $table->boolean('approved');
            $table->timestamps();
            $table->softDeletes();

            //Relation on candidates table
            $table->integer('candidate_id')->unsigned();
            $table->foreign('candidate_id')->references('id')->on('candidates');

            //Relation on elections table
            $table->integer('election_id')->unsigned();
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
        Schema::dropIfExists('candidate_elections');
    }
}
