<?php

namespace App\Helpers;

class PermissionHelper
{
    public static function getUserFriendlyName($permissionName)
    {
        $mapping = [
            'edit_posts' => 'Postingan',
            'edit_categories' => 'Kategori',
            'edit_tags' => 'Tag',
            'edit_kutipan' => 'Kutipan',
            'edit_tautan' => 'Tautan',
            'edit_halaman' => 'Halaman',
            'edit_hubungi' => 'Hubungi',
            'edit_pengaturan' => 'Pengaturan',
            'edit_gtk' => 'GTK',
            'edit_file' => 'File',
            'edit_video' => 'Video',
            'edit_menu' => 'Menu',
            'edit_rombel' => 'Rombel',
            'edit_pd' => 'Peserta Didik',
            'edit_tahun_pelajaran' => 'Tahun Pelajaran',
            'edit_kelas' => 'Kelas',
        ];

        return $mapping[$permissionName] ?? 'Unknown';
    }
}
