<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\CategoryController;

Route::prefix('blog')
    ->middleware(['permission:edit_categories'])
    ->group(function () {
        Route::post('/new_posts/kategori/simpan', [CategoryController::class, 'simpanNewPosts'])->name('kategori.simpan');
        Route::post('/tambah/kategori/simpan', [CategoryController::class, 'simpanKategori'])->name('kategori.tambah');
        Route::get('/posts/post_categories', [CategoryController::class, 'index'])->name('blog.kategori');
        Route::get('/data-kategori', [CategoryController::class, 'getKategori'])->name('kategori.data');
        Route::delete('/kategori/{id}', [CategoryController::class, 'destroy'])->name('kategori.destroy');
        Route::get('/kategori/{id}/fetch', [CategoryController::class, 'fetchKategoriById'])->name('kategori.fetch');
        Route::put('/kategori/{id}/update', [CategoryController::class, 'update'])->name('kategori.update');
    });
