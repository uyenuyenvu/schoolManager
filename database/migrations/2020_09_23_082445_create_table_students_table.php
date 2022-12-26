<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('tên học sinh');
            $table->string('father_name')->nullable()->comment('tên bố');
            $table->string('mother_name')->nullable()->comment('tên mẹ');
            $table->string('birth_day')->nullable()->comment('ngày sinh');
            $table->string('phone')->nullable()->comment('số điện thoại');
            $table->string('home_town')->nullable()->comment('quê quán');
            $table->bigInteger('class_id')->nullable()->comment('id bảng lớp');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
