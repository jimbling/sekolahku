<?php

namespace App\Helpers;

class PermissionHelper
{
    public static function getUserFriendlyName($permissionName)
    {
        $mapping = ['edit_posts' => 'Postingan',
            'edit_categories' => 'Kategori',
            'edit_tags' => 'Tag',
            'edit_kutipan' => 'Kutipan',
            'edit_tautan' => 'Tautan',
            'edit_halaman' => 'Halaman',
            'edit_hubungi' => 'Hubungi Kami',
            'edit_pengaturan' => 'Pengaturan',
            'edit_gtk' => 'GTK',
            'edit_file' => 'File',
            'edit_video' => 'Media Video',
            'edit_menu' => 'Menu',
            'edit_rombel' => 'Rombel',
            'edit_pd' => 'Peserta Didik',
            'edit_tahun_pelajaran' => 'Tahun Pelajaran',
            'edit_kelas' => 'Kelas',
            'edit_profile' => 'Profile',
            'edit_hak_akses' => 'Hak Akses',
            'edit_pemeliharaan' => 'Pemeliharaan Sistem',
            'edit_slider' => 'Gambar Slide',
            'edit_photo' => 'Media Foto',
            'edit_komentar' => 'Komentar',
            'edit_widgets' => 'Widgets',
            'edit_tema' => 'Tema',
            'atur_publikasi' => 'Atur Publikasi',
            'atur_pengguna' => 'Manajemen Pengguna',
            'atur_modul' => 'Atur Modul'
    ];

        return $mapping[$permissionName] ?? 'Unknown';
    }
}
