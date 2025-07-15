<?php

use Illuminate\Support\Facades\Route;
use Modules\Ringkas\Controllers\RingkasFrontendController;
use Modules\Ringkas\Controllers\RingkasRedirectController;

Route::middleware(['module.active:Ringkas'])->group(function () {
    Route::get('/', [RingkasFrontendController::class, 'index'])->name('ringkas.public.index');
    Route::get('/{slug}', [RingkasRedirectController::class, 'redirect']);
});
