<?php

if (!function_exists('cleanMetaDescription')) {
    function cleanMetaDescription($text, $limit = 160)
    {
        $clean = strip_tags($text);
        $clean = html_entity_decode($clean);
        return \Illuminate\Support\Str::limit($clean, $limit);
    }
}
