<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class TeacherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Schema::hasTable('teachers')) {
            Teacher::truncate();
            Teacher::create([
                'name'      => 'Thực',
                'email'     => 'Teacher@gmail.com',
                'password'  => Hash::make(12345678),
                'title'     =>'Giáo viên',
                'is_active' => 1,
            ]);
            Teacher::create([
                'name'      => 'Uyên',
                'email'     => 'uyen@gmail.com',
                'password'  => Hash::make(12345678),
                'title'     =>'Giáo viên',
                'is_active' => 1,
            ]);

        }
    }
}
