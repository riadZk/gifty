<?php

use App\Http\Controllers\Api\ClientRegistrationApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('clients')->group(function () {
    Route::post('/register', [ClientRegistrationApiController::class, 'register'])->name('api.clients.register');
    Route::get('/status',    [ClientRegistrationApiController::class, 'status'])->name('api.clients.status');
});
