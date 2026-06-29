<?php

use App\Http\Controllers\MessagingController;
use Illuminate\Support\Facades\Route;

// ── Messaging (admin → clients) ──────────────────────────────────────────────
Route::prefix('messaging')->group(function () {
    Route::get('/',        [MessagingController::class, 'index'])->name('messaging.index');
    Route::get('/history', [MessagingController::class, 'history'])->name('messaging.history');
    Route::post('/send',   [MessagingController::class, 'send'])->name('messaging.send');
});
