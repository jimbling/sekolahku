<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RombonganBelajarSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rombongan_belajars')->insert([
            [
                'academic_years_id' => 1,
                'classroom_id' => 1,
                'gtks_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Jika perlu menambah baris lain, bisa ditambahkan di sini
            // [
            //     'academic_years_id' => 1,
            //     'classroom_id' => 1,
            //     'gtks_id' => 1,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
        ]);
    }
}
