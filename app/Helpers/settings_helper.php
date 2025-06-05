<?php

use App\Models\Setting;

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        static $settings = null;

        if ($settings === null) {
            $settings = Setting::pluck('setting_value', 'key')->toArray(); // hanya 1 query!
        }

        $value = $settings[$key] ?? $default;

        // Tambahan: ubah string 'true' dan 'false' menjadi boolean asli
        if (is_string($value)) {
            if (strtolower($value) === 'true') return true;
            if (strtolower($value) === 'false') return false;
        }

        return $value;
    }
}
