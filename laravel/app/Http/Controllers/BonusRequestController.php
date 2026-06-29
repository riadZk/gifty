<?php

namespace App\Http\Controllers;

use App\Models\BonusLevel;
use App\Models\BonusRequest;
use App\Models\BonusTransaction;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BonusRequestController extends Controller
{
    // ── Show create form ──────────────────────────────────────────────────────

    public function create(Request $request): View
    {
        $client      = Client::findOrFail($request->query('client_id'));
        $bonusLevels = BonusLevel::where('is_active', true)
            ->orderBy('required_points')
            ->get();

        return view('content.demande_bonnus.create', compact('client', 'bonusLevels'));
    }

    // ── Store new request ─────────────────────────────────────────────────────

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'client_id'      => ['required', 'exists:clients,id'],
            'bonus_level_id' => ['required', 'exists:bonus_levels,id'],
            'notes'          => ['nullable', 'string', 'max:1000'],
        ]);

        $client     = Client::findOrFail($request->client_id);
        $bonusLevel = BonusLevel::findOrFail($request->bonus_level_id);

        $exists = BonusRequest::where('client_id', $client->id)
            ->where('bonus_level_id', $bonusLevel->id)
            ->where('status', BonusRequest::STATUS_PENDING)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Une demande en attente existe déjà pour ce bonus.');
        }

        $bonusRequest = BonusRequest::create([
            'client_id'      => $client->id,
            'bonus_level_id' => $bonusLevel->id,
            'points_required'=> $bonusLevel->required_points,
            'status'         => BonusRequest::STATUS_PENDING,
            'requested_at'   => now(),
            'notes'          => $request->notes,
        ]);

        return redirect()->route('demandes.show', $bonusRequest->id)
            ->with('success', 'Demande créée avec succès.');
    }

    // ── List all requests ─────────────────────────────────────────────────────

    public function index(Request $request): View|JsonResponse
    {
        $mapper = fn(BonusRequest $r) => [
            'id'              => $r->id,
            'ref'             => $r->demande_key ?? ('DB-' . str_pad($r->id, 5, '0', STR_PAD_LEFT)),
            'client_name'     => $r->client->company_name ?? '—',
            'client_email'    => $r->client->email ?? '',
            'bonus_name'      => $r->bonusLevel->reward_name ?? '—',
            'bonus_image'     => $r->bonusLevel?->image ?: null,
            'points_required' => (int) $r->points_required,
            'status'          => $r->status,
            'requested_at'    => $r->requested_at?->toIso8601String(),
            'show_url'        => route('demandes.show', $r->id),
        ];

        $query = BonusRequest::with(['client', 'bonusLevel'])
            ->orderByDesc('requested_at')
            ->orderByDesc('id');

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        if ($q = $request->input('q')) {
            $query->where(function ($sub) use ($q) {
                $sub->whereHas('client',     fn($s) => $s->where('company_name', 'like', "%{$q}%"))
                    ->orWhereHas('bonusLevel', fn($s) => $s->where('reward_name',  'like', "%{$q}%"));
            });
        }

        $paginator = $query->paginate(16);

        // AJAX (infinite scroll) – return JSON only
        if ($request->ajax()) {
            return response()->json([
                'items'    => $paginator->getCollection()->map($mapper)->values(),
                'has_more' => $paginator->hasMorePages(),
                'page'     => $paginator->currentPage(),
                'total'    => $paginator->total(),
            ]);
        }

        // ── Full-page stats (unfiltered) ──────────────────────────────────────
        $counts = [
            'total'    => BonusRequest::count(),
            'pending'  => BonusRequest::where('status', 'pending')->count(),
            'approved' => BonusRequest::where('status', 'approved')->count(),
            'rejected' => BonusRequest::where('status', 'rejected')->count(),
            'delivered'=> BonusRequest::where('status', 'delivered')->count(),
        ];

        $pendingPoints = (float) BonusRequest::where('status', 'pending')->sum('points_required');
        $processed     = $counts['approved'] + $counts['delivered'] + $counts['rejected'];
        $approvalRate  = $processed > 0
            ? round((($counts['approved'] + $counts['delivered']) / $processed) * 100)
            : 0;

        $stats = [
            'pending'       => $counts['pending'],
            'pendingPoints' => $pendingPoints,
            'approvalRate'  => $approvalRate,
        ];

        // ── Monthly trend (last 6 months) ─────────────────────────────────────
        $trendRows = BonusRequest::selectRaw('EXTRACT(YEAR FROM requested_at) as y, EXTRACT(MONTH FROM requested_at) as m, COUNT(*) as cnt')
            ->where('requested_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('y', 'm')
            ->get()
            ->keyBy(fn($row) => ((int) $row->y) . '-' . ((int) $row->m));

        $frMonths = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
        $monthlyLabels = [];
        $monthlyData   = [];
        for ($i = 5; $i >= 0; $i--) {
            $dt = now()->subMonths($i)->startOfMonth();
            $monthlyLabels[] = $frMonths[$dt->month - 1] . " '" . $dt->format('y');
            $key = $dt->year . '-' . $dt->month;
            $monthlyData[] = isset($trendRows[$key]) ? (int) $trendRows[$key]->cnt : 0;
        }

        $initialItems = $paginator->getCollection()->map($mapper)->values();
        $hasMore      = $paginator->hasMorePages();
        $total        = $paginator->total();

        return view('content.demande_bonnus.index', compact(
            'counts', 'stats', 'monthlyLabels', 'monthlyData',
            'initialItems', 'hasMore', 'total'
        ));
    }

    // ── Show a single request ─────────────────────────────────────────────────

    public function show(BonusRequest $bonusRequest): View
    {
        $bonusRequest->load(['client', 'bonusLevel', 'approver', 'transaction']);

        return view('content.demande_bonnus.show', ['bonusRequest' => $bonusRequest]);
    }

    // ── Approve ───────────────────────────────────────────────────────────────

    public function approve(Request $request, BonusRequest $bonusRequest): RedirectResponse|JsonResponse
    {
        if (! $bonusRequest->isPending()) {
            $msg = 'Cette demande ne peut pas être approuvée.';
            return $request->expectsJson()
                ? response()->json(['message' => $msg], 422)
                : back()->with('error', $msg);
        }

        $client = $bonusRequest->client;

        if ($client->points_balance < $bonusRequest->points_required) {
            $msg = "Solde insuffisant : le client n'a que " .
                number_format($client->points_balance, 0, ',', ' ') . ' pts. Il manque ' .
                number_format($bonusRequest->points_required - $client->points_balance, 0, ',', ' ') . ' pts.';
            return $request->expectsJson()
                ? response()->json(['message' => $msg], 422)
                : back()->with('error', $msg);
        }

        DB::transaction(function () use ($bonusRequest, $client, $request) {
            $pointsBefore = (float) $client->points_balance;
            $pointsUsed   = (float) $bonusRequest->points_required;
            $pointsAfter  = $pointsBefore - $pointsUsed;

            $client->decrement('points_balance', $pointsUsed);

            $bonusRequest->update([
                'status'      => BonusRequest::STATUS_APPROVED,
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'notes'       => $request->filled('notes') ? $request->input('notes') : $bonusRequest->notes,
            ]);

            BonusTransaction::create([
                'client_id'        => $client->id,
                'bonus_request_id' => $bonusRequest->id,
                'bonus_level_id'   => $bonusRequest->bonus_level_id,
                'points_before'    => $pointsBefore,
                'points_used'      => $pointsUsed,
                'points_after'     => $pointsAfter,
            ]);
        });

        $successMsg = 'Demande approuvée — ' . number_format($bonusRequest->points_required, 0, ',', ' ') . ' pts déduits.';
        return $request->expectsJson()
            ? response()->json(['message' => $successMsg])
            : back()->with('success', $successMsg);
    }

    // ── Reject ────────────────────────────────────────────────────────────────

    public function reject(Request $request, BonusRequest $bonusRequest): RedirectResponse|JsonResponse
    {
        if (! $bonusRequest->isPending()) {
            $msg = 'Cette demande ne peut pas être rejetée.';
            return $request->expectsJson()
                ? response()->json(['message' => $msg], 422)
                : back()->with('error', $msg);
        }

        $bonusRequest->update([
            'status'      => BonusRequest::STATUS_REJECTED,
            'rejected_at' => now(),
            'notes'       => $request->filled('notes') ? $request->input('notes') : $bonusRequest->notes,
        ]);

        return $request->expectsJson()
            ? response()->json(['message' => 'Demande rejetée.'])
            : back()->with('success', 'Demande rejetée.');
    }

    // ── Mark as delivered ─────────────────────────────────────────────────────

    public function deliver(Request $request, BonusRequest $bonusRequest): RedirectResponse|JsonResponse
    {
        if (! $bonusRequest->isApproved()) {
            $msg = 'Seules les demandes approuvées peuvent être marquées livrées.';
            return $request->expectsJson()
                ? response()->json(['message' => $msg], 422)
                : back()->with('error', $msg);
        }

        $bonusRequest->update([
            'status' => BonusRequest::STATUS_DELIVERED,
            'notes'  => $request->filled('notes') ? $request->input('notes') : $bonusRequest->notes,
        ]);

        return $request->expectsJson()
            ? response()->json(['message' => 'Bonus marqué comme livré.'])
            : back()->with('success', 'Bonus marqué comme livré.');
    }
}
