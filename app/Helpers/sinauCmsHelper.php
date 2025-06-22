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
