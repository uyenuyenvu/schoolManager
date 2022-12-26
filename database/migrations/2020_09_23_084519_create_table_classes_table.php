<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Tên lớp');
            $table->string('division_id')->comment('Mã khối');
            $table->string('teacher_id')->comment('Mã giáo viên chủ nhiệm');
            $table->string('descriptions')->nullable()->comment('Mô tả');
            $table->tinyInteger('is_active')->comment('0:chưa kích hoạt - 1:Đã kích hoạt');
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
        Schema::dropIfExists('facuties');
    }
}
