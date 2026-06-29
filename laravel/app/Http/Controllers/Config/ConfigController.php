<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\BonusLevel;
use App\Models\LoyaltySetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ConfigController extends Controller
{
    public function profile(): View
    {
        return view('content.config.profile', [
            'user' => Auth::user(),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        Auth::user()->update($request->only('name', 'email'));

        return back()->with('success', 'Profil mis à jour.');
    }

    public function pointsRules(): View
    {
        return view('content.config.points-rules', [
            'settings' => LoyaltySetting::instance(),
        ]);
    }

    public function bonusLevels(): View
    {
        return view('content.config.bonus-levels', [
            'levels' => BonusLevel::ordered()->get(),
        ]);
    }
}
