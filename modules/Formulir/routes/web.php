<?php

use Illuminate\Support\Facades\Route;
use Modules\Formulir\Controllers\FormulirFrontendController;

// 🔒 Middleware untuk memastikan modul aktif
Route::middleware(['module.active:Formulir'])->group(function () {

    Route::get('/{form:slug}', [FormulirFrontendController::class, 'showForm']);
    Route::post('/{form:slug}', [FormulirFrontendController::class, 'submitForm']);
    Route::get('/{form:slug}/sukses/{response}', [FormulirFrontendController::class, 'successPage'])->name('form.success');
});

Route::middleware('auth')->get('/admin/formulir/{form}/builder-standalone', function ($formId) {
    $form = \Modules\Formulir\Models\Form::findOrFail($formId);
    return view('formulir.builder_standalone', compact('form'));
});
