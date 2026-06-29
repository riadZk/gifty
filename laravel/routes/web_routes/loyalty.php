<?php

use App\Http\Controllers\Loyalty\LoyaltyController;
use Illuminate\Support\Facades\Route;

Route::prefix('loyalty')->name('loyalty.')->group(function () {
    Route::get('/',                           [LoyaltyController::class, 'index'])->name('index');
    Route::put('/settings',                   [LoyaltyController::class, 'updateSettings'])->name('settings.update');
    Route::post('/levels',                    [LoyaltyController::class, 'storeLevel'])->name('levels.store');
    Route::put('/levels/{level}',             [LoyaltyController::class, 'updateLevel'])->name('levels.update');
    Route::delete('/levels/{level}',          [LoyaltyController::class, 'destroyLevel'])->name('levels.destroy');
});
