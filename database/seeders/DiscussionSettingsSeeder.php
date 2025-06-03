<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class DiscussionSettingsSeeder extends Seeder
{
    public function run()
    {
        Setting::updateOrCreate(
            ['key' => 'komentar_engine'],
            [
                'setting_group' => 'discussion',
                'settings_name' => 'Sistem Komentar',
                'setting_value' => 'native', // nilai aktif saat ini
                'setting_default_value' => 'native', // default
                'setting_access_group' => 'public',
                'setting_description' => 'Pilih jenis komentar yang digunakan (native/disqus)',
                'modal_type' => 'select',
            ]
        );

        Setting::updateOrCreate(
            ['key' => 'disqus_api_key'],
            [
                'setting_group' => 'discussion',
                'settings_name' => 'Disqus Api Key',
                'setting_value' => 'your_disqus_api_key_here',
                'setting_default_value' => 'your_disqus_api_key_here',
                'setting_access_group' => 'public',
                'setting_description' => 'Disqus Api Key',
                'modal_type' => 'input',
            ]
        );

        Setting::updateOrCreate(
            ['key' => 'shortname_disqus'],
            [
                'setting_group' => 'discussion',
                'settings_name' => 'Shortname Disqus',
                'setting_value' => 'your_disqus_shortname_here',
                'setting_default_value' => 'your_disqus_shortname_here',
                'setting_access_group' => 'public',
                'setting_description' => 'Shortname Disqus',
                'modal_type' => 'input',
            ]
        );
    }
}
