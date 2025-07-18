<?php

use Illuminate\Support\Facades\Route;
use Modules\Ringkas\Controllers\RingkasController;
use Modules\Ringkas\Controllers\RingkasFrontendController;
use Modules\Ringkas\Controllers\RingkasRedirectController;

Route::middleware(['module.active:Ringkas'])->group(function () {
    Route::get('/', [RingkasController::class, 'createPublic'])->name('ringkas.public.index');
    Route::get('/{slug}', [RingkasRedirectController::class, 'redirect']);

    Route::prefix('form')->group(function () {
        Route::post('/buat', [RingkasController::class, 'storePublic'])
            ->middleware('throttle:5,1');
    });
});
