<?php

use Illuminate\Support\Facades\Route;
use Modules\Formulir\Controllers\FormulirFrontendController;

// 🔒 Middleware untuk memastikan modul aktif
Route::middleware(['module.active:Formulir'])->group(function () {
    Route::get('/', [FormulirFrontendController::class, 'index'])->name('formulir.public.index');
    Route::get('/{form:slug}', [FormulirFrontendController::class, 'showForm']);
    Route::post('/{form:slug}', [FormulirFrontendController::class, 'submitForm']);
});

Route::middleware('auth')->get('/admin/formulir/{form}/builder-standalone', function ($formId) {
    $form = \Modules\Formulir\Models\Form::findOrFail($formId);
    return view('formulir.builder_standalone', compact('form'));
});
