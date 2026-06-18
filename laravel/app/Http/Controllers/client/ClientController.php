<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    // ── List clients ──────────────────────────────────────────────────────────

    public function index(Request $request): View
    {
        // AG Grid handles search/sort/filter client-side, so load everything.
        $clients = Client::latest()->get();

        $activeCount    = Client::where('status', Client::STATUS_ACTIVE)->count();
        $newCount       = Client::where('created_at', '>=', now()->startOfMonth())->count();
        $totalPoints    = Client::sum('points_balance');
        $aggridLicense  = (string) env('AGGRID_LICENSE_KEY', '');

        return view('content.clients.index', compact(
            'clients',
            'activeCount',
            'newCount',
            'totalPoints',
            'aggridLicense',
        ));
    }

    // ── Show a client ─────────────────────────────────────────────────────────

    public function show(Client $client): View
    {
        return view('content.clients.show', compact('client'));
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
