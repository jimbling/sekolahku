<?php

use App\Models\Setting;

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        // Cari pengaturan di database berdasarkan key
        $setting = Setting::where('key', $key)->first();

        // Jika pengaturan ditemukan, kembalikan nilai setting_value; jika tidak, kembalikan nilai default
        return $setting ? $setting->setting_value : $default;
    }
}
