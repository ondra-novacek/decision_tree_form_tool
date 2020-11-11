<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dt_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('text');
            $table->integer('survey_id')->unsigned();
            $table->timestamps();

            $table->foreign('survey_id')->references('id')->on('dt_surveys')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dt_answers', function (Blueprint $table) {
            $table->dropForeign('dt_answers_survey_id_foreign');
        });
        Schema::dropIfExists('dt_answers');
    }
}
