<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('students'); // Optional: truncate the table before seeding

        $faker = Faker::create('id_ID'); // Set locale to Indonesian
        $students = [];

        for ($i = 1; $i <= 20; $i++) {
            $students[] = [
                'name' => $faker->name,
                'nis' => $faker->unique()->numberBetween(1000, 9999),
                'birth_place' => $faker->city,
                'birth_date' => $faker->date(),
                'gender' => $faker->randomElement(['F', 'M']),
                'email' => $faker->unique()->safeEmail,
                'student_status_id' => 1,
                'end_date' => null,
                'reason' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Student::insert($students);
    }
}
