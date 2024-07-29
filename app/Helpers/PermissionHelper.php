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
            'edit_hubungi' => 'Hubungi Kami',
            'edit_pengaturan' => 'Pengaturan',
            'edit_gtk' => 'GTK',
            'edit_file' => 'File',
            'edit_video' => 'Video',
            'edit_menu' => 'Menu',
            'edit_rombel' => 'Rombel',
            'edit_pd' => 'Peserta Didik',
            'edit_tahun_pelajaran' => 'Tahun Pelajaran',
            'edit_kelas' => 'Kelas',
            'edit_profile' => 'Profile',
            'edit_hak_akses' => 'Hak Akses',
        ];

        return $mapping[$permissionName] ?? 'Unknown';
    }
}
