<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_times', function (Blueprint $table) {
            $table->id();
            $table->string('class');
            $table->string('subject');
            $table->integer('teacher_id');
            $table->string('exam_title');
            $table->time('exam_time');
            $table->date('exam_date');
            $table->integer('exam_hr');
            $table->integer('exam_min');
            $table->string('exam_description');
            $table->string('exam_status')->default('Deactive');
            $table->string('exam_done')->default('No');
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
        Schema::dropIfExists('exam_times');
    }
};
