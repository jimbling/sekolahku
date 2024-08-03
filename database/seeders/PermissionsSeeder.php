<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $permissions = [
            'edit_categories',
            'edit_tags',
            'edit_kutipan',
            'edit_tautan',
            'edit_halaman',
            'edit_hubungi',
            'edit_pengaturan',
            'edit_gtk',
            'edit_file',
            'edit_video',
            'edit_menu',
            'edit_rombel',
            'edit_pd',
            'edit_tahun_pelajaran',
            'edit_kelas',
            'edit_profile',
            'edit_hak_akses',
            'edit_pemeliharaan',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}
