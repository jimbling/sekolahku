<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;


class PostinganController extends Controller
{
    public function index()
    {
        // Ambil data posting dari database dengan paginasi
        $posts = Post::paginate(6); // Sesuaikan jumlah per halaman sesuai kebutuhan
        return view('web.home', compact('posts'));
    }

    public function show($id, $slug)
    {
        $post = Post::where('id', $id)
            ->where('slug', $slug)
            ->firstOrFail();

        return view('news-detail', compact('post'));
    }
}
