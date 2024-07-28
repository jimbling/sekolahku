<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        $titles = [
            'Inovasi dalam Pembelajaran Digital untuk Siswa',
            'Manfaat Pendidikan Karakter di Sekolah Dasar',
            'Tren Pendidikan Global di Era Teknologi',
            'Cara Meningkatkan Keterlibatan Orang Tua dalam Pendidikan',
            'Pentingnya Program Beasiswa untuk Pendidikan Tinggi',
            'Mengatasi Tantangan Pendidikan di Daerah Terpencil',
            'Peran Pendidikan dalam Mempersiapkan Siswa untuk Dunia Kerja',
            'Kebijakan Pendidikan Baru yang Mempengaruhi Kurikulum',
            'Strategi Pembelajaran yang Efektif untuk Anak Berkebutuhan Khusus',
            'Pengaruh Pendidikan STEM terhadap Karir di Masa Depan',
            'Mendukung Kesejahteraan Mental Siswa melalui Program Sekolah',
            'Perubahan Kurikulum dan Dampaknya terhadap Kualitas Pendidikan',
            'Cara Mengimplementasikan Pembelajaran Berbasis Proyek di Kelas',
            'Pentingnya Pelatihan Berkelanjutan untuk Guru',
            'Teknologi Baru dan Dampaknya terhadap Metode Pengajaran',
            'Pengembangan Kompetensi Sosial dan Emosional di Sekolah',
            'Meningkatkan Aksesibilitas Pendidikan untuk Siswa dengan Disabilitas',
            'Penggunaan Media Sosial sebagai Alat Pembelajaran',
            'Inovasi dalam Metode Evaluasi dan Penilaian Pendidikan',
            'Strategi Peningkatan Kualitas Pendidikan di Sekolah Menengah',
        ];

        // Data baru yang sudah ditentukan
        $newPost = [
            'title' => 'Sambutan Kepala Sekolah',
            'slug' => 'sambutan-kepala-sekolah',
            'content' => "<p>Assalamu'alaikum Wr. Wb.</p>
            <p>Assalamualaikum warahmatullahi wabarakatuh,</p><p>Selamat pagi dan salam sejahtera bagi kita semua,</p><p>Dengan penuh rasa syukur dan bangga, saya menyambut dengan hangat peluncuran website resmi SD Negeri 63 Kedungrejo. Hari ini adalah momen bersejarah bagi keluarga besar SD Negeri 63 Kedungrejo, di mana kita melangkah lebih jauh dalam dunia teknologi dan informasi dengan hadirnya situs web ini.</p><p>Website ini merupakan wujud komitmen kami untuk meningkatkan kualitas layanan pendidikan dan komunikasi dengan seluruh stakeholder, termasuk siswa, orang tua, dan masyarakat. Dengan tampilan yang modern dan informasi yang terintegrasi, kami berharap website ini dapat menjadi sumber informasi yang akurat dan bermanfaat, serta mempermudah akses terhadap berbagai kegiatan dan perkembangan di sekolah.</p><p>Kami ingin mengucapkan terima kasih kepada seluruh pihak yang telah berkontribusi dalam pengembangan website ini. Terima kasih kepada tim pengembang, staf, dan semua pihak yang telah bekerja keras untuk mewujudkan situs ini. Semoga website ini dapat memperkuat hubungan kita, mempermudah komunikasi, dan menjadi sarana yang efektif dalam mendukung proses belajar mengajar di SD Negeri 63 Kedungrejo.</p><p>Dengan peluncuran website ini, kami juga berharap dapat memberikan pengalaman yang lebih baik bagi para siswa dan orang tua dalam mengakses informasi mengenai kegiatan sekolah, jadwal pelajaran, pengumuman penting, dan berbagai informasi lainnya. Mari kita manfaatkan fasilitas ini sebaik-baiknya untuk mencapai tujuan pendidikan yang lebih baik dan lebih maju.</p><p>Sekian sambutan dari saya. Semoga website ini dapat menjadi jembatan yang menghubungkan kita semua dalam upaya bersama untuk mencerdaskan generasi penerus bangsa.</p><p>Wassalamualaikum warahmatullahi wabarakatuh.</p><p>Kepala Sekolah SD Negeri 63 Kedungrejo</p><p>Wassalamu'alaikum Wr. Wb.as</p>",
            'post_type' => 'sambutan',
        ];

        // Insert data baru
        DB::table('posts')->insert([
            'title' => $newPost['title'],
            'slug' => $newPost['slug'],
            'content' => $newPost['content'],
            'excerpt' => $faker->sentence,
            'author_id' => '1',
            'published_at' => now(),
            'status' => 'Publish',
            'post_type' => $newPost['post_type'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert data posts lainnya secara acak
        for ($i = 0; $i < 18; $i++) { // Kurangi 1 karena kita sudah menambahkan 1 data di atas
            $title = $faker->unique()->randomElement($titles);
            $status = $faker->randomElement(['Publish', 'Draft']);

            DB::table('posts')->insert([
                'title' => $title,
                'slug' => Str::slug($title) . '-' . $faker->unique()->numberBetween(1, 10000),
                'content' => $faker->paragraph,
                'excerpt' => $faker->sentence,
                'author_id' => '1',
                'published_at' => $status == 'Publish' ? $faker->dateTimeThisMonth() : null,
                'status' => $status,
                'post_type' => 'post',
                'image' => $faker->randomElement($this->getImages()), // Menambahkan gambar
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Post Tentang Kami
        $tentangKami = [
            'title' => 'Tentang Kami',
            'slug' => 'tentang-kami',
            'content' => "<p>CMS untuk membuat website sekolah.</p>",
            'post_type' => 'page',

        ];

        DB::table('posts')->insert([
            'title' => $tentangKami['title'],
            'slug' => $tentangKami['slug'],
            'content' => $tentangKami['content'],
            'excerpt' => null,
            'author_id' => '1',
            'published_at' => now(),
            'status' => 'Publish',
            'post_type' => $tentangKami['post_type'],
            'image' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Data video baru
        $postVideo1 = [
            'title' => 'MT School SSD SDN Kedungrejo Kapanewon Pengasih',
            'content' => 'eN-Op7Mn2I4',
            'post_type' => 'video',
        ];

        // Membuat slug dari title
        $postVideo1['slug'] = Str::slug($postVideo1['title']);

        // Insert video ke database
        DB::table('posts')->insert([
            'title' => $postVideo1['title'],
            'slug' => $postVideo1['slug'],
            'content' => $postVideo1['content'], // Menyimpan ID video
            'excerpt' => null,
            'author_id' => '1',
            'published_at' => now(),
            'status' => 'Publish',
            'post_type' => $postVideo1['post_type'],
            'image' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        // Data video baru
        $postVideo2 = [
            'title' => 'Kuali Merah Putih 11. JANGANKAN EMAS, AIR PUN KAMI TIDAK ADA! SUKU TIMOR, NTT',
            'content' => 'rosTeoC3tBs',
            'post_type' => 'video',
        ];

        // Membuat slug dari title
        $postVideo2['slug'] = Str::slug($postVideo2['title']);

        // Insert video ke database
        DB::table('posts')->insert([
            'title' => $postVideo2['title'],
            'slug' => $postVideo2['slug'],
            'content' => $postVideo2['content'], // Menyimpan ID video
            'excerpt' => null,
            'author_id' => '1',
            'published_at' => now(),
            'status' => 'Publish',
            'post_type' => $postVideo2['post_type'],
            'image' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Data video baru
        $postVideo3 = [
            'title' => 'KISARASA | S3 - Episode 6 - Pesona Hidangan Sego Khas Kota Pahlawan',
            'content' => 'MWuBnN_qjo8',
            'post_type' => 'video',
        ];

        // Membuat slug dari title
        $postVideo3['slug'] = Str::slug($postVideo3['title']);

        // Insert video ke database
        DB::table('posts')->insert([
            'title' => $postVideo3['title'],
            'slug' => $postVideo3['slug'],
            'content' => $postVideo3['content'], // Menyimpan ID video
            'excerpt' => null,
            'author_id' => '1',
            'published_at' => now(),
            'status' => 'Publish',
            'post_type' => $postVideo3['post_type'],
            'image' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Mendapatkan array nama gambar
     *
     * @return array
     */
    private function getImages()
    {
        return [
            'images-1.jpg',
            'images-2.jpg',
            'images-3.jpg',
            'images-4.jpg',
            'images-5.jpg',
            'images-6.jpg',
        ];
    }
}
