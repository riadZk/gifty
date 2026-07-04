<?php

namespace App\Http\Controllers;

use App\Models\BonusRequest;
use App\Models\Client;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class KpiController extends Controller
{
    public function index(): View
    {
        // ── Client totals ─────────────────────────────────────────────────────
        $totalClients  = Client::count();
        $totalSales    = (float) Client::sum('total_sales');
        $totalPoints   = (float) Client::sum('points_balance');
        $activeClients = Client::where('status', Client::STATUS_ACTIVE)->count();
        $avgSales      = $totalClients > 0 ? $totalSales / $totalClients : 0;

        // ── Bonus request totals ──────────────────────────────────────────────
        $totalDemandes     = BonusRequest::count();
        $pendingDemandes   = BonusRequest::where('status', BonusRequest::STATUS_PENDING)->count();
        $approvedDemandes  = BonusRequest::where('status', BonusRequest::STATUS_APPROVED)->count();
        $rejectedDemandes  = BonusRequest::where('status', BonusRequest::STATUS_REJECTED)->count();
        $deliveredDemandes = BonusRequest::where('status', BonusRequest::STATUS_DELIVERED)->count();
        $pointsRedeemed    = (float) BonusRequest::whereIn('status', [
            BonusRequest::STATUS_APPROVED,
            BonusRequest::STATUS_DELIVERED,
        ])->sum('points_required');

        // ── Build 12-month period ─────────────────────────────────────────────
        $months      = [];
        $monthLabels = [];

        for ($i = 11; $i >= 0; $i--) {
            $date          = Carbon::now()->subMonths($i)->startOfMonth();
            $months[]      = $date;
            $monthLabels[] = $date->locale('fr')->isoFormat('MMM YY');
        }

        $since = Carbon::now()->subMonths(11)->startOfMonth();

        // ── Monthly new clients ───────────────────────────────────────────────
        $monthlyClients = Client::selectRaw("TO_CHAR(accepted_at, 'YYYY-MM') as ym, COUNT(*) as cnt")
            ->whereNotNull('accepted_at')
            ->where('accepted_at', '>=', $since)
            ->groupBy('ym')
            ->pluck('cnt', 'ym');

        $clientsPerMonth = [];
        foreach ($months as $date) {
            $clientsPerMonth[] = (int) ($monthlyClients[$date->format('Y-m')] ?? 0);
        }

        // ── Monthly sales ─────────────────────────────────────────────────────
        $monthlySalesRaw = Client::selectRaw("TO_CHAR(accepted_at, 'YYYY-MM') as ym, SUM(total_sales) as total")
            ->whereNotNull('accepted_at')
            ->where('accepted_at', '>=', $since)
            ->groupBy('ym')
            ->pluck('total', 'ym');

        $salesPerMonth = [];
        foreach ($months as $date) {
            $salesPerMonth[] = (float) ($monthlySalesRaw[$date->format('Y-m')] ?? 0);
        }

        // ── Monthly bonus requests ────────────────────────────────────────────
        $monthlyDemandesRaw = BonusRequest::selectRaw("TO_CHAR(requested_at, 'YYYY-MM') as ym, COUNT(*) as cnt")
            ->where('requested_at', '>=', $since)
            ->groupBy('ym')
            ->pluck('cnt', 'ym');

        $demandesPerMonth = [];
        foreach ($months as $date) {
            $demandesPerMonth[] = (int) ($monthlyDemandesRaw[$date->format('Y-m')] ?? 0);
        }

        // ── Top 8 clients by sales ────────────────────────────────────────────
        $topBySales = Client::orderByDesc('total_sales')
            ->take(8)
            ->get(['company_name', 'total_sales']);

        // ── Top 8 clients by points ───────────────────────────────────────────
        $topByPoints = Client::orderByDesc('points_balance')
            ->take(8)
            ->get(['company_name', 'points_balance']);

        // ── Most requested bonus levels (with last 4 requesting clients) ──────
        $topBonusLevels = BonusRequest::selectRaw('bonus_level_id, COUNT(*) as cnt')
            ->with('bonusLevel:id,reward_name,name,image')
            ->groupBy('bonus_level_id')
            ->orderByDesc('cnt')
            ->take(6)
            ->get()
            ->each(function ($row) {
                // Load the last 4 distinct clients who requested this bonus
                $row->latestClients = BonusRequest::where('bonus_level_id', $row->bonus_level_id)
                    ->with('client:id,company_name')
                    ->latest('requested_at')
                    ->get()
                    ->unique('client_id')
                    ->take(4)
                    ->pluck('client');
            });

        // ── Recent bonus requests ─────────────────────────────────────────────
        $recentDemandes = BonusRequest::with(['client:id,company_name', 'bonusLevel:id,reward_name'])
            ->latest('requested_at')
            ->take(8)
            ->get();

        // ── Demande status distribution ───────────────────────────────────────
        $demandeStatus = [
            'pending'   => $pendingDemandes,
            'approved'  => $approvedDemandes,
            'rejected'  => $rejectedDemandes,
            'delivered' => $deliveredDemandes,
        ];

        // ── Period-over-period deltas (current month vs previous month) ───────
        $delta = function (array $series): float {
            $n = count($series);
            if ($n < 2) {
                return 0;
            }
            $current  = $series[$n - 1];
            $previous = $series[$n - 2];
            if ($previous == 0) {
                return $current > 0 ? 100 : 0;
            }
            return round((($current - $previous) / $previous) * 100, 1);
        };

        $clientsDelta  = $delta($clientsPerMonth);
        $salesDelta    = $delta($salesPerMonth);
        $demandesDelta = $delta($demandesPerMonth);

        // ── Bonus approval rate (gauge) ───────────────────────────────────────
        $processedDemandes = $approvedDemandes + $deliveredDemandes + $rejectedDemandes;
        $approvalRate = $processedDemandes > 0
            ? round((($approvedDemandes + $deliveredDemandes) / $processedDemandes) * 100)
            : 0;

        return view('content.kpis.index', compact(
            'totalClients',
            'totalSales',
            'totalPoints',
            'activeClients',
            'avgSales',
            'totalDemandes',
            'pendingDemandes',
            'approvedDemandes',
            'rejectedDemandes',
            'deliveredDemandes',
            'pointsRedeemed',
            'monthLabels',
            'clientsPerMonth',
            'salesPerMonth',
            'demandesPerMonth',
            'topBySales',
            'topByPoints',
            'topBonusLevels',
            'recentDemandes',
            'demandeStatus',
            'clientsDelta',
            'salesDelta',
            'demandesDelta',
            'approvalRate'
        ));
    }
}
