<?php

namespace Database\Seeders;

use App\Models\AnggotaRombel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnggotaRombelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        $anggotaRombel = [
            [
                'rombel_id' => '1',
                'student_id' => '1',
            ],

        ];

        foreach ($anggotaRombel as $data) {
            AnggotaRombel::create($data);
        }
    }
}
