<?php

use App\Models\Setting;

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        static $settings = null;

        if ($settings === null) {
            $settings = Setting::pluck('setting_value', 'key')->toArray(); // hanya 1 query!
        }

        return $settings[$key] ?? $default;
    }
}
