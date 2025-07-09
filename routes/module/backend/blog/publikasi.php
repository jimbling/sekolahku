<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\QuickLinkController;
use App\Http\Controllers\Backend\UrgentInfoController;
use App\Http\Controllers\Backend\AnnouncementController;

// PUBLIKASI
Route::middleware(['auth', 'verified', 'permission:atur_publikasi'])
    ->prefix('publikasi')
    ->group(function () {

        Route::resource('informasi', UrgentInfoController::class)->except(['show']);
        Route::get('/informasi/data', [UrgentInfoController::class, 'getInformasi'])->name('publikasi.informasi.data');
        Route::get('/informasi/{id}/fetch', [UrgentInfoController::class, 'fetchUrgentInfoById'])->name('publikasi.informasi.fetch');

        Route::resource('pengumuman', AnnouncementController::class)->except(['show']);
        Route::get('/pengumuman/data', [AnnouncementController::class, 'getPengumuman'])->name('publikasi.pengumuman.data');
        Route::get('/pengumuman/{id}/fetch', [AnnouncementController::class, 'fetchAnnouncementById'])->name('publikasi.pengumuman.fetch');

        Route::resource('akses-cepat', QuickLinkController::class)->except(['show']);
        Route::get('/akses-cepat/data', [QuickLinkController::class, 'getAksesCepat'])->name('publikasi.akses.cepat.data');
        Route::get('/akses-cepat/{id}/fetch', [QuickLinkController::class, 'fetchAksesCepatById'])->name('publikasi.akses.cepat.fetch');
    });
