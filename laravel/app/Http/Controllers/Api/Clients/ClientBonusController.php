<?php

namespace App\Http\Controllers\Api\Clients;

use App\Http\Controllers\Api\Controller;
use App\Models\BonusLevel;
use App\Models\BonusRequest;
use App\Models\Role;
use App\Models\User;
use App\Notifications\NewBonusRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientBonusController extends Controller
{
    // ── GET /api/client/bonus-levels ──────────────────────────────────────────
    // List all active bonus levels with eligibility info for the client.

    public function bonusLevels(Request $request): JsonResponse
    {
        $client = $request->user('client');

        // IDs already requested (pending) by this client
        $pendingLevelIds = BonusRequest::where('client_id', $client->id)
            ->where('status', BonusRequest::STATUS_PENDING)
            ->pluck('bonus_level_id')
            ->toArray();

        $levels = BonusLevel::where('is_active', true)
            ->orderBy('required_points')
            ->get()
            ->map(fn($level) => [
                'id'                  => $level->id,
                'name'                => $level->name,
                'reward_name'         => $level->reward_name,
                'reward_description'  => $level->reward_description,
                'image'               => $level->image,
                'required_points'     => (float) $level->required_points,
                'can_redeem'          => $client->points_balance >= $level->required_points,
                'points_missing'      => max(0, $level->required_points - $client->points_balance),
                'has_pending_request' => in_array($level->id, $pendingLevelIds),
            ]);

        return $this->jsonResponse([
            'points_balance' => (float) $client->points_balance,
            'bonus_levels'   => $levels,
        ]);
    }

    // ── GET /api/client/bonus-requests ───────────────────────────────────────
    // List all bonus requests for the authenticated client.

    public function index(Request $request): JsonResponse
    {
        $client = $request->user('client');

        $requests = BonusRequest::with(['bonusLevel', 'transaction'])
            ->where('client_id', $client->id)
            ->latest()
            ->get()
            ->map(fn($r) => $this->formatRequest($r));

        $counts = [
            'total'    => $requests->count(),
            'pending'  => $requests->where('status', 'pending')->count(),
            'approved' => $requests->where('status', 'approved')->count(),
            'rejected' => $requests->where('status', 'rejected')->count(),
            'delivered' => $requests->where('status', 'delivered')->count(),
        ];

        return $this->jsonResponse([
            'counts'  => $counts,
            'data'    => $requests->values(),
        ]);
    }

    // ── POST /api/client/bonus-requests ──────────────────────────────────────
    // Submit a new bonus request.

    public function store(Request $request): JsonResponse
    {
        $client = $request->user('client');

        $validated = $request->validate([
            'bonus_level_id' => ['required', 'exists:bonus_levels,id'],
            'notes'          => ['nullable', 'string', 'max:1000'],
        ]);

        $level = BonusLevel::where('id', $validated['bonus_level_id'])
            ->where('is_active', true)
            ->firstOrFail();

        // Check sufficient points
        if ($client->points_balance < $level->required_points) {
            return $this->jsonResponse([
                'points_balance'  => (float) $client->points_balance,
                'points_required' => (float) $level->required_points,
                'points_missing'  => (float) ($level->required_points - $client->points_balance),
            ], 'Insufficient points balance.', 422);
        }

        // Prevent duplicate pending request
        $exists = BonusRequest::where('client_id', $client->id)
            ->where('bonus_level_id', $level->id)
            ->where('status', BonusRequest::STATUS_PENDING)
            ->exists();

        if ($exists) {
            return $this->jsonResponse(null, 'A pending request already exists for this bonus.', 422);
        }

        $bonusRequest = BonusRequest::create([
            'client_id'      => $client->id,
            'bonus_level_id' => $level->id,
            'points_required' => $level->required_points,
            'status'         => BonusRequest::STATUS_PENDING,
            'requested_at'   => now(),
            'notes'          => $validated['notes'] ?? null,
        ]);

        $bonusRequest->load(['bonusLevel', 'client']);

        // Notify all users with the admin role
        $notification = new NewBonusRequest($bonusRequest);
        User::whereHas('roles', fn($q) => $q->where('name', 'admin'))
            ->each(fn(User $user) => $user->notify($notification));

        return $this->jsonResponse($this->formatRequest($bonusRequest), 'Request submitted successfully.', 201);
    }

    // ── GET /api/client/bonus-requests/{id} ──────────────────────────────────
    // View a single bonus request (must belong to the client).

    public function show(Request $request, int $id): JsonResponse
    {
        $client = $request->user('client');

        $bonusRequest = BonusRequest::with(['bonusLevel', 'transaction'])
            ->where('id', $id)
            ->where('client_id', $client->id)
            ->first();

        if (! $bonusRequest) {
            return $this->jsonResponse(null, 'Bonus request not found.', 404);
        }

        return $this->jsonResponse($this->formatRequest($bonusRequest));
    }

    // ── DELETE /api/client/bonus-requests/{id} ────────────────────────────────
    // Cancel a pending request (client can withdraw before it's processed).

    public function cancel(Request $request, int $id): JsonResponse
    {
        $client = $request->user('client');

        $bonusRequest = BonusRequest::where('id', $id)
            ->where('client_id', $client->id)
            ->where('status', BonusRequest::STATUS_PENDING)
            ->first();

        if (! $bonusRequest) {
            return $this->jsonResponse(null, 'Pending bonus request not found.', 404);
        }

        $bonusRequest->delete();

        return $this->jsonResponse(null, 'Request cancelled.');
    }

    // ── Helper ────────────────────────────────────────────────────────────────

    private function formatRequest(BonusRequest $r): array
    {
        $result = [
            'id'              => $r->id,
            'bonus_level'     => $r->bonusLevel ? [
                'id'                 => $r->bonusLevel->id,
                'name'               => $r->bonusLevel->name,
                'reward_name'        => $r->bonusLevel->reward_name,
                'reward_description' => $r->bonusLevel->reward_description,
                'image'              => $r->bonusLevel->image,
                'required_points'    => (float) $r->bonusLevel->required_points,
            ] : null,
            'points_required' => (float) $r->points_required,
            'status'          => $r->status,
            'notes'           => $r->notes,
            'requested_at'    => $r->requested_at?->toIso8601String(),
            'approved_at'     => $r->approved_at?->toIso8601String(),
            'rejected_at'     => $r->rejected_at?->toIso8601String(),
        ];

        if ($r->relationLoaded('transaction') && $r->transaction) {
            $tx = $r->transaction;
            $result['transaction'] = [
                'points_before' => (float) $tx->points_before,
                'points_used'   => (float) $tx->points_used,
                'points_after'  => (float) $tx->points_after,
                'created_at'    => \Carbon\Carbon::parse($tx->created_at)->toIso8601String(),
            ];
        }

        return $result;
    }
}
