<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\ImageController;
use App\Http\Controllers\Backend\DashboardController;

// Tambahan rute khusus
Route::get('/disqus-comments', [DashboardController::class, 'disqusComments'])->name('disqus.comments');

// Blog group
Route::prefix('blog')->group(function () {

    // Image Upload
    Route::post('/image/upload', [ImageController::class, 'upload'])->name('image.upload');

    // Posts group
    Route::prefix('posts')->group(function () {

        Route::get('/', [PostController::class, 'index'])->name('blog.posts');
        Route::get('/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('/store', [PostController::class, 'store'])->name('posts.store');
        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/{id}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

        Route::post('/delete_selected', [PostController::class, 'deleteSelected'])->name('posts.deleteSelected');
        Route::post('/update-published/{id}', [PostController::class, 'updatePublishedAt'])->name('posts.updatePublished');
        Route::get('/{id}/content', [PostController::class, 'getPostContent'])->name('posts.content');
        Route::get('/{id}/published_at', [PostController::class, 'getPublishedAt'])->name('posts.published_at');
        Route::delete('/remove-image/{id}', [PostController::class, 'removeImage'])->name('posts.removeImage');
    });

    // Post data endpoint
    Route::get('admin/posts/data', [PostController::class, 'getPosts'])->name('posts.data');
});
