<?php

namespace App\Services\Backend\Blog;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SambutanService
{
    public function getSambutan(): Post
    {
        return Post::where('post_type', 'sambutan')->firstOrFail();
    }

    public function updateSambutan(array $data): Post
    {
        $sambutan = $this->getSambutan();

        $sambutan->update([
            'title' => $data['post_title'],
            'slug' => Str::slug($data['post_title']),
            'content' => $data['post_content'],
            'author_id' => Auth::id(),
            'komentar_status' => 'close',
            'status' => 'Publish',
            'post_type' => 'sambutan',
        ]);

        return $sambutan;
    }
}
