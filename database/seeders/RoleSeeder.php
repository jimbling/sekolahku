<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Membuat peran 'admin'
        $adminRole = Role::create(['name' => 'admin']);

        // Membuat peran 'writer'
        $writerRole = Role::create(['name' => 'writer']);

        // Contoh menetapkan peran ke pengguna
        $user = User::find(1);
        if ($user) {
            $user->assignRole('admin'); // Atau $user->assignRole($adminRole);
        }

        $user2 = User::find(2);
        if ($user2) {
            $user2->assignRole('writer'); // Atau $user2->assignRole($writerRole);
        }
    }
}
