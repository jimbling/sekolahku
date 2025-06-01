<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\Menu;
use App\Models\ImageSlider;
use App\Models\ImageGallery;

Carbon::setLocale('id');

class HomeController extends Controller
{
    // Fungsi untuk mengambil nilai setting dan mengonversinya menjadi integer
    private function get_setting_int($key, $default = 0)
    {
        $value = get_setting($key, $default);
        return is_numeric($value) ? (int) $value : $default;
    }

    public function index()
    {
        $cacheEnabled = get_setting('site_cache', false);
        $cacheTime = (int) get_setting('site_cache_time', 10);
        $postsPerPage = (int) get_setting('post_per_page', 10);

        $postsCacheKey = 'posts_page_' . request('page', 1);
        if ($cacheEnabled) {
            Cache::forget($postsCacheKey);
        }

        $posts = $cacheEnabled
            ? Cache::remember($postsCacheKey, now()->addMinutes($cacheTime), function () use ($postsPerPage) {
                return Post::where('status', 'Publish')
                    ->where('post_type', 'post')
                    ->orderBy('published_at', 'desc')
                    ->paginate($postsPerPage);
            })
            : Post::where('status', 'Publish')
            ->where('post_type', 'post')
            ->orderBy('published_at', 'desc')
            ->paginate($postsPerPage);

        $sambutanCacheKey = 'sambutan';
        if ($cacheEnabled) {
            Cache::forget($sambutanCacheKey);
        }

        $sambutan = $cacheEnabled
            ? Cache::remember($sambutanCacheKey, now()->addMinutes($cacheTime), function () {
                return Post::where('status', 'Publish')
                    ->where('post_type', 'sambutan')
                    ->first();
            })
            : Post::where('status', 'Publish')
            ->where('post_type', 'sambutan')
            ->first();

        $commentsCacheKey = 'disqus_comments';
        $disqus_key = get_setting('disqus_api_key');
        $disqus_forum = get_setting('shortname_disqus');

        if ($cacheEnabled) {
            Cache::forget($commentsCacheKey);
        }

        $comments = $cacheEnabled
            ? Cache::remember($commentsCacheKey, now()->addMinutes($cacheTime), function () use ($disqus_key, $disqus_forum) {
                return $this->fetchDisqusComments($disqus_key, $disqus_forum);
            })
            : $this->fetchDisqusComments($disqus_key, $disqus_forum);

        $slidersCacheKey = 'sliders';
        $sliders = $cacheEnabled
            ? Cache::remember($slidersCacheKey, now()->addMinutes($cacheTime), function () {
                return ImageSlider::all();
            })
            : ImageSlider::all();

        $galleryImages = ImageGallery::latest()->take(9)->get();

        // Gunakan helper theme_view untuk render view sesuai tema aktif
        return theme_view('homepage', compact('posts', 'sambutan', 'comments', 'sliders', 'galleryImages'));
    }





    public function hubungi_kami()
    {
        $cacheEnabled = get_setting('site_cache', false);
        $cacheTime = (int) get_setting('site_cache_time', 10);

        $categoriesCacheKey = 'categories_with_count';

        if ($cacheEnabled) {
            Cache::forget($categoriesCacheKey);
        }

        $categories = $cacheEnabled
            ? Cache::remember($categoriesCacheKey, now()->addMinutes($cacheTime), function () {
                return Category::withCount('posts')->get();
            })
            : Category::withCount('posts')->get();

        return theme_view('konten.contact_us', compact('categories'));
    }


    private function fetchDisqusComments($disqus_key, $disqus_forum)
    {
        try {
            $response = Http::get('https://disqus.com/api/3.0/posts/list.json', [
                'api_key' => $disqus_key,
                'forum' => $disqus_forum,
                'related' => 'thread',
                'order' => 'desc',
                'limit' => 3,
            ]);

            if ($response->successful()) {
                return $response->json()['response'] ?? [];
            } else {
                // Mengembalikan array kosong jika respons tidak berhasil
                return [];
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            // Menambahkan pesan kesalahan ramah pengguna
            return ['error' => 'Maaf, kami mengalami masalah untuk terhubung ke server komentar. Periksa koneksi internet anda dan coba lagi nanti.'];
        }
    }


    public function menu()
    {

        // Ambil semua menu dari database
        $menus = Menu::with('children')->whereNull('parent_id')->orderBy('order')->get();

        // Return view dengan data menu
        return theme_view('components.frontend.partials.nav', compact('menus'));
        // return view('components.frontend.partials.nav', compact('menus'));
    }

    public function komite()
    {

        $data = [
            'judul' => "Komite Sekolah",
        ];
        return theme_view('konten.komite', $data);
        // return view('web.komite', $data);
    }
}
