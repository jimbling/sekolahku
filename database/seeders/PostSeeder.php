<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Hapus semua data sebelum menambahkan data baru
        DB::table('posts')->truncate();

        // Gunakan Faker untuk menghasilkan data acak
        $faker = Faker::create();

        // Loop untuk menambahkan beberapa data contoh
        for ($i = 0; $i < 50; $i++) {
            $title = $faker->sentence;
            $status = $faker->randomElement(['Publish', 'Draft']); // Status acak

            DB::table('posts')->insert([
                'title' => $title,
                'slug' => Str::slug($title),
                'content' => $faker->paragraph,
                'excerpt' => $faker->sentence,
                'image' => 'image' . rand(1, 3) . '.jpg',
                'category_id' => '1', // ID kategori random antara 1-5
                'author_id' => rand(1, 3), // ID penulis random antara 1-3
                'published_at' => $status == 'Publish' ? $faker->dateTimeThisMonth() : null,
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
