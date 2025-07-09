<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckMaintenanceMode;
use App\Http\Controllers\Frontend\PostinganController;

Route::middleware([CheckMaintenanceMode::class])->group(function () {
    Route::get('/news', [PostinganController::class, 'index'])->name('news.index');
    Route::get('/read/{id}/{slug}', [PostinganController::class, 'show'])->name('posts.show');
    Route::get('/profil/{slug}', [PostinganController::class, 'showPages'])->name('posts.show.pages');
    Route::get('/pages/{slug}', fn($slug) => redirect("/profil/{$slug}", 301));
    Route::get('/kategori/{slug}', [PostinganController::class, 'showCategoryPosts'])->name('category.posts');
    Route::get('/tags/{slug}', [PostinganController::class, 'showTagsPosts'])->name('tags.posts');
    Route::get('/pencarian', [PostinganController::class, 'search'])->name('search.results');
    Route::get('/berita', [PostinganController::class, 'berita'])->name('index.berita');
});
