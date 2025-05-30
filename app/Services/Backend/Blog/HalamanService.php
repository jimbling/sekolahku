<?php

namespace App\Services\Backend\Blog;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class HalamanService
{
    public function getAllPages()
    {
        return Post::where('post_type', 'page')->get();
    }

    public function getPagesDataTable()
    {
        return Post::with('author')
            ->select(['id', 'title', 'author_id', 'published_at', 'status', 'post_type'])
            ->where('post_type', 'page');
    }

    public function store(array $data)
    {
        return Post::create([
            'title' => $data['post_title'],
            'slug' => Str::slug($data['post_title']),
            'content' => $data['post_content'],
            'post_type' => 'page',
            'author_id' => Auth::id(),
            'komentar_status' => $data['post_comment_status'],
            'status' => $data['post_status'],
            'published_at' => $data['post_status'] === 'Publish' ? now() : null,
        ]);
    }

    public function update(Post $post, array $data)
    {
        return $post->update([
            'title' => $data['post_title'],
            'slug' => Str::slug($data['post_title']),
            'content' => $data['post_content'],
            'author_id' => Auth::id(),
            'komentar_status' => $data['post_comment_status'],
            'status' => $data['post_status'],
            'post_type' => 'page',
            'published_at' => $data['post_status'] === 'Publish' ? now() : null,
        ]);
    }
}
