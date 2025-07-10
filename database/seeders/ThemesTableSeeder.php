<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ThemesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('themes')->insert([
            [
                'id' => 1,
                'theme_name' => 'Arunika',
                'folder_name' => 'arunika',
                'display_name' => 'arunika',
                'description' => 'Fajar pertama, cahaya awal, simbol awal perjalanan ilmu',
                'is_active' => 0,
                'settings' => null,
                'created_at' => Carbon::parse('2025-05-30 22:56:31'),
                'updated_at' => Carbon::parse('2025-07-09 02:11:51'),
            ],
            [
                'id' => 7,
                'theme_name' => 'Default',
                'folder_name' => 'default',
                'display_name' => 'default',
                'description' => 'Tema bawaan CMS Sinau',
                'is_active' => 0,
                'settings' => null,
                'created_at' => Carbon::parse('2025-05-31 10:15:45'),
                'updated_at' => Carbon::parse('2025-07-09 02:11:33'),
            ],
            [
                'id' => 10,
                'theme_name' => 'Pradipa',
                'folder_name' => 'pradipa',
                'display_name' => 'pradipa',
                'description' => 'Cahaya kecil / lentera, simbol penerang dalam kegelapan belajar',
                'is_active' => 1,
                'settings' => null,
                'created_at' => Carbon::parse('2025-06-27 06:05:45'),
                'updated_at' => Carbon::parse('2025-07-09 02:11:51'),
            ],
        ]);
    }
}
