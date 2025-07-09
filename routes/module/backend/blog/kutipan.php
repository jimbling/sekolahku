<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\QuoteController;

// Kutipan
Route::middleware(['permission:edit_kutipan'])->prefix('blog')->group(function () {
    Route::get('/kutipan', [QuoteController::class, 'index'])->name('blog.kutipan');
    Route::get('/kutipan/data', [QuoteController::class, 'getQuote'])->name('kutipan.data');
    Route::post('/kutipan/simpan', [QuoteController::class, 'simpanQuote'])->name('kutipan.tambah');
    Route::delete('/kutipan/{id}', [QuoteController::class, 'destroy'])->name('kutipan.destroy');
    Route::get('/kutipan/{id}/fetch', [QuoteController::class, 'fetchQuoteById'])->name('kutipan.fetch');
    Route::put('/kutipan/{id}/update', [QuoteController::class, 'update'])->name('kutipan.update');
});
