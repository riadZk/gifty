<?php

use App\Http\Controllers\Config\ConfigController;
use Illuminate\Support\Facades\Route;

Route::prefix('config')->name('config.')->group(function () {
    Route::get('/',              [ConfigController::class, 'profile'])->name('profile');
    Route::post('/profile',      [ConfigController::class, 'updateProfile'])->name('profile.update');
    Route::get('/points-rules',  [ConfigController::class, 'pointsRules'])->name('points-rules');
    Route::get('/bonus-levels',  [ConfigController::class, 'bonusLevels'])->name('bonus-levels');
});
