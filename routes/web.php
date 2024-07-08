<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Frontend\PostinganController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\QuoteController;
use App\Http\Controllers\Backend\LinkController;
use App\Http\Controllers\Backend\ImageController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/news', [PostinganController::class, 'index'])->name('news.index');
Route::get('/read/{id}/{slug}', [PostinganController::class, 'show'])->name('posts.show');
Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile');
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::post('/image/upload', [ImageController::class, 'upload'])->name('image.upload');
    // Post
    Route::get('/blog/posts', [PostController::class, 'index'])->name('blog.posts');
    Route::get('admin/posts/data', [PostController::class, 'getPosts'])->name('admin.posts.data');
    Route::get('/blog/posts/create', [PostController::class, 'create'])->name('admin.posts.create');
    Route::post('/tulisan/simpan', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/blog/posts/{id}', [PostController::class, 'destroy'])->name('admin.posts.destroy');
    Route::delete('/admin/posts/delete-selected', [PostController::class, 'deleteSelected'])->name('admin.posts.deleteSelected');
    Route::post('/blog/posts/update-published/{id}', [PostController::class, 'updatePublishedAt'])
        ->name('admin.posts.updatePublished');
    Route::get('/blog/posts/{id}/content', [PostController::class, 'getPostContent'])
        ->name('admin.posts.content');
    Route::get('/blog/posts/{id}/published_at', [PostController::class, 'getPublishedAt'])->name('blog.posts.published_at');
    Route::get('/blog/posts/create/{id}', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/blog/posts/update/{id}', [PostController::class, 'update'])->name('posts.update');

    // Kategori
    Route::post('/new_posts/kategori/simpan', [CategoryController::class, 'simpanNewPosts'])->name('kategori.simpan');
    Route::post('/tambah/kategori/simpan', [CategoryController::class, 'simpanKategori'])->name('kategori.tambah');
    Route::get('/blog/posts/post_categories', [CategoryController::class, 'index'])->name('blog.kategori');
    Route::get('/kategori/data', [CategoryController::class, 'getKategori'])->name('admin.kategori.data');
    Route::delete('/kategori/{id}', [CategoryController::class, 'destroy'])->name('admin.kategori.destroy');
    Route::get('/kategori/data', [CategoryController::class, 'getKategori'])->name('kategori.data');
    Route::get('/kategori/{id}/fetch', [CategoryController::class, 'fetchKategoriById'])->name('kategori.fetch');
    Route::put('/kategori/{id}/update', [CategoryController::class, 'update'])->name('kategori.update');

    // Tags
    Route::get('/blog/tags', [TagController::class, 'index'])->name('tags.all');
    Route::get('/tag/{slug}', [TagController::class, 'showPostsByTag'])->name('tags.show');
    Route::get('/tags/data', [TagController::class, 'getTags'])->name('tags.data');
    Route::post('/tags/create', [TagController::class, 'simpanTags'])->name('tags.create');
    Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
    Route::get('/tags/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit');
    Route::put('/tags/{tag}', [TagController::class, 'update'])->name('tags.update');
    Route::delete('/tags/{id}', [TagController::class, 'destroy'])->name('tags.destroy');
    Route::post('/tags/delete-selected', [TagController::class, 'deleteSelectedTags'])->name('tags.delete.selected');

    // Sambutan KS
    Route::get('/blog/sambutan', [PostController::class, 'editSambutan'])->name('admin.edit.sambutan');
    Route::post('/blog/sambutan', [PostController::class, 'updateSambutan'])->name('sambutan.update');

    // Kutipan
    Route::get('/blog/kutipan', [QuoteController::class, 'index'])->name('blog.kutipan');
    Route::get('/kutipan/data', [QuoteController::class, 'getQuote'])->name('admin.kutipan.data');
    Route::post('/kutipan/simpan', [QuoteController::class, 'simpanQuote'])->name('kutipan.tambah');
    Route::delete('/kutipan/{id}', [QuoteController::class, 'destroy'])->name('admin.kutipan.destroy');
    Route::get('/kutipan/{id}/fetch', [QuoteController::class, 'fetchQuoteById'])->name('kutipan.fetch');
    Route::put('/kutipan/{id}/update', [QuoteController::class, 'update'])->name('kutipan.update');

    // Tautan
    Route::get('/blog/tautan', [LinkController::class, 'index'])->name('blog.tautan');
    Route::get('/tautan/data', [LinkController::class, 'getTautan'])->name('admin.tautan.data');
    Route::post('/tautan/simpan', [LinkController::class, 'simpanTautan'])->name('tautan.tambah');
    Route::delete('/tautan/{id}', [LinkController::class, 'destroy'])->name('admin.tautan.destroy');
    Route::get('/tautan/{id}/fetch', [LinkController::class, 'fetchTautanById'])->name('tautan.fetch');
    Route::put('/tautan/{id}/update', [LinkController::class, 'update'])->name('tautan.update');

    // Halaman
    Route::get('/blog/pages', [PostController::class, 'pages'])->name('blog.pages');
    Route::get('admin/pages/data', [PostController::class, 'getPages'])->name('admin.pages.data');
    Route::get('/blog/pages/create', [PostController::class, 'pages_create'])->name('admin.pages.create');
    Route::post('/pages/simpan', [PostController::class, 'pages_store'])->name('pages.store');
    Route::get('/blog/pages/{id}/content', [PostController::class, 'getPostContent'])
        ->name('admin.pages.content');
    Route::get('/blog/pages/create/{id}', [PostController::class, 'editPages'])->name('pages.edit');
    Route::put('/blog/pages/update/{id}', [PostController::class, 'updatePages'])->name('pages.update');
    Route::delete('/blog/pages/{id}', [PostController::class, 'destroy'])->name('admin.pages.destroy');
    Route::delete('/admin/pages/delete-selected', [PostController::class, 'deleteSelected'])->name('admin.pages.deleteSelected');
    Route::get('/blog/pages/{id}/published_at', [PostController::class, 'getPublishedAt'])->name('blog.pages.published_at');
    Route::post('/blog/pages/update-published/{id}', [PostController::class, 'updatePublishedAt'])
        ->name('admin.pages.updatePublished');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
