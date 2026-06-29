<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BonusRequest;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    // ── List clients ──────────────────────────────────────────────────────────

    public function index(Request $request): View|JsonResponse
    {
        $perPage = 16;

        $query = Client::query()
            ->select(['id', 'company_name', 'contact_name', 'email', 'phone', 'pcc_customer_code', 'points_balance', 'total_sales', 'status', 'created_at'])
            ->latest();

        if ($search = trim((string) $request->get('search', ''))) {
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                    ->orWhere('contact_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('pcc_customer_code', 'like', "%{$search}%");
            });
        }

        $status = (string) $request->get('status', 'all');
        if (in_array($status, [Client::STATUS_ACTIVE, Client::STATUS_INACTIVE, Client::STATUS_BLOCKED], true)) {
            $query->where('status', $status);
        }

        $clients = $query->paginate($perPage)->withQueryString();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'cards'    => view('content.clients._cards', compact('clients'))->render(),
                'rows'     => view('content.clients._rows', compact('clients'))->render(),
                'hasMore'  => $clients->hasMorePages(),
                'total'    => $clients->total(),
                'page'     => $clients->currentPage(),
            ]);
        }

        $totalClients = Client::count();
        $activeCount  = Client::where('status', Client::STATUS_ACTIVE)->count();
        $inactiveCount = Client::where('status', Client::STATUS_INACTIVE)->count();
        $blockedCount = Client::where('status', Client::STATUS_BLOCKED)->count();
        $newCount     = Client::where('created_at', '>=', now()->startOfMonth())->count();
        $totalPoints  = Client::sum('points_balance');

        return view('content.clients.index', compact(
            'clients',
            'totalClients',
            'activeCount',
            'inactiveCount',
            'blockedCount',
            'newCount',
            'totalPoints',
        ));
    }

    // ── Show a client ─────────────────────────────────────────────────────────

    public function show(Client $client): View
    {
        $logs = BonusRequest::where('client_id', $client->id)
            ->with('bonusLevel')
            ->orderByDesc('requested_at')
            ->orderByDesc('id')
            ->limit(30)
            ->get();

        // ── Activity statistics (all requests) ──
        $statusCounts = BonusRequest::where('client_id', $client->id)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $statusCounts = [
            'pending'   => (int) ($statusCounts['pending'] ?? 0),
            'approved'  => (int) ($statusCounts['approved'] ?? 0),
            'rejected'  => (int) ($statusCounts['rejected'] ?? 0),
            'delivered' => (int) ($statusCounts['delivered'] ?? 0),
        ];

        $requestsCount  = array_sum($statusCounts);
        $approvedCount  = $statusCounts['approved'] + $statusCounts['delivered'];
        $pointsSpent    = (float) BonusRequest::where('client_id', $client->id)
            ->whereIn('status', ['approved', 'delivered'])
            ->sum('points_required');

        // ── Points overview (lifetime earned from sales, used, current balance) ──
        $pointsEarned  = Client::calculatePoints((float) $client->total_sales);
        $pointsBalance = (float) $client->points_balance;

        // ── Monthly activity (last 6 months) ──
        $monthlyLabels = [];
        $monthlyData   = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->startOfMonth()->subMonths($i);
            $monthlyLabels[] = ucfirst($month->translatedFormat('M'));
            $monthlyData[]   = BonusRequest::where('client_id', $client->id)
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        return view('content.clients.show', compact(
            'client',
            'logs',
            'statusCounts',
            'requestsCount',
            'approvedCount',
            'pointsSpent',
            'pointsEarned',
            'monthlyLabels',
            'monthlyData',
        ));
    }

    // ── Block / unblock / activate ────────────────────────────────────────────

    public function block(Client $client): RedirectResponse|JsonResponse
    {
        $client->update(['status' => Client::STATUS_BLOCKED]);
        $msg = "{$client->company_name} a été bloqué.";
        if (request()->wantsJson()) {
            return response()->json(['status' => Client::STATUS_BLOCKED, 'message' => $msg]);
        }
        return back()->with('success', $msg);
    }

    public function unblock(Client $client): RedirectResponse|JsonResponse
    {
        $client->update(['status' => Client::STATUS_ACTIVE]);
        $msg = "{$client->company_name} a été débloqué.";
        if (request()->wantsJson()) {
            return response()->json(['status' => Client::STATUS_ACTIVE, 'message' => $msg]);
        }
        return back()->with('success', $msg);
    }

    public function activate(Client $client): RedirectResponse|JsonResponse
    {
        $client->activate(auth()->id());
        $msg = "{$client->company_name} a été activé.";
        if (request()->wantsJson()) {
            return response()->json(['status' => Client::STATUS_ACTIVE, 'message' => $msg]);
        }
        return back()->with('success', $msg);
    }
}
