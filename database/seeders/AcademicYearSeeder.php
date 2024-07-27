<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicYear;

class AcademicYearSeeder extends Seeder
{
    public function run()
    {

        $academicYears = [
            [
                'academic_year' => '2024-2025',
                'semester' => 'ganjil',
                'current_semester' => true,
            ],

        ];


        foreach ($academicYears as $data) {
            AcademicYear::create($data);
        }
    }
}
