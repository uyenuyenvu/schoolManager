<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('day_index')->nullable()->comment('thứ tự ngày trong tuần');
            $table->integer('lesson_index')->nullable()->comment('thứ tự tiết');
            $table->bigInteger('subject_id')->nullable()->comment('id moon hoc');
            $table->bigInteger('teacher_id')->nullable()->comment('id gv');
            $table->bigInteger('class_id')->nullable()->comment('id lop');
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
        Schema::dropIfExists('schedules');
    }
}
