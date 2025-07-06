<?php

if (!function_exists('get_page_subtitle')) {
    function get_page_subtitle($title)
    {
        $map = [
            'Indeks Berita' => 'Informasi terbaru seputar kegiatan dan berita sekolah',
            'Galeri Foto' => 'Kumpulan dokumentasi kegiatan dalam bentuk foto',
            'Galeri Video' => 'Kumpulan dokumentasi kegiatan dalam bentuk  video',
            'Direktori Peserta Didik' => 'Daftar Peserta Didik get_setting{school_name}',
            'Direktori GTK' => 'Daftar Pendidik dan Tenaga Kependidikan get_setting{school_name}',
            'Direktori PD Non Aktif' => 'Daftar Peserta Didik Non Aktif dan Alumni get_setting{school_name}',
            'Unduhan' => 'Pusat unduhan file dan dokumen penting dari get_setting{school_name}',
            'Sejarah' => 'Napak tilas perjalanan get_setting{school_name}',
            'Hubungi Kami' => 'Silahkan hubungi kami jika ada pertanyaan atau informasi yang dibutuhkan'
            // Tambah mapping lain sesuai kebutuhan...
        ];

        $default = 'Informasi terbaru dari get_setting{school_name}';

        $subtitle = $map[$title] ?? $default;

        // Replace placeholder get_setting{key} dengan nilai setting dari DB
        $subtitle = preg_replace_callback('/get_setting\{(.*?)\}/', function ($matches) {
            return get_setting($matches[1], '');
        }, $subtitle);

        return $subtitle;
    }
}
