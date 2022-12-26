<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Schema::hasTable('divisions')) {
            Division::truncate();
            Division::create([
                'name'      => '10',
                'description'     => 'Khối lớp 10',
            ]);
            Division::create([
                'name'      => '11',
                'description'     => 'Khối lớp 11',
            ]);
            Division::create([
                'name'      => '12',
                'description'     => 'Khối lớp 12s',
            ]);

        }
    }
}
