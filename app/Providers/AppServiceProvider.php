<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Link;
use App\Models\Menu;
use App\Models\Post;
use App\Models\Widget;
use App\Models\Message;
use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\ServiceProvider;
use App\Models\Setting; // Ganti dengan model yang sesuai jika diperlukan


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Menampilkan tahun
        view()->composer('*', function ($view) {
            $view->with('currentYear', Carbon::now()->year);
        });

        // Ambil pengaturan school_name untuk digunakan di title halaman
        View::composer('*', function ($view) {
            $schoolName = Cache::remember('setting:school_name', now()->addHours(1), function () {
                return Setting::where('key', 'school_name')->value('setting_value') ?? 'Default Title';
            });

            $view->with('schoolName', $schoolName);
        });


        // Menampilkan Notifikasi pesan masuk Hubungi Kami
        view()->composer('*', function ($view) {
            $unreadMessagesCount = Message::where('is_read', false)->count();
            $unreadMessages = Message::where('is_read', false)->orderBy('created_at', 'desc')->take(5)->get();
            $view->with(compact('unreadMessagesCount', 'unreadMessages'));
        });

        // Menampilkan postingan populer
        view()->composer('*', function ($view) {
            $popularArticles = Post::where('status', 'Publish')
                ->where('post_type', 'post')
                ->where('post_counter', '>', 0) // Menambahkan kondisi untuk post_counter
                ->orderBy('post_counter', 'desc')
                ->limit(4)
                ->get();

            $view->with('popularArticles', $popularArticles);
        });

        // Mengambil kategori beserta jumlah postingan dan membagikannya ke semua view
        view()->composer('*', function ($view) {
            // Mendapatkan kategori dengan jumlah postingan dan filter berdasarkan category_type
            $categories = Category::withCount(['posts' => function ($query) {
                $query->where('post_type', 'post'); // Filter berdasarkan post_type
            }])
                ->where('category_type', 'post') // Filter berdasarkan category_type
                ->get();

            // Array warna latar belakang
            $colors = [
                'bg-green-100',
                'bg-red-100',
                'bg-purple-100',
                'bg-orange-100',
                'bg-yellow-100',
                'bg-blue-100',
                'bg-teal-100',
                'bg-pink-100',
            ];

            // Mengacak warna
            $shuffledColors = Arr::shuffle($colors);

            // Menetapkan warna ke kategori
            $categories->each(function ($category, $index) use ($shuffledColors) {
                $category->colorClass = $shuffledColors[$index % count($shuffledColors)];
            });

            // Menyediakan data kategori dan warna ke tampilan
            $view->with('categories', $categories);
        });

        // Menyediakan data menu
        View::composer('*', function ($view) {
            // Ambil menu yang tidak memiliki parent (parent menu) dan aktif
            $parentMenus = Menu::whereNull('parent_id')
                ->where('is_active', true)
                ->orderBy('order')
                ->get();

            // Ambil semua menu anak yang aktif
            $allMenus = Menu::whereNotNull('parent_id')
                ->where('is_active', true)
                ->get()
                ->groupBy('parent_id');

            // Bagikan ke semua view
            $view->with('parentMenus', $parentMenus);
            $view->with('allMenus', $allMenus);
        });

        // Mengatur locale ke Bahasa Indonesia
        Carbon::setLocale('id');



        // Daftarkan middleware role
        $this->app['router']->aliasMiddleware('role', RoleMiddleware::class);

        View::composer('themes.*.components.frontend.partials.nav', function ($view) {
            $menus = Menu::with('children')
                ->whereNull('parent_id')
                ->where('is_active', true)
                ->orderBy('order')
                ->get();

            $view->with('menus', $menus);
        });

        View::composer('*', function ($view) {
            $tautan = Link::getAllLink();
            $view->with('tautan', $tautan);
        });

        // Kirim data widgets ke sidebar
        View::composer('themes.*.components.frontend.partials.sidebar', function ($view) {
            $widgets = Widget::where('is_active', true)->orderBy('position')->get();
            $view->with('widgets', $widgets);
        });
    }
}
