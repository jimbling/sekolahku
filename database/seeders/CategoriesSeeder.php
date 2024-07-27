<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        $categories = [
            [
                'name' => 'Berita',
                'slug' => 'berita',
                'category_type' => 'post',
                'keterangan' => 'berita tentang dunia pendidikan',
            ],
            [
                'name' => 'Informasi',
                'slug' => 'informasi',
                'category_type' => 'post',
                'keterangan' => 'Informasi sekolah',
            ],
            [
                'name' => 'Pengumuman',
                'slug' => 'pengumuman',
                'category_type' => 'post',
                'keterangan' => 'Pengumuman sekolah',
            ],
            [
                'name' => 'Literasi',
                'slug' => 'literasi',
                'category_type' => 'post',
                'keterangan' => 'Berita tentang literasi',
            ],
            [
                'name' => 'Dokumen Sekolah',
                'slug' => 'file',
                'category_type' => 'file',
                'keterangan' => 'Dokumen unduhan',
            ],





        ];


        foreach ($categories as $data) {
            Category::create($data);
        }
    }
}
