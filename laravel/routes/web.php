<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    require __DIR__ . '/web_routes/dashboard.php';
    require __DIR__ . '/web_routes/client.php';
});
