<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;


class PostinganController extends Controller
{
    private function get_setting_int($key, $default = 0)
    {
        $value = get_setting($key, $default);
        return is_numeric($value) ? (int) $value : $default;
    }
    public function index()
    {
        $cacheEnabled = get_setting('site_cache', false);
        $cacheTime = $this->get_setting_int('site_cache_time', 10);
        $postsCacheKey = 'posts_page_' . request('page', 1);

        if ($cacheEnabled) {
            Cache::forget($postsCacheKey);
        }

        $posts = $cacheEnabled
            ? Cache::remember($postsCacheKey, now()->addMinutes($cacheTime), function () {
                return Post::paginate(1);
            })
            : Post::paginate(1);

        return view('web.home', compact('posts'));
    }

    public function show($id, $slug)
    {
        $cacheEnabled = get_setting('site_cache', false);
        $cacheTime = $this->get_setting_int('site_cache_time', 10);
        $postCacheKey = "post_{$id}_{$slug}";

        // Ambil data post dari cache atau database
        if ($cacheEnabled) {
            $post = Cache::remember($postCacheKey, now()->addMinutes($cacheTime), function () use ($id, $slug) {
                return Post::where('id', $id)
                    ->where('slug', $slug)
                    ->with('tags', 'category') // Memuat relasi tags dan category
                    ->first();
            });
        } else {
            $post = Post::where('id', $id)
                ->where('slug', $slug)
                ->with('tags', 'category') // Memuat relasi tags dan category
                ->first();
        }

        // Jika post tidak ditemukan atau status bukan Publish, arahkan ke halaman khusus
        if (!$post || $post->status !== 'Publish') {
            return view('errors.404'); // Ganti dengan tampilan Blade yang sesuai
        }

        // Increment post_counter jika tidak menggunakan cache
        if (!$cacheEnabled) {
            $post->increment('post_counter');
        } else {
            // Jika menggunakan cache, increment post_counter secara terpisah
            Post::where('id', $id)
                ->where('slug', $slug)
                ->increment('post_counter');
        }

        // Mendapatkan ID kategori post yang sedang ditampilkan
        $categories = $post->category->pluck('id');

        // Mencari post lain dengan kategori yang sama
        $relatedPosts = Post::whereHas('category', function ($query) use ($categories) {
            $query->whereIn('categories.id', $categories);
        })
            ->where('posts.id', '!=', $id)
            ->where('posts.post_type', 'post') // Filter berdasarkan post_type
            ->where('posts.status', 'Publish') // Filter berdasarkan status
            ->limit(get_setting('post_related_count'))
            ->get();

        return view('web.post.post_detail', [
            'post' => $post,
            'tags' => $post->tags,
            'categories' => $post->category,
            'relatedPosts' => $relatedPosts
        ]);
    }






    public function showPages($slug)
    {
        $cacheEnabled = get_setting('site_cache', false);
        $cacheTime = $this->get_setting_int('site_cache_time', 10);
        $postCacheKey = "page_{$slug}";

        if ($cacheEnabled) {
            Cache::forget($postCacheKey);
        }

        $post = $cacheEnabled
            ? Cache::remember($postCacheKey, now()->addMinutes($cacheTime), function () use ($slug) {
                $post = Post::where('slug', $slug)
                    ->where('post_type', 'page')
                    ->firstOrFail();
                $post->increment('post_counter');
                return $post;
            })
            : Post::where('slug', $slug)
            ->where('post_type', 'page')
            ->firstOrFail();

        if (!$cacheEnabled) {
            $post->increment('post_counter');
        }

        return view('web.post.post_detail', compact('post'));
    }

    public function showCategoryPosts($slug)
    {
        $cacheEnabled = get_setting('site_cache', false);
        $cacheTime = $this->get_setting_int('site_cache_time', 10);
        $categoryCacheKey = "category_posts_{$slug}";

        if ($cacheEnabled) {
            Cache::forget($categoryCacheKey);
        }

        $category = $cacheEnabled
            ? Cache::remember($categoryCacheKey, now()->addMinutes($cacheTime), function () use ($slug) {
                return Category::where('slug', $slug)
                    ->with(['posts' => function ($query) {
                        $query->where('post_type', 'post')
                            ->where('status', 'Publish'); // Filter berdasarkan post_type dan status
                    }])
                    ->firstOrFail();
            })
            : Category::where('slug', $slug)
            ->with(['posts' => function ($query) {
                $query->where('post_type', 'post')
                    ->where('status', 'Publish'); // Filter berdasarkan post_type dan status
            }])
            ->firstOrFail();

        return view('web.post.post_kategori', [
            'category' => $category,
            'posts' => $category->posts
        ]);
    }



    public function showTagsPosts($slug)
    {
        $cacheEnabled = get_setting('site_cache', false);
        $cacheTime = $this->get_setting_int('site_cache_time', 10);
        $tagsCacheKey = "tags_posts_{$slug}";

        if ($cacheEnabled) {
            Cache::forget($tagsCacheKey);
        }

        $tags = $cacheEnabled
            ? Cache::remember($tagsCacheKey, now()->addMinutes($cacheTime), function () use ($slug) {
                return Tag::where('slug', $slug)
                    ->with(['posts' => function ($query) {
                        $query->where('post_type', 'post')
                            ->where('status', 'Publish'); // Filter berdasarkan post_type dan status
                    }])
                    ->firstOrFail();
            })
            : Tag::where('slug', $slug)
            ->with(['posts' => function ($query) {
                $query->where('post_type', 'post')
                    ->where('status', 'Publish'); // Filter berdasarkan post_type dan status
            }])
            ->firstOrFail();

        return view('web.post.post_tags', [
            'category' => $tags,
            'posts' => $tags->posts
        ]);
    }


