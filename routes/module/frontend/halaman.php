<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckMaintenanceMode;
use App\Http\Controllers\Frontend\HomeController;


Route::middleware([CheckMaintenanceMode::class])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('web.home');
    Route::get('/hubungi-kami', [HomeController::class, 'hubungi_kami'])->name('web.hubungi_kami');
    Route::get('/komite-sekolah', [HomeController::class, 'komite'])->name('web.komite');


    // Route statis khusus tema pradipa
    if (getActiveTheme() === 'pradipa') {
        Route::view('/profil/visi-misi', 'themes.pradipa.konten.profile.visi_misi')->name('profil.visi_misi');
        Route::view('/profil/sejarah', 'themes.pradipa.konten.profile.sejarah')->name('profil.sejarah');
        Route::view('/profil/identitas-sekolah', 'themes.pradipa.konten.profile.identitas')->name('profil.identitas');
        Route::view('/profil/akreditasi-sekolah', 'themes.pradipa.konten.profile.akreditasi_sekolah')->name('profil.akreditasi');
        Route::view('/profil/sarana-prasarana', 'themes.pradipa.konten.profile.sarpras')->name('profil.sarpras');
        Route::view('/profil/spmb', 'themes.pradipa.konten.profile.spmb')->name('profil.spmb');
    }
});
