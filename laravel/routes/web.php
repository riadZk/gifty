<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// ── Locale switcher (public, no auth required) ──
Route::post('/locale/{locale}', function (string $locale) {
    $supported = ['en', 'fr', 'ar'];
    if (in_array($locale, $supported)) {
        Session::put('locale', $locale);
    }
    return back();
})->name('locale.switch');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    require __DIR__ . '/web_routes/dashboard.php';
    require __DIR__ . '/web_routes/client.php';
    require __DIR__ . '/web_routes/loyalty.php';
    require __DIR__ . '/web_routes/demandes.php';
    require __DIR__ . '/web_routes/config.php';
    require __DIR__ . '/web_routes/kpis.php';
    require __DIR__ . '/web_routes/messaging.php';

    // Redirect Jetstream profile page to config
    Route::get('/user/profile', fn () => redirect()->route('config.profile'))
        ->name('profile.show');

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\NotificationsController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/all', [\App\Http\Controllers\NotificationsController::class, 'all'])->name('notifications.all');
    Route::post('/notifications/mark-read', [\App\Http\Controllers\NotificationsController::class, 'markRead'])->name('notifications.markRead');
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationsController::class, 'markSingle'])->name('notifications.markSingle');
});
