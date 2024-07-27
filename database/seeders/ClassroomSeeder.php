<?php

namespace Database\Seeders;

use App\Models\Classroom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Data contoh untuk tabel academic_years
        $classrooms = [
            [
                'name' => 'Kelas 1',

            ],

        ];

        // Insert data ke tabel academic_years menggunakan Eloquent model
        foreach ($classrooms as $data) {
            Classroom::create($data);
        }
    }
}
