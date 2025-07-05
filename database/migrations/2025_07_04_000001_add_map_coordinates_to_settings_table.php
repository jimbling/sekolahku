<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

return new class extends Migration
{
    public function up(): void
    {
        // Tambahkan 'map_lat' jika belum ada
        if (!Setting::where('key', 'map_lat')->exists()) {
            Setting::create([
                'key' => 'map_lat',
                'setting_value' => '-7.82480000',
                'settings_name' => 'Koordinat Latitude',
                'setting_group' => 'school_profile',
                'setting_default_value' => '-7.82480000',
                'setting_access_group' => 'public',
                'setting_description' => 'Koordinat Latitude untuk peta lokasi',
                'modal_type' => 'input',
            ]);
        }

        // Tambahkan 'map_lng' jika belum ada
        if (!Setting::where('key', 'map_lng')->exists()) {
            Setting::create([
                'key' => 'map_lng',
                'setting_value' => '110.13520000',
                'settings_name' => 'Koordinat Longitude',
                'setting_group' => 'school_profile',
                'setting_default_value' => '110.13520000',
                'setting_access_group' => 'public',
                'setting_description' => 'Koordinat Longitude untuk peta lokasi',
                'modal_type' => 'input',
            ]);
        }
    }

    public function down(): void
    {
        Setting::whereIn('key', ['map_lat', 'map_lng'])->delete();
    }
};
