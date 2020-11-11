<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dt_question_answer', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id')->unsigned();
            $table->integer('answer_id')->unsigned();
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('dt_questions')->onDelete('cascade');
            $table->foreign('answer_id')->references('id')->on('dt_answers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dt_question_answer', function (Blueprint $table) {
            $table->dropForeign('dt_question_answer_question_id_foreign');
            $table->dropForeign('dt_question_answer_answer_id_foreign');
        });
        Schema::dropIfExists('dt_question_answer');
    }
}
