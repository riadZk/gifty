<?php

use Illuminate\Support\Facades\Route;
use App\Models\Client;
use App\Models\BonusLevel;
use App\Models\BonusRequest;

Route::get('/', function () {
    // ── Clients ───────────────────────────────────────────────────────────────
    $totalClients   = Client::count();
    $activeClients  = Client::where('status', Client::STATUS_ACTIVE)->count();
    $blockedClients = Client::where('status', Client::STATUS_BLOCKED)->count();
    $totalSales     = Client::sum('total_sales');
    $totalPoints    = Client::sum('points_balance');

    $recentClients = Client::latest('accepted_at')->take(5)->get();
    $topClients    = Client::orderByDesc('points_balance')->take(5)->get();

    // ── Demandes (bonus requests) ─────────────────────────────────────────────
    $totalDemandes     = BonusRequest::count();
    $pendingDemandes   = BonusRequest::where('status', BonusRequest::STATUS_PENDING)->count();
    $approvedDemandes  = BonusRequest::where('status', BonusRequest::STATUS_APPROVED)->count();
    $deliveredDemandes = BonusRequest::where('status', BonusRequest::STATUS_DELIVERED)->count();
    $rejectedDemandes  = BonusRequest::where('status', BonusRequest::STATUS_REJECTED)->count();

    $recentDemandes = BonusRequest::with(['client', 'bonusLevel'])
        ->latest('requested_at')
        ->take(6)
        ->get();

    // ── Bonus levels ──────────────────────────────────────────────────────────
    $bonusLevels = BonusLevel::where('is_active', true)
        ->orderBy('sort_order')
        ->take(6)
        ->get();

    // ── Notifications ─────────────────────────────────────────────────────────
    $recentNotifications = auth()->user()
        ?->notifications()
        ->latest()
        ->take(4)
        ->get() ?? collect();

    return view('content.dashboard.index', compact(
        'totalClients', 'activeClients', 'blockedClients',
        'totalSales', 'totalPoints',
        'recentClients', 'topClients',
        'totalDemandes', 'pendingDemandes', 'approvedDemandes', 'deliveredDemandes', 'rejectedDemandes',
        'recentDemandes',
        'recentNotifications', 'bonusLevels'
    ));
})->name('dashboard');
