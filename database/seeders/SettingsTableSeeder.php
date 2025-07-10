<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Imports\SettingsImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Excel::import(new SettingsImport, storage_path('app/public/settings.csv'));
        $defaults = [
            [
                'key' => 'map_lat',
                'setting_value' => '-7.82480000',
                'settings_name' => 'Koordinat Latitude',
                'setting_group' => 'school_profile',
                'setting_default_value' => '-7.82480000',
                'setting_access_group' => 'public',
                'setting_description' => 'Koordinat Latitude untuk peta lokasi',
                'modal_type' => 'input',
            ],
            [
                'key' => 'map_lng',
                'setting_value' => '110.13520000',
                'settings_name' => 'Koordinat Longitude',
                'setting_group' => 'school_profile',
                'setting_default_value' => '110.13520000',
                'setting_access_group' => 'public',
                'setting_description' => 'Koordinat Longitude untuk peta lokasi',
                'modal_type' => 'input',
            ],
            [
                'key' => 'akreditasi',
                'setting_value' => 'A',
                'settings_name' => 'Akreditasi Sekolah',
                'setting_group' => 'school_profile',
                'setting_default_value' => 'A',
                'setting_access_group' => 'public',
                'setting_description' => 'Status Akreditasi Sekolah',
                'modal_type' => 'input',
            ],
            // Tambahkan lainnya di sini...
        ];

        foreach ($defaults as $setting) {
            Setting::firstOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
