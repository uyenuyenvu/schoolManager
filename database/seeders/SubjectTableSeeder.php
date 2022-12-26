<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subject::create([
            'name'=>'Toán học'
        ]);
        Subject::create([
            'name'=>'Vật Lý'
        ]);
        Subject::create([
            'name'=>'Hóa học'
        ]);
        Subject::create([
            'name'=>'Ngữ văn'
        ]);
        Subject::create([
            'name'=>'Tiếng Anh'
        ]);
        Subject::create([
            'name'=>'Sinh học'
        ]);
        Subject::create([
            'name'=>'Lịch sử'
        ]);
        Subject::create([
            'name'=>'Địa lý'
        ]);
        Subject::create([
            'name'=>'Thể chất'
        ]);
        Subject::create([
            'name'=>'Tin học'
        ]);
        Subject::create([
            'name'=>'Giáo dục công dân'
        ]);
        Subject::create([
            'name'=>'Công nghệ'
        ]);
    }
}
