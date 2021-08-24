<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('lesson_id');
            $table->unsignedBigInteger('answer_id')->nullable();
            $table->unsignedBigInteger('word_id');
            $table->boolean('status')->nullable();
            $table->timestamps();
            $table->foreign('lesson_id')->references('id')->on('lessons');
            $table->foreign('answer_id')->references('id')->on('answers');
            $table->foreign('word_id')->references('id')->on('words');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lesson_results');
    }
}
