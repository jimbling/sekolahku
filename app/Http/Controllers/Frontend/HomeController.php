<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

Carbon::setLocale('id');

class HomeController extends Controller
{
    public function index()
    {
        // Ambil nilai post_per_page dari pengaturan
        $postsPerPage = get_setting('post_per_page', 10); // Defaultnya adalah 10 jika tidak ada setting yang tersedia

        // Ambil data posting dari database dengan paginasi
        $posts = Post::where('status', 'Publish')
            ->where('post_type', 'post')
            ->latest()
            ->paginate($postsPerPage);

        // Ambil data sambutan dari database
        $sambutan = Post::where('status', 'Publish')
            ->where('post_type', 'sambutan')
            ->first(); // Mengambil satu data saja

        // Ambil data komentar terbaru dari Disqus
        $comments = [];
        $response = Http::get('https://disqus.com/api/3.0/posts/list.json', [
            'api_key' => 'idPFu8dAb5xne3ypYhivPsn0m4yIWD2n1YaL1LAVZQLDYaXtwz4yxiNSdMSsmekt',
            'forum' => 'sdnkedungrejo-sch-id', // Pastikan forum shortname benar
            'related' => 'thread', // Sertakan informasi thread
            'order' => 'desc',
            'limit' => 3, // Jumlah komentar yang ingin ditampilkan
        ]);

        if ($response->successful()) {
            $comments = $response->json()['response'] ?? [];
        } else {
            // Debugging: Tampilkan respons jika gagal
            Log::error('Disqus API Error: ' . $response->body());
        }

        return view('web.homepage', compact('posts', 'sambutan', 'comments'));
    }

    public function hubungi_kami()
    {

        return view('web.contact_us');
    }
}
