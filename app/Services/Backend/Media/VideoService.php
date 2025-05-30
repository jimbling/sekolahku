<?php
// app/Services/Backend/Video/VideoService.php
namespace App\Services\Backend\Media;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class VideoService
{
    public function getAllVideos()
    {
        return Post::where('post_type', 'video')->get();
    }

    public function getVideosForDatatables()
    {
        return Post::select('id', 'title', 'content', 'post_type', 'created_at', 'updated_at')
            ->where('post_type', 'video');
    }

    public function storeVideo(array $data)
    {
        $slug = Str::slug($data['post_title'], '-');

        return Post::create([
            'title' => $data['post_title'],
            'slug' => $slug,
            'content' => $data['post_content'],
            'post_type' => 'video',
            'author_id' => Auth::id(),
            'komentar_status' => 'close',
            'status' => 'Publish',
            'published_at' => now(),
        ]);
    }

    public function updateVideo(Post $video, array $data)
    {
        $slug = Str::slug($data['post_title'], '-');

        $video->title = $data['post_title'];
        $video->slug = $slug;
        $video->content = $data['post_content'];
        $video->post_type = 'video';
        $video->author_id = Auth::id();
        $video->komentar_status = 'close';
        $video->status = 'Publish';
        $video->published_at = now();
        $video->save();

        return $video;
    }

    public function deleteVideo(Post $video)
    {
        $video->delete();
    }

    public function deleteMultipleVideos(array $ids)
    {
        Post::whereIn('id', $ids)->delete();
    }

    public function formatVideoContent($content)
    {
        if (strpos($content, 'https://www.youtube.com/watch?v=') === 0) {
            $videoId = parse_url($content, PHP_URL_QUERY);
            parse_str($videoId, $query);
            $videoId = $query['v'] ?? '';

            return '<a href="' . $content . '" target="_blank" class="text-blue-500 hover:underline">Tonton Video</a>';
        }

        return $content;
    }
}
