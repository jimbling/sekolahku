<?php

// app/Services/PostService.php
namespace App\Services\Backend\Blog;

use DOMDocument;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use App\Models\Subscriber;
use Illuminate\Support\Str;
use App\Mail\NewPostNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public function getAllPosts()
    {
        return Post::all();
    }

    public function getPostsForDatatables()
    {
        return Post::with('author')
            ->select(['id', 'title', 'author_id', 'published_at', 'status', 'post_type'])
            ->where('post_type', 'post')
            ->orderBy('published_at', 'desc');
    }

    public function createPost(array $data)
    {
        $imageName = $this->processImage($data['post_title'], $data['post_image'] ?? null);
        $slug = Str::slug($data['post_title']);
        $content = $this->processContent($data['post_content'], $data['post_title']);

        $post = Post::create([
            'title' => $data['post_title'],
            'slug' => $slug,
            'content' => $content,
            'excerpt' => substr(strip_tags($data['post_content']), 0, 150) . '...',
            'image' => $imageName,
            'post_type' => 'post',
            'author_id' => auth()->id(),
            'komentar_status' => $data['post_comment_status'],
            'status' => $data['post_status'],
            'published_at' => $data['post_status'] == 'Publish' ? now() : null,
        ]);

        $this->attachCategories($post, $data['post_categories']);
        $this->attachTags($post, $data['post_tags'] ?? []);

        $this->notifySubscribers($post);
        // Jalankan queue worker sekali, supaya email langsung dikirim
        $this->runQueueWorker();
        return $post;
    }

    private function runQueueWorker()
    {
        Artisan::call('queue:work --stop-when-empty');
    }


    protected function processImage($title, $imageFile)
    {
        if (!$imageFile) return null;

        $slug = Str::slug($title);
        $imageName = $slug . '-' . time() . '.webp';
        $imageResource = imagecreatefromstring(file_get_contents($imageFile->getPathname()));
        $imagePath = storage_path('app/public/uploads/posts/' . $imageName);
        imagewebp($imageResource, $imagePath, 80);
        imagedestroy($imageResource);

        return $imageName;
    }

    protected function processContent($content, $title)
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();

        $images = $dom->getElementsByTagName('img');
        foreach ($images as $img) {
            if (!$img->hasAttribute('alt') || $img->getAttribute('alt') === '') {
                $img->setAttribute('alt', $title);
            }
            if (!$img->hasAttribute('title') || $img->getAttribute('title') === '') {
                $img->setAttribute('title', $title);
            }
        }

        $body = $dom->getElementsByTagName('body')->item(0);
        $newContent = '';
        foreach ($body->childNodes as $child) {
            $newContent .= $dom->saveHTML($child);
        }

        return $newContent;
    }

    protected function attachCategories($post, $categories)
    {
        $post->category()->attach($categories);
    }

    protected function attachTags($post, $tags)
    {
        if (empty($tags)) return;

        $tagIds = [];
        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(
                ['name' => $tagName],
                ['slug' => Str::slug($tagName, '-')]
            );
            $tagIds[] = $tag->id;
        }

        $post->tags()->attach($tagIds);
    }

    public function notifySubscribers(Post $post)
    {
        if ($post->status !== 'Publish') {
            return;
        }

        $subscribers = Subscriber::all();
        $postLink = route('posts.show', ['id' => $post->id, 'slug' => $post->slug]);

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->queue(new NewPostNotification(
                $post->title,
                $postLink,
                $post->excerpt,
                $post->published_at ? $post->published_at->format('Y-m-d H:i:s') : 'Not published',
                $post->image ? asset('storage/uploads/posts/' . $post->image) : null
            ));
        }
    }

    // Tambahkan method-method berikut ke PostService
    public function findPostWithRelations($id)
    {
        return Post::with(['category', 'tags'])->findOrFail($id);
    }

    public function deletePost($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return $post;
    }

    public function deleteMultiplePosts(array $ids)
    {
        return Post::whereIn('id', $ids)->delete();
    }

    public function updatePublishedAt($id, $publishedAt)
    {
        $post = Post::findOrFail($id);
        $post->update(['published_at' => $publishedAt]);
        return $post;
    }

    public function getPostContent($id)
    {
        return Post::findOrFail($id)->content;
    }

    public function getFormattedPublishedAt($id)
    {
        $post = Post::findOrFail($id);
        return $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : null;
    }

    public function getAllCategories()
    {
        return Category::all();
    }

    public function getPostTags($post)
    {
        return $post->tags->pluck('name')->toArray();
    }

    public function updatePost($id, array $data)
    {
        $post = Post::findOrFail($id);
        $slug = Str::slug($data['post_title']);

        // Handle image upload
        $imageName = $this->handleImageUpdate(
            $post->image,
            $data['post_title'],
            $data['post_image'] ?? null
        );

        // Process content
        $content = $this->processContent($data['post_content'], $data['post_title']);

        // Update post
        $post->update([
            'title' => $data['post_title'],
            'slug' => $slug,
            'content' => $content,
            'excerpt' => substr(strip_tags($data['post_content']), 0, 150),
            'image' => $imageName,
            'komentar_status' => $data['post_comment_status'],
            'status' => $data['post_status'],
            'published_at' => $data['post_status'] === 'Publish' ? now() : null,
        ]);

        // Sync categories and tags
        $this->syncCategories($post, $data['post_categories']);
        $this->syncTags($post, $data['post_tags'] ?? []);

        // Notify subscribers if status changed to publish
        if ($post->wasChanged('status') && $post->status === 'Publish') {
            $this->notifySubscribers($post);
        }

        return $post;
    }

    protected function handleImageUpdate($currentImage, $title, $newImage)
    {
        if (!$newImage) {
            return $currentImage;
        }

        $slug = Str::slug($title);
        $imageName = $slug . '-' . time() . '.webp';

        // Convert and save new image
        $imageResource = imagecreatefromstring(file_get_contents($newImage->getPathname()));
        $imagePath = storage_path('app/public/uploads/posts/' . $imageName);
        imagewebp($imageResource, $imagePath, 80);
        imagedestroy($imageResource);

        // Delete old image if exists
        if ($currentImage) {
            Storage::disk('public')->delete('uploads/posts/' . $currentImage);
        }

        return $imageName;
    }

    protected function syncCategories($post, $categories)
    {
        $post->category()->sync($categories);
    }

    protected function syncTags($post, $tags)
    {
        $tagIds = [];

        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(
                ['name' => $tagName],
                ['slug' => Str::slug($tagName)]
            );
            $tagIds[] = $tag->id;
        }

        $post->tags()->sync($tagIds);
    }
}
