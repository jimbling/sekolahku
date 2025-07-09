<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\WidgetController;

Route::middleware(['permission:edit_widgets'])->group(function () {
    Route::resource('widgets', WidgetController::class)->only(['index', 'update']);
    Route::put('widgets/update-order', [WidgetController::class, 'updateOrder'])->name('widgets.updateOrder');
});
