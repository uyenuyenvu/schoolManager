<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('tên');
            $table->string('phone')->nullable()->comment('số điện thoại');
            $table->string('email')->unique()->comment('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('title')->nullable()->comment('chức vụ');
            $table->date('birthday')->nullable()->comment('ngày sinh');
            $table->bigInteger('avatar')->nullable()->comment('avatar');
            $table->tinyInteger('is_active')->default(0)->comment('0:ngừng kích hoạt - 1:kích hoạt');
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
        Schema::dropIfExists('teachers');
    }
}
