<?php

return [
    [
        'title' => 'Dashboard',
        'icon' => 'fas fa-school',
        'url' => '/dashboard',
        'pattern' => 'dashboard',
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
        'pattern' => 'blog/*',
        'children' => [
            [
                'title' => 'Semua Tulisan',
                'url' => '/blog/posts',
                'pattern' => 'blog/posts',
                'permission' => 'edit_posts',
            ],
            [
                'title' => 'Tambah Baru',
                'url' => '/blog/posts/create',
                'pattern' => 'blog/posts/create',
                'permission' => 'edit_posts',
            ],
            [
                'title' => 'Kategori Tulisan',
                'url' => '/blog/posts/post_categories',
                'pattern' => 'blog/posts/post_categories',
                'permission' => 'edit_categories',
            ],
            [
                'title' => 'Tags',
                'url' => '/blog/tags',
                'pattern' => 'blog/tags',
                'permission' => 'edit_tags',
            ],
            [
                'title' => 'Gambar Slide',
                'url' => '/blog/gambar_slide',
                'pattern' => 'blog/gambar_slide',
            ],
            [
                'title' => 'Pesan Masuk',
                'url' => '/contact/messages',
                'pattern' => 'contact/messages',
                'permission' => 'edit_hubungi',
            ],
            [
                'title' => 'Tautan',
                'url' => '/blog/tautan',
                'pattern' => 'blog/tautan',
                'permission' => 'edit_tautan',
            ],
            [
                'title' => 'Halaman',
                'url' => '/blog/pages',
                'pattern' => 'blog/pages',
                'permission' => 'edit_halaman',
            ],
            [
                'title' => 'Kutipan',
                'url' => '/blog/kutipan',
                'pattern' => 'blog/kutipan',
                'permission' => 'edit_kutipan',
            ],
            [
                'title' => 'Sambutan KS',
                'url' => '/blog/sambutan',
                'pattern' => 'blog/sambutan',
            ],
            [
                'title' => 'Subscriber',
                'url' => '/blog/subscribe',
                'pattern' => 'blog/subscribe',
                'permission' => 'edit_tautan',
            ],
            [
                'title' => 'Komentar',
                'url' => '/blog/komentar',
                'pattern' => 'blog/komentar',
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
                'pattern' => 'publikasi/informasi',
                'permission' => 'atur_publikasi',
            ],
            [
                'title' => 'Pengumuman',
                'url' => '/publikasi/pengumuman',
                'pattern' => 'publikasi/pengumuman',
                'permission' => 'atur_publikasi',
            ],
            [
                'title' => 'Akses Cepat',
                'url' => '/publikasi/akses-cepat',
                'pattern' => 'publikasi/akses-cepat',
                'permission' => 'atur_publikasi',
            ],
        ],
    ],
    [
        'title' => 'Media',
        'icon' => 'fas fa-server',
        'pattern' => 'files/*|photos/*|videos',
        'children' => [
            [
                'title' => 'File',
                'url' => '/files/all',
                'pattern' => 'files/all',
                'permission' => 'edit_file',
            ],
            [
                'title' => 'Foto',
                'url' => '/photos',
                'pattern' => 'photos/*',
                'permission' => 'edit_photo',
            ],
            [
                'title' => 'Video',
                'url' => '/videos',
                'pattern' => 'videos',
                'permission' => 'edit_video',
            ],
        ],
    ],
    [
        'title' => 'Akademik',
        'icon' => 'fas fa-user-graduate',
        'pattern' => 'gtk*|academic/*',
        'children' => [
            [
                'title' => 'Gtk',
                'url' => '/gtk/all',
                'pattern' => 'gtk/*',
                'permission' => 'edit_gtk',
            ],
            [
                'title' => 'Peserta Didik',
                'url' => '/academic/students/all',
                'pattern' => 'academic/students/all',
                'permission' => 'edit_pd',
            ],
            [
                'title' => 'Kelas',
                'url' => '/academic/classrooms',
                'pattern' => 'academic/classrooms',
                'permission' => 'edit_kelas',
            ],
            [
                'title' => 'Tahun Pelajaran',
                'url' => '/academic/academic_years/all',
                'pattern' => 'academic/academic_years/all',
                'permission' => 'edit_tahun_pelajaran',
            ],
            [
                'title' => 'Rombongan Belajar',
                'url' => '#',
                'pattern' => 'academic/rombels/*',
                'permission' => 'edit_rombel',
                'children' => [
                    [
                        'title' => 'Data Rombel',
                        'url' => '/academic/rombels/create',
                        'pattern' => 'academic/rombels/create',
                    ],
                    [
                        'title' => 'Anggota Rombel',
                        'url' => '/academic/rombels/members',
                        'pattern' => 'academic/rombels/members',
                    ],
                    [
                        'title' => 'Daftar PD Rombel',
                        'url' => '/academic/rombels/all',
                        'pattern' => 'academic/rombels/all',
                    ],
                ],
            ],
            [
                'title' => 'PD Non Aktif',
                'url' => '/academic/students/non-active',
                'pattern' => 'academic/students/non-active',
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
                'pattern' => 'menu',
            ],
            [
                'title' => 'Tema',
                'url' => '/tema',
                'pattern' => 'tema',
            ],
            [
                'title' => 'Widgets',
                'url' => '/widgets',
                'pattern' => 'widgets',
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
                'pattern' => 'profile',
                'permission' => 'edit_profile',
            ],
            [
                'title' => 'Hak Akses',
                'url' => '/privilege',
                'pattern' => 'privilege',
                'permission' => 'edit_hak_akses',
            ],
            [
                'title' => 'Manajemen Pengguna',
                'url' => '/admin/users',
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
                'pattern' => 'settings/discussion',
            ],
            [
                'title' => 'Media Sosial',
                'url' => '/settings/medsos',
                'pattern' => 'settings/medsos',
            ],
            [
                'title' => 'Membaca',
                'url' => '/settings/reading',
                'pattern' => 'settings/reading',
            ],
            [
                'title' => 'Menulis',
                'url' => '/settings/writing',
                'pattern' => 'settings/writing',
            ],
            [
                'title' => 'Media',
                'url' => '/settings/media',
                'pattern' => 'settings/media',
            ],
            [
                'title' => 'Profil Sekolah',
                'url' => '/settings/school_profile',
                'pattern' => 'settings/school_profile',
            ],
            [
                'title' => 'Umum',
                'url' => '/settings/general',
                'pattern' => 'settings/general',
            ],
        ],
    ],

    [
        'title' => 'Administrator',
        'icon' => 'fas fa-paint-brush',
        'pattern' => 'admin/patch-update|admin/register-school|pemeliharaan',
        'permission' => 'edit_pemeliharaan',
        'children' => [
            [
                'title' => 'PEMBARUAN',
                'url' => '/admin/patch-update',
                'pattern' => ['admin/patch-update', 'admin/register-school'],
                'icon' => 'fas fa-sync',
            ],
            [
                'title' => 'PEMELIHARAAN',
                'url' => '/pemeliharaan',
                'pattern' => 'pemeliharaan',
                'icon' => 'fas fa-laptop-medical',
            ],
        ],
    ],





];
