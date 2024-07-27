<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class GtkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $genders = ['M', 'F']; // Gender options

        foreach (range(1, 20) as $index) {
            DB::table('gtks')->insert([
                'full_name' => $faker->name,
                'gender' => $faker->randomElement($genders),
                'parent_school_status' => $faker->boolean,
                'gtk_status' => $faker->randomElement(['Aktif', 'Non-Aktif']),
                'email' => $faker->unique()->safeEmail,
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
