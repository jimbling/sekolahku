<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OptionTrueFalseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $options = [
            ['id' => 177, 'option_group' => 'site_maintenance', 'option_name' => 'true', 'created_at' => '2024-07-12 07:14:29', 'updated_at' => '2024-07-12 07:14:29'],
            ['id' => 178, 'option_group' => 'site_maintenance', 'option_name' => 'false', 'created_at' => '2024-07-12 07:14:29', 'updated_at' => '2024-07-12 07:14:29'],
            ['id' => 179, 'option_group' => 'site_cache', 'option_name' => 'true', 'created_at' => '2024-07-17 21:07:23', 'updated_at' => '2024-07-17 21:07:23'],
            ['id' => 180, 'option_group' => 'site_cache', 'option_name' => 'false', 'created_at' => '2024-07-17 21:07:23', 'updated_at' => '2024-07-17 21:07:23'],
            ['id' => 181, 'option_group' => 'preloader', 'option_name' => 'true', 'created_at' => '2024-07-25 11:24:46', 'updated_at' => '2024-07-25 11:24:46'],
            ['id' => 182, 'option_group' => 'preloader', 'option_name' => 'false', 'created_at' => '2024-07-25 11:24:46', 'updated_at' => '2024-07-25 11:24:46'],
        ];

        foreach ($options as $option) {
            DB::table('options')->updateOrInsert(
                ['id' => $option['id']], // Conditionally update or insert based on the 'id'
                [
                    'option_group' => $option['option_group'],
                    'option_name' => $option['option_name'],
                    'created_at' => Carbon::parse($option['created_at']),
                    'updated_at' => Carbon::parse($option['updated_at']),
                ]
            );
        }
    }
}
