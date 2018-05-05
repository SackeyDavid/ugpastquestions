<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePastQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('past_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('department');
            $table->string('course_code');
            $table->string('course_title');
            $table->string('level');
            $table->integer('year');
            $table->string('uploaded_by');
            $table->string('path');
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
        Schema::dropIfExists('past_questions');
    }
}
