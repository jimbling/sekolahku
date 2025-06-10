<?php

// database/seeders/WidgetSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Widget;

class WidgetSeeder extends Seeder
{
    public function run(): void
    {
        Widget::truncate(); // kosongkan dulu

        Widget::insert([
            [
                'name' => 'artikel_populer',
                'title' => 'Artikel Populer',
                'type' => 'sidebar',
                'is_active' => true,
                'position' => 1,
            ],
            [
                'name' => 'kategori',
                'title' => 'Kategori',
                'type' => 'sidebar',
                'is_active' => true,
                'position' => 2,
            ],
            [
                'name' => 'tautan',
                'title' => 'Tautan',
                'type' => 'sidebar',
                'is_active' => true,
                'position' => 3,
            ],
        ]);
    }
}
