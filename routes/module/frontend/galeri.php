<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\ImagesGallery;
use App\Http\Controllers\Frontend\PostinganController;

Route::get('/galeri/video', [PostinganController::class, 'videos'])->name('web.videos');
Route::get('/galeri/foto', [ImagesGallery::class, 'index'])->name('albums.index');
Route::get('/album/{id}', [ImagesGallery::class, 'show'])->name('albums.show');
Route::get('/album/{id}/photos', [ImagesGallery::class, 'photos'])->name('albums.photos');
Route::get('/cari/album', [ImagesGallery::class, 'searchAlbums'])->name('web.cari.albums');

Route::get('/cari/video', [PostinganController::class, 'searchVideos'])->name('web.cari.videos');
Route::get('/galeri/video/detail/{id}/{slug}', [PostinganController::class, 'videosDetail'])->name('web.videos.detail');
