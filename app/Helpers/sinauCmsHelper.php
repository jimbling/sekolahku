<?php

if (!function_exists('system_info')) {
    function system_info(string $key = null)
    {
        $info = [
            'name' => 'Sinau CMS',
            'url' => 'https://sinaucms.web.id',
            'author' => 'Sarjiyanto',
        ];

        return $key ? ($info[$key] ?? null) : $info;
    }
}

if (!function_exists('clean_url')) {
    function clean_url($url)
    {
        return rtrim($url, '/');
    }
}
