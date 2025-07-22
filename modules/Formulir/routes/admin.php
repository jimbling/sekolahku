<?php

use Illuminate\Support\Facades\Route;
use Modules\Formulir\Controllers\FormulirController;

// 🔐 Middleware: web, auth, permission, dan modul aktif
Route::middleware(['web', 'auth', 'permission:atur_formulir', 'module.active:Formulir'])
  ->group(function () {
    Route::get('/', [FormulirController::class, 'index'])->name('formulir.index');
    Route::get('create', [FormulirController::class, 'create'])->name('formulir.create');
    Route::post('store', [FormulirController::class, 'store'])->name('formulir.store');
    Route::get('{uuid}/edit', [FormulirController::class, 'edit'])->name('formulir.edit');
    Route::put('{id}', [FormulirController::class, 'update'])->name('formulir.update');
    Route::delete('{id}', [FormulirController::class, 'destroy'])->name('formulir.destroy');
    Route::get('d/{uuid}/edit', [FormulirController::class, 'builder'])->name('formulir.builder');
    Route::post('/{form}/questions', [FormulirController::class, 'storeQuestions'])->name('formulir.questions');
    Route::post('/{form}/header', [FormulirController::class, 'updateHeader'])->name('formulir.updateHeader');
    Route::delete('/{form}/header', [FormulirController::class, 'deleteHeader'])->name('formulir.deleteHeader');

    Route::get('/{form:slug}/preview', [FormulirController::class, 'preview'])->name('formulir.preview');
    Route::post('/{form}/publish', [FormulirController::class, 'publish']);
    Route::post('/{id}/unpublish', [FormulirController::class, 'unpublish'])->name('admin.formulir.unpublish');
  });
