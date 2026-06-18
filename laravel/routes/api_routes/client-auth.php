<?php

use App\Http\Controllers\Api\ClientAuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('client')->group(function () {
    Route::post('/login', [ClientAuthController::class, 'login'])->name('api.client.login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [ClientAuthController::class, 'me'])->name('api.client.me');
        Route::post('/logout', [ClientAuthController::class, 'logout'])->name('api.client.logout');
        Route::post('/change-password', [ClientAuthController::class, 'changePassword'])->name('api.client.change-password');
    });
});
