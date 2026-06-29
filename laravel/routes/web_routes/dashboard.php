<?php

use Illuminate\Support\Facades\Route;
use App\Models\Client;
use App\Models\BonusLevel;

Route::get('/', function () {
    $totalClients = Client::count();
    $totalSales   = Client::sum('total_sales');
    $totalPoints  = Client::sum('points_balance');
    $recentClients = Client::latest('accepted_at')->take(5)->get();

    $recentNotifications = auth()->user()
        ?->notifications()
        ->latest()
        ->take(4)
        ->get() ?? collect();

    $bonusLevels = BonusLevel::where('is_active', true)
        ->orderBy('sort_order')
        ->take(6)
        ->get();

    return view('content.dashboard.index', compact(
        'totalClients', 'totalSales', 'totalPoints',
        'recentClients', 'recentNotifications', 'bonusLevels'
    ));
})->name('dashboard');
