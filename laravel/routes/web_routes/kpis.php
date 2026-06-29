<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KpiController;

Route::get('/kpis', [KpiController::class, 'index'])->name('kpis.index');

