<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\ImageSlidersController;

// Gambar Slide
Route::middleware(['permission:edit_slider'])->prefix('blog/gambar_slide')->group(function () {
    Route::get('/', [ImageSlidersController::class, 'index'])->name('sliders.index');
    Route::get('/data', [ImageSlidersController::class, 'getSlider'])->name('sliders.data');
    Route::post('/simpan', [ImageSlidersController::class, 'simpanSliders'])->name('sliders.tambah');
    Route::delete('/{id}', [ImageSlidersController::class, 'destroy'])->name('sliders.destroy');
    Route::get('/{id}/fetch', [ImageSlidersController::class, 'fetchSliderById'])->name('sliders.fetch');
    Route::put('/{id}/update', [ImageSlidersController::class, 'update'])->name('sliders.update');
});
