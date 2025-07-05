<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

return new class extends Migration
{
    public function up(): void
    {
        // Cek apakah data sudah ada
        if (!Setting::where('key', 'akreditasi')->exists()) {
            Setting::create([
                'key' => 'akreditasi',
                'setting_value' => 'A',
                'settings_name' => 'Akreditasi Sekolah',
                'setting_group' => 'school_profile',
                'setting_default_value' => 'A',
                'setting_access_group' => 'public',
                'setting_description' => 'Status Akreditasi Sekolah',
                'modal_type' => 'input',
            ]);
        }
    }

    public function down(): void
    {
        Setting::where('key', 'akreditasi')->delete();
    }
};
