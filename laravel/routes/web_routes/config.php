<?php

use App\Http\Controllers\Config\ConfigController;
use Illuminate\Support\Facades\Route;

Route::prefix('config')->name('config.')->group(function () {
    Route::get('/',              [ConfigController::class, 'profile'])->name('profile');
    Route::post('/profile',        [ConfigController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/photo',  [ConfigController::class, 'updateProfilePhoto'])->name('profile.photo.update');
    Route::delete('/profile/photo', [ConfigController::class, 'removeProfilePhoto'])->name('profile.photo.remove');
    Route::get('/points-rules',    [ConfigController::class, 'pointsRules'])->name('points-rules');
    Route::get('/bonus-levels',    [ConfigController::class, 'bonusLevels'])->name('bonus-levels');

    // Canaux
    Route::get('/canaux',                  [ConfigController::class, 'canaux'])->name('canaux');
    Route::post('/canaux/smtp',            [ConfigController::class, 'saveSmtp'])->name('canaux.smtp.save');
    Route::post('/canaux/smtp/test',       [ConfigController::class, 'testSmtp'])->name('canaux.smtp.test');
    Route::post('/canaux/whatsapp',        [ConfigController::class, 'saveWhatsapp'])->name('canaux.whatsapp.save');
    Route::post('/canaux/whatsapp/test',   [ConfigController::class, 'testWhatsapp'])->name('canaux.whatsapp.test');
    Route::get('/canaux/whatsapp/qr',      [ConfigController::class, 'whatsappQr'])->name('canaux.whatsapp.qr');
    Route::post('/canaux/whatsapp/disconnect', [ConfigController::class, 'whatsappDisconnect'])->name('canaux.whatsapp.disconnect');
});
