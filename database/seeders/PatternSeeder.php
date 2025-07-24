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
                'name' => 'Grey Floral',
                'slug' => 'grey-floral',
                'url' => 'http://cdn.backgroundhost.com/backgrounds/subtlepatterns/greyfloral.png',
            ],
            [
                'name' => 'GPlay Pattern',
                'slug' => 'gplay-pattern',
                'url' => 'http://cdn.backgroundhost.com/backgrounds/subtlepatterns/gplaypattern.png',
            ],
            [
                'name' => 'XV',
                'slug' => 'xv',
                'url' => 'http://cdn.backgroundhost.com/backgrounds/subtlepatterns/xv.png',
            ],
            [
                'name' => 'Plaid',
                'slug' => 'plaid',
                'url' => 'http://cdn.backgroundhost.com/backgrounds/subtlepatterns/plaid.png',
            ],
            [
                'name' => 'Always Grey',
                'slug' => 'always-grey',
                'url' => 'http://cdn.backgroundhost.com/backgrounds/subtlepatterns/always_grey.png',
            ],
            [
                'name' => 'Flowers',
                'slug' => 'flowers',
                'url' => 'http://cdn.backgroundhost.com/backgrounds/subtlepatterns/flowers.png',
            ],
            [
                'name' => 'Cartographer',
                'slug' => 'cartographer',
                'url' => 'http://cdn.backgroundhost.com/backgrounds/subtlepatterns/cartographer.png',
            ],
        ]);
    }
}
