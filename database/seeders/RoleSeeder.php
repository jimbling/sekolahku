<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat role utama
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $gtkRole   = Role::firstOrCreate(['name' => 'gtk']);
        $siswaRole = Role::firstOrCreate(['name' => 'siswa']);

        // Assign role ke user jika ada
        if ($user = User::find(1)) {
            $user->assignRole($adminRole);
        }

        if ($user2 = User::find(2)) {
            $user2->assignRole($gtkRole);
        }

        if ($user3 = User::find(3)) {
            $user3->assignRole($siswaRole);
        }
    }
}
