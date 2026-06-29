<?php

use App\Http\Controllers\Api\ClientBonusController;
use Illuminate\Support\Facades\Route;

// All routes require an authenticated client token (issued at login)
Route::prefix('client')->middleware('auth:sanctum')->group(function () {

    // ── Bonus levels ──────────────────────────────────────────────────────────
    // GET  /api/client/bonus-levels
    //   → List all active bonus levels with eligibility & pending-request flags
    Route::get('/bonus-levels', [ClientBonusController::class, 'bonusLevels'])
        ->name('api.client.bonus-levels');

    // ── Bonus requests ────────────────────────────────────────────────────────
    // GET    /api/client/bonus-requests        → list my requests
    // POST   /api/client/bonus-requests        → submit a new request
    // GET    /api/client/bonus-requests/{id}   → view a single request
    // DELETE /api/client/bonus-requests/{id}   → cancel a pending request
    Route::get   ('/bonus-requests',       [ClientBonusController::class, 'index']) ->name('api.client.bonus-requests.index');
    Route::post  ('/bonus-requests',       [ClientBonusController::class, 'store']) ->name('api.client.bonus-requests.store');
    Route::get   ('/bonus-requests/{id}',  [ClientBonusController::class, 'show'])  ->name('api.client.bonus-requests.show');
    Route::delete('/bonus-requests/{id}',  [ClientBonusController::class, 'cancel'])->name('api.client.bonus-requests.cancel');
});
