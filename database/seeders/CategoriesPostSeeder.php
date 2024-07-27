<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class CategoriesPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Mendapatkan semua post_id dan category_id yang ada
        $postIds = range(1, 20); // ID post yang ada
        $categoryIds = range(1, 4); // ID kategori yang ada

        $records = [];

        foreach ($postIds as $postId) {
            $categoryId = Arr::random($categoryIds);
            $records[] = [$postId, $categoryId];
        }

        // Insert data ke dalam tabel pivot
        foreach ($records as $record) {
            DB::table('category_post')->insert([
                'post_id' => $record[0],
                'category_id' => $record[1],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