    public function search(Request $request)
    {
        $cacheEnabled = get_setting('site_cache', false);
        $cacheTime = $this->get_setting_int('site_cache_time', 10);
        $searchQuery = $request->input('keywords');
        $searchCacheKey = "search_results_{$searchQuery}_page_" . request('page', 1);

        if ($cacheEnabled) {
            Cache::forget($searchCacheKey);
        }

        $posts = $cacheEnabled
            ? Cache::remember($searchCacheKey, now()->addMinutes($cacheTime), function () use ($searchQuery) {
                return Post::where('post_type', 'post')
                    ->where(function ($query) use ($searchQuery) {
                        $query->where('title', 'like', "%{$searchQuery}%")
                            ->orWhere('content', 'like', "%{$searchQuery}%");
                    })
                    ->paginate(10);
            })
            : Post::where('post_type', 'post')
            ->where(function ($query) use ($searchQuery) {
                $query->where('title', 'like', "%{$searchQuery}%")
                    ->orWhere('content', 'like', "%{$searchQuery}%");
            })
            ->paginate(10);

        return view('web.post.post_pencarian', [
            'posts' => $posts,
            'searchQuery' => $searchQuery
        ]);
    }

    public function berita()
    {
        $cacheEnabled = get_setting('site_cache', false);
        $postsPerPage = $this->get_setting_int('post_per_page', 10);
        $cacheTime = $this->get_setting_int('site_cache_time', 10);
        $beritaCacheKey = "berita_page_" . request('page', 1);

        if ($cacheEnabled) {
            Cache::forget($beritaCacheKey);
        }

        $posts = $cacheEnabled
            ? Cache::remember($beritaCacheKey, now()->addMinutes($cacheTime), function () use ($postsPerPage) {
                return Post::where('status', 'Publish')
                    ->where('post_type', 'post')
                    ->orderBy('published_at', 'desc')
                    ->paginate($postsPerPage);
            })
            : Post::where('status', 'Publish')
            ->where('post_type', 'post')
            ->orderBy('published_at', 'desc')
            ->paginate($postsPerPage);

        return view('web.berita', compact('posts'));
    }

    public function videos()
    {
        $cacheEnabled = get_setting('site_cache', false);
        $postsPerPage = $this->get_setting_int('post_per_page', 9);
        $cacheTime = $this->get_setting_int('site_cache_time', 10);
        $videosCacheKey = "videos_page_" . request('page', 1);

        if ($cacheEnabled) {
            Cache::forget($videosCacheKey);
        }

        $posts = $cacheEnabled
            ? Cache::remember($videosCacheKey, now()->addMinutes($cacheTime), function () use ($postsPerPage) {
                return Post::where('status', 'Publish')
                    ->where('post_type', 'video')
                    ->orderBy('published_at', 'desc')
                    ->paginate($postsPerPage);
            })
            : Post::where('status', 'Publish')
            ->where('post_type', 'video')
            ->orderBy('published_at', 'desc')
            ->paginate($postsPerPage);

        return view('web.galeri_video', compact('posts'));
    }

    public function searchVideos(Request $request)
    {
        $keywords = $request->input('keywords');

        $posts = Post::where('post_type', 'video')
            ->where(function ($query) use ($keywords) {
                $query->where('title', 'like', '%' . $keywords . '%');
            })
            ->paginate(5);

        $data = [
            'judul' => "Hasil Pencarian Video: " . $keywords,
            'posts' => $posts,
        ];

        return view('web.galeri_video', $data);
    }

    public function videosDetail($id, $slug)
    {
        $cacheEnabled = get_setting('site_cache', false);
        $cacheTime = $this->get_setting_int('site_cache_time', 10);
        $postCacheKey = "post_{$id}_{$slug}";

        // Ambil data post dari cache atau database
        if ($cacheEnabled) {
            $post = Cache::remember($postCacheKey, now()->addMinutes($cacheTime), function () use ($id, $slug) {
                return Post::where('id', $id)
                    ->where('slug', $slug)
                    ->where('post_type', 'video') // Membatasi hanya post dengan post_type 'video'
                    ->with('tags', 'category') // Memuat relasi tags dan category
                    ->firstOrFail();
            });
        } else {
            $post = Post::where('id', $id)
                ->where('slug', $slug)
                ->where('post_type', 'video') // Membatasi hanya post dengan post_type 'video'
                ->with('tags', 'category') // Memuat relasi tags dan category
                ->firstOrFail();
        }

        // Increment post_counter jika tidak menggunakan cache
        if (!$cacheEnabled) {
            $post->increment('post_counter');
        } else {
            // Jika menggunakan cache, increment post_counter secara terpisah
            Post::where('id', $id)
                ->where('slug', $slug)
                ->increment('post_counter');
        }

        // Mendapatkan semua post dengan post_type = 'video'
        $relatedPosts = Post::where('post_type', 'video')
            ->where('id', '!=', $id)
            ->limit('6')
            ->get();

        return view('web.post.post_video_detail', [
            'post' => $post,
            'tags' => $post->tags,
            'categories' => $post->category,
            'relatedPosts' => $relatedPosts
        ]);
    }
}
