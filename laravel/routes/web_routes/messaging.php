<?php

use App\Http\Controllers\MessagingController;
use Illuminate\Support\Facades\Route;

// ── Messaging (admin → clients) ──────────────────────────────────────────────
Route::prefix('messaging')->group(function () {
    Route::get('/',        [MessagingController::class, 'index'])->name('messaging.index');
    Route::get('/history', [MessagingController::class, 'history'])->name('messaging.history');
    Route::post('/send',   [MessagingController::class, 'send'])->name('messaging.send');

    Route::get('/{message}/detail',  [MessagingController::class, 'show'])->whereNumber('message')->name('messaging.show');
    Route::post('/{message}/resend', [MessagingController::class, 'resend'])->whereNumber('message')->name('messaging.resend');
});
