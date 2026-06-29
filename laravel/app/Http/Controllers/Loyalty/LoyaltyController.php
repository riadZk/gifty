<?php

namespace App\Http\Controllers\Loyalty;

use App\Http\Controllers\Controller;
use App\Models\BonusLevel;
use App\Models\Client;
use App\Models\LoyaltySetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class LoyaltyController extends Controller
{
    public function index(): View
    {
        $clients  = Client::latest()->get(['id', 'company_name', 'contact_name', 'email', 'phone', 'pcc_customer_code', 'points_balance', 'total_sales', 'status', 'created_at']);
        $settings = LoyaltySetting::instance();
        $levels   = BonusLevel::ordered()->get();

        return view('content.loyalty.index', compact('clients', 'settings', 'levels'));
    }

    // ── Loyalty settings (singleton) ──────────────────────────────────────────

    public function updateSettings(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'currency'     => 'required|string|max:10',
            'amount_value' => 'required|numeric|min:0.01',
            'points_value' => 'required|numeric|min:0.01',
            'annual_reset' => 'boolean',
        ]);

        $settings = LoyaltySetting::instance();
        $settings->update($validated);

        return response()->json(['message' => 'Paramètres mis à jour.', 'settings' => $settings]);
    }

    // ── Bonus levels ──────────────────────────────────────────────────────────

    public function storeLevel(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:100',
            'required_points'    => 'required|numeric|min:0',
            'reward_name'        => 'required|string|max:255',
            'reward_description' => 'nullable|string',
            'is_active'          => 'boolean',
            'sort_order'         => 'integer|min:0',
            'image'              => 'nullable|image|mimes:jpeg,png,webp,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = Storage::url($request->file('image')->store('bonus-levels', 'public'));
        }

        $level = BonusLevel::create($validated);

        return response()->json(['message' => 'Niveau créé.', 'level' => $level], 201);
    }

    public function updateLevel(Request $request, BonusLevel $level): JsonResponse
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:100',
            'required_points'    => 'required|numeric|min:0',
            'reward_name'        => 'required|string|max:255',
            'reward_description' => 'nullable|string',
            'is_active'          => 'boolean',
            'sort_order'         => 'integer|min:0',
            'image'              => 'nullable|image|mimes:jpeg,png,webp,gif|max:2048',
            'remove_image'       => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if stored locally
            if ($level->image && str_starts_with($level->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $level->image));
            }
            $validated['image'] = Storage::url($request->file('image')->store('bonus-levels', 'public'));
        } elseif (!empty($validated['remove_image'])) {
            if ($level->image && str_starts_with($level->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $level->image));
            }
            $validated['image'] = null;
        }

        unset($validated['remove_image']);
        $level->update($validated);

        return response()->json(['message' => 'Niveau mis à jour.', 'level' => $level]);
    }

    public function destroyLevel(BonusLevel $level): JsonResponse
    {
        $level->delete();

        return response()->json(['message' => 'Niveau supprimé.']);
    }
}
