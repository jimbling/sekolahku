<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SitemapController extends Controller
{
    public function generateSitemap()
    {
        $urls = [
            // Menambahkan URL statis jika ada
            ['loc' => url('/'), 'lastmod' => now()->toAtomString(), 'priority' => '1.00'],
            ['loc' => url('/hubungi-kami'), 'lastmod' => now()->toAtomString(), 'priority' => '0.80'],
            ['loc' => url('/news'), 'lastmod' => now()->toAtomString(), 'priority' => '0.80'],
            ['loc' => url('/berita'), 'lastmod' => now()->toAtomString(), 'priority' => '0.80'],
            ['loc' => url('/galeri/video'), 'lastmod' => now()->toAtomString(), 'priority' => '0.80'],
            ['loc' => url('/galeri/foto'), 'lastmod' => now()->toAtomString(), 'priority' => '0.80'],
            ['loc' => url('/cari/album'), 'lastmod' => now()->toAtomString(), 'priority' => '0.80'],
            ['loc' => url('/cari/video'), 'lastmod' => now()->toAtomString(), 'priority' => '0.80'],
            ['loc' => url('/unduhan'), 'lastmod' => now()->toAtomString(), 'priority' => '0.80'],
            ['loc' => url('/menu'), 'lastmod' => now()->toAtomString(), 'priority' => '0.80'],
            ['loc' => url('/komite-sekolah'), 'lastmod' => now()->toAtomString(), 'priority' => '0.80'],


        ];

        // Ambil URL dari tabel posts
        $posts = DB::table('posts')->select('id', 'slug', 'updated_at')->get();
        foreach ($posts as $post) {
            $updatedAt = Carbon::parse($post->updated_at); // Konversi string ke Carbon
            $urls[] = [
                'loc' => url('/read/' . $post->id . '/' . $post->slug),
                'lastmod' => $updatedAt->toAtomString(), // Format datetime menjadi string Atom
                'priority' => '0.64'
            ];
        }

        // Ambil URL dari tabel posts dengan post_type 'video'
        $videos = DB::table('posts')
            ->where('post_type', 'video') // Tambahkan kondisi ini
            ->select('id', 'slug', 'updated_at')
            ->get();

        foreach ($videos as $video) {
            $updatedAt = Carbon::parse($video->updated_at); // Konversi string ke Carbon
            $urls[] = [
                'loc' => url('/galeri/video/detail/' . $video->id . '/' . $video->slug),
                'lastmod' => $updatedAt->toAtomString(), // Format datetime menjadi string Atom
                'priority' => '0.64'
            ];
        }

        // Dari post_type = pages
        $pages = DB::table('posts')
            ->where('post_type', 'pages')
            ->select('slug', 'updated_at')
            ->get();

        foreach ($pages as $page) {
            $urls[] = [
                'loc' => url('/profil/' . $page->slug),
                'lastmod' => Carbon::parse($page->updated_at)->toAtomString(),
                'priority' => '0.72'
            ];
        }

        // Tambahan statis manual (jika tidak di DB)
        $staticPages = ['visi-misi', 'sejarah', 'sarana-prasarana', 'identitas-sekolah', 'akreditasi-sekolah', 'spmb'];
        foreach ($staticPages as $slug) {
            $urls[] = [
                'loc' => url('/profil/' . $slug),
                'lastmod' => now()->toAtomString(),
                'priority' => '0.70'
            ];
        }





        // Ambil URL dari tabel categories
        $categories = DB::table('categories')->select('slug', 'updated_at')->get();
        foreach ($categories as $category) {
            $updatedAt = Carbon::parse($category->updated_at); // Konversi string ke Carbon
            $urls[] = [
                'loc' => url('/kategori/' . $category->slug),
                'lastmod' => $updatedAt->toAtomString(), // Format datetime menjadi string Atom
                'priority' => '0.64'
            ];
        }

        // Ambil URL dari tabel tags
        $tags = DB::table('tags')->select('slug', 'updated_at')->get();
        foreach ($tags as $tag) {
            $updatedAt = Carbon::parse($tag->updated_at); // Konversi string ke Carbon
            $urls[] = [
                'loc' => url('/tags/' . $tag->slug),
                'lastmod' => $updatedAt->toAtomString(), // Format datetime menjadi string Atom
                'priority' => '0.64'
            ];
        }

        // Menghasilkan XML sitemap
        $xml = $this->generateSitemapXml($urls);

        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }

    private function generateSitemapXml(array $urls): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($urls as $url) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($url['loc']) . '</loc>';
            $xml .= '<lastmod>' . htmlspecialchars($url['lastmod']) . '</lastmod>';
            if (isset($url['changefreq'])) {
                $xml .= '<changefreq>' . htmlspecialchars($url['changefreq']) . '</changefreq>';
            }
            if (isset($url['priority'])) {
                $xml .= '<priority>' . htmlspecialchars($url['priority']) . '</priority>';
            }
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return $xml;
    }
}
