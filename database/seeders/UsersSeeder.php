<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat atau mendapatkan roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $writerRole = Role::firstOrCreate(['name' => 'writer']);

        // Membuat atau mendapatkan permissions
        $permissions = [
            'edit_posts',
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
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // Menetapkan semua permissions ke role admin
        $adminRole->givePermissionTo(Permission::all());

        // Menetapkan hanya 'edit_posts' ke role writer
        $writerRole->givePermissionTo('edit_posts');

        // Membuat pengguna dan menetapkan role
        $admin = User::firstOrCreate([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ], [
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole($adminRole);

        $writer = User::firstOrCreate([
            'name' => 'Writer User',
            'email' => 'writer@example.com',
        ], [
            'password' => bcrypt('password'),
        ]);
        $writer->assignRole($writerRole);
    }
}
