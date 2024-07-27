<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Data yang akan dimasukkan ke dalam tabel menus
        $menus = [
            [
                'id' => 1,
                'title' => 'Home',
                'url' => '/',
                'icon' => null,
                'parent_id' => null,
                'order' => 0,
                'is_active' => 1,
                'menu_target' => '_self',
                'created_at' => '2024-07-16 04:35:45',
                'updated_at' => '2024-07-16 15:25:29',
            ],
            [
                'id' => 2,
                'title' => 'Berita',
                'url' => '/berita',
                'icon' => null,
                'parent_id' => null,
                'order' => 2,
                'is_active' => 1,
                'menu_target' => '_self',
                'created_at' => '2024-07-16 04:35:45',
                'updated_at' => '2024-07-25 10:17:25',
            ],
            [
                'id' => 3,
                'title' => 'Unduhan',
                'url' => '/unduhan',
                'icon' => null,
                'parent_id' => null,
                'order' => 5,
                'is_active' => 1,
                'menu_target' => '_self',
                'created_at' => '2024-07-16 04:35:45',
                'updated_at' => '2024-07-25 10:16:51',
            ],
            [
                'id' => 4,
                'title' => 'Hubungi Kami',
                'url' => '/hubungi-kami',
                'icon' => null,
                'parent_id' => null,
                'order' => 6,
                'is_active' => 1,
                'menu_target' => '_self',
                'created_at' => '2024-07-16 04:35:45',
                'updated_at' => '2024-07-25 10:16:51',
            ],
            [
                'id' => 5,
                'title' => 'Direktori',
                'url' => '#',
                'icon' => null,
                'parent_id' => null,
                'order' => 3,
                'is_active' => 1,
                'menu_target' => '_self',
                'created_at' => '2024-07-16 04:35:45',
                'updated_at' => '2024-07-25 10:17:25',
            ],
            [
                'id' => 6,
                'title' => 'Peserta Didik',
                'url' => '/peserta-didik',
                'icon' => null,
                'parent_id' => 5,
                'order' => 0,
                'is_active' => 1,
                'menu_target' => '_self',
                'created_at' => '2024-07-16 04:35:45',
                'updated_at' => '2024-07-21 01:58:38',
            ],
            [
                'id' => 7,
                'title' => 'Guru dan Tendik',
                'url' => '/guru-tendik',
                'icon' => null,
                'parent_id' => 5,
                'order' => 1,
                'is_active' => 1,
                'menu_target' => '_self',
                'created_at' => '2024-07-16 04:35:45',
                'updated_at' => '2024-07-17 05:12:12',
            ],
            [
                'id' => 24,
                'title' => 'PD Non Aktif',
                'url' => '/pd-non-aktif',
                'icon' => null,
                'parent_id' => 5,
                'order' => 2,
                'is_active' => 1,
                'menu_target' => '_self',
                'created_at' => '2024-07-21 13:21:25',
                'updated_at' => '2024-07-21 13:22:41',
            ],
            [
                'id' => 25,
                'title' => 'Profil',
                'url' => '/#',
                'icon' => null,
                'parent_id' => null,
                'order' => 1,
                'is_active' => 1,
                'menu_target' => '_self',
                'created_at' => '2024-07-22 08:09:02',
                'updated_at' => '2024-07-25 10:17:25',
            ],
            [
                'id' => 26,
                'title' => 'Tentang Kami',
                'url' => '/pages/tentang-kami',
                'icon' => null,
                'parent_id' => 25,
                'order' => 0,
                'is_active' => 1,
                'menu_target' => '_self',
                'created_at' => '2024-07-22 08:09:19',
                'updated_at' => '2024-07-22 08:09:30',
            ],
            [
                'id' => 28,
                'title' => 'Galeri',
                'url' => '/#',
                'icon' => null,
                'parent_id' => null,
                'order' => 4,
                'is_active' => 1,
                'menu_target' => '_self',
                'created_at' => '2024-07-25 10:10:20',
                'updated_at' => '2024-07-25 10:17:25',
            ],
            [
                'id' => 30,
                'title' => 'Foto',
                'url' => '/galeri/foto',
                'icon' => null,
                'parent_id' => 28,
                'order' => 0,
                'is_active' => 1,
                'menu_target' => '_self',
                'created_at' => '2024-07-25 10:16:22',
                'updated_at' => '2024-07-25 10:16:51',
            ],
            [
                'id' => 31,
                'title' => 'Video',
                'url' => '/galeri/video',
                'icon' => null,
                'parent_id' => 28,
                'order' => 1,
                'is_active' => 1,
                'menu_target' => '_self',
                'created_at' => '2024-07-25 10:16:41',
                'updated_at' => '2024-07-25 10:16:51',
            ],
        ];

        // Insert data ke dalam tabel menus menggunakan model Menu
        foreach ($menus as $menu) {
            Menu::updateOrCreate(
                ['id' => $menu['id']], // Mencocokkan berdasarkan ID untuk update
                $menu
            );
        }
    }
}
