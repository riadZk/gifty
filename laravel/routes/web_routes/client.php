<?php

use App\Http\Controllers\Client\ClientController;
use Illuminate\Support\Facades\Route;

// ── Clients (admin panel) ─────────────────────────────────────────────────
Route::prefix('clients')->group(function () {
    Route::get('/',                       [ClientController::class, 'index'])->name('clients');
    Route::get('/{client}',               [ClientController::class, 'show'])->name('clients.show');
    Route::post('/{client}/activate',     [ClientController::class, 'activate'])->name('clients.activate');
    Route::post('/{client}/block',        [ClientController::class, 'block'])->name('clients.block');
    Route::post('/{client}/unblock',      [ClientController::class, 'unblock'])->name('clients.unblock');
});