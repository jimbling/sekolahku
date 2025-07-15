<?php

return [
    [
        'title' => 'Dashboard',
        'icon' => 'fas fa-school',
        'url' => '/',
        'pattern' => 'admin',
    ],
    [
        'title' => 'Lihat Situs',
        'icon' => 'far fa-paper-plane',
        'url' => '/',
        'pattern' => '',
        'external' => true,
    ],
    [
        'title' => 'Blog',
        'icon' => 'far fa-newspaper',
        'pattern' => 'admin/blog/*',
        'children' => [
            [
                'title' => 'Semua Tulisan',
                'url' => '/blog/posts',
                'pattern' => 'admin/blog/posts',
                'permission' => 'edit_posts',
            ],
            [
                'title' => 'Tambah Baru',
                'url' => '/blog/posts/create',
                'pattern' => 'admin/blog/posts/create',
                'permission' => 'edit_posts',
            ],
            [
                'title' => 'Kategori Tulisan',
                'url' => '/blog/posts/post_categories',
                'pattern' => 'admin/blog/posts/post_categories',
                'permission' => 'edit_categories',
            ],
            [
                'title' => 'Tags',
                'url' => '/blog/tags',
                'pattern' => 'admin/blog/tags',
                'permission' => 'edit_tags',
            ],
            [
                'title' => 'Gambar Slide',
                'url' => '/blog/gambar_slide',
                'pattern' => 'admin/blog/gambar_slide',
            ],
            [
                'title' => 'Pesan Masuk',
                'url' => '/contact/messages',
                'pattern' => 'admin/contact/messages',
                'permission' => 'edit_hubungi',
            ],
            [
                'title' => 'Tautan',
                'url' => '/blog/tautan',
                'pattern' => 'admin/blog/tautan',
                'permission' => 'edit_tautan',
            ],
            [
                'title' => 'Halaman',
                'url' => '/blog/pages',
                'pattern' => 'admin/log/pages',
                'permission' => 'edit_halaman',
            ],
            [
                'title' => 'Kutipan',
                'url' => '/blog/kutipan',
                'pattern' => 'admin/blog/kutipan',
                'permission' => 'edit_kutipan',
            ],
            [
                'title' => 'Sambutan KS',
                'url' => '/blog/sambutan',
                'pattern' => 'admin/blog/sambutan',
            ],
            [
                'title' => 'Subscriber',
                'url' => '/blog/subscribe',
                'pattern' => 'admin/blog/subscribe',
                'permission' => 'edit_tautan',
            ],
            [
                'title' => 'Komentar',
                'url' => '/blog/komentar',
                'pattern' => 'admin/blog/komentar',
            ],
        ]
    ],
    [
        'title' => 'Publikasi',
        'icon' => 'fas fa-bullhorn',
        'pattern' => 'publikasi/*',
        'permission' => 'atur_publikasi',
        'children' => [
            [
                'title' => 'Informasi',
                'url' => '/publikasi/informasi',
                'pattern' => 'admin/publikasi/informasi',
                'permission' => 'atur_publikasi',
            ],
            [
                'title' => 'Pengumuman',
                'url' => '/publikasi/pengumuman',
                'pattern' => 'admin/publikasi/pengumuman',
                'permission' => 'atur_publikasi',
            ],
            [
                'title' => 'Akses Cepat',
                'url' => '/publikasi/akses-cepat',
                'pattern' => 'admin/publikasi/akses-cepat',
                'permission' => 'atur_publikasi',
            ],
        ],
    ],
    [
        'title' => 'Media',
        'icon' => 'fas fa-server',
        'pattern' => 'files/*|photos/*|videos',
        'permission' => 'edit_pengaturan',

        'children' => [
            [
                'title' => 'File',
                'url' => '/files/all',
                'pattern' => 'admin/files/all',
                'permission' => 'edit_file',
            ],
            [
                'title' => 'Foto',
                'url' => '/photos',
                'pattern' => 'admin/photos/*',
                'permission' => 'edit_photo',
            ],
            [
                'title' => 'Video',
                'url' => '/videos',
                'pattern' => 'admin/videos',
                'permission' => 'edit_video',
            ],
        ],
    ],
    [
        'title' => 'Akademik',
        'icon' => 'fas fa-user-graduate',
        'pattern' => 'gtk*|academic/*',
        'permission' => 'edit_pd',
        'children' => [
            [
                'title' => 'Gtk',
                'url' => '/gtk/all',
                'pattern' => 'admin/gtk/*',
                'permission' => 'edit_gtk',
            ],
            [
                'title' => 'Peserta Didik',
                'url' => '/academic/students/all',
                'pattern' => 'admin/academic/students/all',
                'permission' => 'edit_pd',
            ],
            [
                'title' => 'Kelas',
                'url' => '/academic/classrooms',
                'pattern' => 'admin/academic/classrooms',
                'permission' => 'edit_kelas',
            ],
            [
                'title' => 'Tahun Pelajaran',
                'url' => '/academic/academic_years/all',
                'pattern' => 'admin/academic/academic_years/all',
                'permission' => 'edit_tahun_pelajaran',
            ],
            [
                'title' => 'Rombongan Belajar',
                'url' => '#',
                'pattern' => 'admin/academic/rombels/*',
                'permission' => 'edit_rombel',
                'children' => [
                    [
                        'title' => 'Data Rombel',
                        'url' => '/academic/rombels/create',
                        'pattern' => 'admin/academic/rombels/create',
                    ],
                    [
                        'title' => 'Anggota Rombel',
                        'url' => '/academic/rombels/members',
                        'pattern' => 'admin/academic/rombels/members',
                    ],
                    [
                        'title' => 'Daftar PD Rombel',
                        'url' => '/academic/rombels/all',
                        'pattern' => 'admin/academic/rombels/all',
                    ],
                ],
            ],
            [
                'title' => 'PD Non Aktif',
                'url' => '/academic/students/non-active',
                'pattern' => 'admin/academic/students/non-active',
                'permission' => 'edit_pd',
            ],
        ],
    ],

    [
        'title' => 'Tampilan',
        'icon' => 'fas fa-paint-brush',
        'pattern' => 'menu|tema|widgets',
        'permission' => 'edit_menu',
        'children' => [
            [
                'title' => 'Menu',
                'url' => '/menu',
                'pattern' => 'admin/menu',
            ],
            [
                'title' => 'Tema',
                'url' => '/tema',
                'pattern' => 'admin/tema',
            ],
            [
                'title' => 'Widgets',
                'url' => '/widgets',
                'pattern' => 'admin/widgets',
            ],
        ],
    ],

    [
        'title' => 'Pengguna',
        'icon' => 'fas fa-user-alt',
        'pattern' => 'profile|privilege|admin/users',
        'children' => [
            [
                'title' => 'Profile',
                'url' => '/profile',
                'pattern' => 'admin/profile',
                'permission' => 'edit_profile',
            ],
            [
                'title' => 'Hak Akses',
                'url' => '/privilege',
                'pattern' => 'admin/privilege',
                'permission' => 'edit_hak_akses',
            ],
            [
                'title' => 'Manajemen Pengguna',
                'url' => '/users',
                'pattern' => 'admin/users',
                'permission' => 'atur_pengguna',
            ],
        ],
    ],

    [
        'title' => 'Pengaturan',
        'icon' => 'fas fa-tools',
        'pattern' => 'settings/*',
        'permission' => 'edit_pengaturan',
        'children' => [
            [
                'title' => 'Diskusi',
                'url' => '/settings/discussion',
                'pattern' => 'admin/settings/discussion',
            ],
            [
                'title' => 'Media Sosial',
                'url' => '/settings/medsos',
                'pattern' => 'admin/settings/medsos',
            ],
            [
                'title' => 'Membaca',
                'url' => '/settings/reading',
                'pattern' => 'admin/settings/reading',
            ],
            [
                'title' => 'Menulis',
                'url' => '/settings/writing',
                'pattern' => 'admin/settings/writing',
            ],
            [
                'title' => 'Media',
                'url' => '/settings/media',
                'pattern' => 'admin/settings/media',
            ],
            [
                'title' => 'Profil Sekolah',
                'url' => '/settings/school_profile',
                'pattern' => 'admin/settings/school_profile',
            ],
            [
                'title' => 'Umum',
                'url' => '/settings/general',
                'pattern' => 'admin/settings/general',
            ],
        ],
    ],

    [
        'title' => 'Administrator',
        'icon' => 'fas fa-paint-brush',
        'pattern' => 'admin/patch/update|admin/register-school|pemeliharaan',
        'permission' => 'edit_pemeliharaan',
        'children' => [
            [
                'title' => 'PEMBARUAN',
                'url' => '/patch/update',
                'pattern' => ['admin/patch-update', 'admin/register-school'],
                'icon' => 'fas fa-sync',
            ],
            [
                'title' => 'PEMELIHARAAN',
                'url' => '/pemeliharaan',
                'pattern' => 'admin/pemeliharaan',
                'icon' => 'fas fa-laptop-medical',
            ],
        ],
    ],





];
