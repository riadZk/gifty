<?php

use App\Http\Controllers\BonusRequestController;
use Illuminate\Support\Facades\Route;

Route::prefix('demandes')->group(function () {
    Route::get('/',                               [BonusRequestController::class, 'index'])  ->name('demandes.index');
    Route::get('/create',                         [BonusRequestController::class, 'create']) ->name('demandes.create');
    Route::post('/',                              [BonusRequestController::class, 'store'])  ->name('demandes.store');
    Route::get('/{bonusRequest}',                 [BonusRequestController::class, 'show'])   ->name('demandes.show');
    Route::post('/{bonusRequest}/approve',        [BonusRequestController::class, 'approve'])->name('demandes.approve');
    Route::post('/{bonusRequest}/reject',         [BonusRequestController::class, 'reject']) ->name('demandes.reject');
    Route::post('/{bonusRequest}/deliver',        [BonusRequestController::class, 'deliver'])->name('demandes.deliver');
});
