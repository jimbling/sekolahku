<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        $this->call([
            UsersSeeder::class,
            AcademicYearSeeder::class,
            SiswaSeeder::class,
            GtkSeeder::class,
            ClassroomSeeder::class,
            RombonganBelajarSeeder::class,
            AnggotaRombelSeeder::class,
            CategoriesSeeder::class,
            PostSeeder::class,
            MenuSeeder::class,
            SettingsTableSeeder::class,
            CategoriesPostSeeder::class,

        ]);
    }
}
