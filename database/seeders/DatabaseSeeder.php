<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat peran 'Administrator' dan 'Penulis Berita'
        $adminRole = Role::create(['name' => 'Administrator']);
        $writerRole = Role::create(['name' => 'Penulis Berita']);

        // Anda juga dapat membuat izin di sini jika diperlukan
        // $permissions = Permission::create(['name' => 'manage articles']);

        // Membuat pengguna Administrator
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // Gunakan bcrypt untuk meng-hash password
        ]);
        // Tetapkan peran 'Administrator' ke pengguna
        $admin->assignRole($adminRole);

        // Membuat pengguna Penulis Berita
        $writer = User::factory()->create([
            'name' => 'Writer User',
            'email' => 'writer@example.com',
            'password' => bcrypt('password'), // Gunakan bcrypt untuk meng-hash password
        ]);
        // Tetapkan peran 'Penulis Berita' ke pengguna
        $writer->assignRole($writerRole);

        // Jika Anda ingin membuat lebih banyak pengguna, gunakan User factory
        // Misalnya, membuat 10 pengguna dengan peran yang ditentukan secara acak
        User::factory(10)->create()->each(function ($user) use ($adminRole, $writerRole) {
            // Tetapkan peran secara acak
            $user->assignRole(rand(0, 1) ? $adminRole : $writerRole);
        });
    }
}
