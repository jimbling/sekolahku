<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'Publish')->latest()->paginate(10);

        return view('web.home', compact('posts'));
    }
}
