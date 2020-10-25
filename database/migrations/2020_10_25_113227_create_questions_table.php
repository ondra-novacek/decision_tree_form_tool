<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dt_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('text');
            $table->boolean('isRoot')->nullable();
            $table->integer('questionType_id')->unsigned();
            $table->integer('survey_id')->unsigned();
            $table->timestamps();

            $table->foreign('survey_id')->references('id')->on('dt_surveys');
            $table->foreign('questionType_id')->references('id')->on('dt_q_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dt_questions');
    }
}
