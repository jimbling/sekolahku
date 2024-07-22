<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Menu utama
        Menu::create([
            'title' => 'Home',
            'url' => route('web.home'),
            'order' => 1,
        ]);

        Menu::create([
            'title' => 'Berita',
            'url' => route('index.berita'),
            'order' => 2,
        ]);

        Menu::create([
            'title' => 'Unduhan',
            'url' => route('web.unduhan'),
            'order' => 3,
        ]);

        Menu::create([
            'title' => 'Hubungi Kami',
            'url' => route('web.hubungi_kami'),
            'order' => 4,
        ]);

        // Menu dropdown "Direktori"
        $direktoriParent = Menu::create([
            'title' => 'Direktori',
            'url' => '#', // URL placeholder, tidak perlu diklik
            'order' => 5,
        ]);

        Menu::create([
            'title' => 'Peserta Didik',
            'url' => route('web.gtk'),
            'parent_id' => $direktoriParent->id,
            'order' => 1,
        ]);

        Menu::create([
            'title' => 'Guru dan Tendik',
            'url' => route('web.gtk'),
            'parent_id' => $direktoriParent->id,
            'order' => 2,
        ]);
    }
}
