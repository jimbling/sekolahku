<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatternSeeder extends Seeder
{
    public function run()
    {
        DB::table('patterns')->insert([
            [
                'name' => 'Diamond Upholstery',
                'slug' => 'diamond-upholstery',
                'url' => 'http://cdn.backgroundhost.com/backgrounds/subtlepatterns/diamond_upholstery.png',
            ],
            [
                'name' => 'Escheresque',
                'slug' => 'escheresque',
                'url' => 'http://cdn.backgroundhost.com/backgrounds/subtlepatterns/escheresque.png',
            ],
            [
                'name' => 'Tiny Grid',
                'slug' => 'tiny-grid',
                'url' => 'http://cdn.backgroundhost.com/backgrounds/subtlepatterns/tiny_grid.png',
            ],
            [
                'name' => 'Graph Paper',
                'slug' => 'graph-paper',
                'url' => 'http://cdn.backgroundhost.com/backgrounds/subtlepatterns/graphy.png',
            ],
        ]);
    }
}
