<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\ImageGallerysController;
// Media - Foto
Route::middleware(['permission:edit_photo'])->prefix('photos')->group(function () {
    // Album Foto
    Route::get('/', [ImageGallerysController::class, 'index'])->name('photos.all');
    Route::get('/albums/data', [ImageGallerysController::class, 'getAlbums'])->name('albums.data');
    Route::post('/albums/create', [ImageGallerysController::class, 'albums_store'])->name('albums.store');
    Route::delete('/albums/{id}', [ImageGallerysController::class, 'destroy'])->name('albums.destroy');
    Route::post('/albums/delete-selected', [ImageGallerysController::class, 'deleteSelectedAlbums'])->name('albums.delete.selected');
    Route::get('/albums/{id}/fetch', [ImageGallerysController::class, 'fetchAlbumsById'])->name('albums.fetch');
    Route::put('/albums/{id}/update', [ImageGallerysController::class, 'update'])->name('albums.update');
    Route::get('/albums/{id}/upload', [ImageGallerysController::class, 'showUploadForm'])->name('albums.upload');
    Route::post('/albums/{id}/upload', [ImageGallerysController::class, 'storeImage'])->name('albums.upload.store');
    Route::get('/albums/{id}/atur', [ImageGallerysController::class, 'aturFoto'])->name('albums.foto');
    Route::delete('/images/{id}', [ImageGallerysController::class, 'hapusFoto'])->name('images.hapus');
});
