<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\SettingController;

Route::middleware(['permission:edit_pengaturan'])->prefix('settings')->group(function () {
    // Pengaturan
    Route::get('/general', [SettingController::class, 'settingUmum'])->name('settings.general');
    Route::get('/school_profile', [SettingController::class, 'settingProfileSekolah'])->name('settings.profile.sekolah');
    Route::get('/reading', [SettingController::class, 'settingMembaca'])->name('settings.reading');
    Route::get('/writing', [SettingController::class, 'settingMenulis'])->name('settings.writing');
    Route::get('/media', [SettingController::class, 'settingMedia'])->name('settings.media');
    Route::get('/medsos', [SettingController::class, 'settingMedsos'])->name('settings.medsos');
    Route::get('/discussion', [SettingController::class, 'settingDiskusi'])->name('settings.discussion');
    Route::get('/{id}/edit', [SettingController::class, 'edit'])->name('settings.general.edit');
    Route::post('/{id}', [SettingController::class, 'update'])->name('settings.general.update');
    Route::post('/upload/foto/{id}', [SettingController::class, 'upload'])->name('upload.foto');
});
