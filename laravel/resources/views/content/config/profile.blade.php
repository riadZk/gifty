<x-app-layout>

    @php
        $currentUser = $user ?? Auth::user();
        $initials = strtoupper(mb_substr($currentUser->name, 0, 2));
    @endphp

    {{-- Override Jetstream form-section & action-section styles to match our design --}}
    <style>
        /* Hide the default left description column */
        .pcc-profile-wrap [class*="md:col-span-1"]:first-child { display: none !important; }
        .pcc-profile-wrap [class*="md:col-span-2"] { --tw-col-start: 1 !important; grid-column: 1 / -1 !important; }

        /* Card shells */
        .pcc-profile-wrap .pcc-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(15,23,42,.06);
        }
        .pcc-profile-wrap .pcc-card-title {
            font-size: 14px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 18px;
        }

        /* Inputs */
        .pcc-profile-wrap input[type="text"],
        .pcc-profile-wrap input[type="email"],
        .pcc-profile-wrap input[type="password"] {
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #f8fafc;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 600;
            color: #0f172a;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }
        .pcc-profile-wrap input:focus {
            border-color: #fbbf24;
            box-shadow: 0 0 0 3px rgba(251,191,36,.15);
        }
        .pcc-profile-wrap label.block {
            font-size: 12px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
            display: block;
        }

        /* Primary button */
        .pcc-profile-wrap button[type="submit"],
        .pcc-profile-wrap button.pcc-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            height: 36px;
            padding: 0 18px;
            background: #fbbf24;
            color: #0f172a;
            font-size: 12.5px;
            font-weight: 700;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            transition: background .15s;
        }
        .pcc-profile-wrap button[type="submit"]:hover,
        .pcc-profile-wrap button.pcc-primary:hover { background: #f59e0b; }

        /* Danger button */
        .pcc-profile-wrap button.pcc-danger {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            height: 36px;
            padding: 0 18px;
            background: #fef2f2;
            color: #dc2626;
            font-size: 12.5px;
            font-weight: 700;
            border-radius: 12px;
            border: 1px solid #fecaca;
            cursor: pointer;
            transition: background .15s;
        }
        .pcc-profile-wrap button.pcc-danger:hover { background: #fee2e2; }

        /* Secondary button */
        .pcc-profile-wrap button.pcc-secondary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            height: 36px;
            padding: 0 14px;
            background: #f8fafc;
            color: #475569;
            font-size: 12.5px;
            font-weight: 600;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            transition: background .15s;
        }
        .pcc-profile-wrap button.pcc-secondary:hover { background: #f1f5f9; }

        /* Saved message */
        .pcc-profile-wrap [dusk="action-message"] { font-size: 12px; font-weight: 600; color: #059669; }

        /* Error messages */
        .pcc-profile-wrap p[role="alert"],
        .pcc-profile-wrap .text-red-600 { font-size: 11.5px; color: #dc2626; margin-top: 4px; }

        /* Grid form layout */
        .pcc-profile-wrap .pcc-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        @media (max-width: 640px) { .pcc-profile-wrap .pcc-grid { grid-template-columns: 1fr; } }
        .pcc-profile-wrap .pcc-full { grid-column: 1 / -1; }
    </style>

    <div class="flex gap-6">

        {{-- Sidebar --}}
        @include('content.config._sidebar')

        {{-- Main --}}
        <div class="pcc-profile-wrap min-w-0 flex-1 flex flex-col gap-5">

            {{-- Breadcrumb --}}
            <div>
                <nav class="flex items-center gap-1.5 text-[11.5px] font-medium text-slate-400">
                    <span>Configuration</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3 w-3"><path d="m9 18 6-6-6-6"/></svg>
                    <span class="text-slate-600">Mon profil</span>
                </nav>
                <h1 class="mt-1 text-[22px] font-black tracking-tight text-slate-900">Mon profil</h1>
            </div>

            {{-- ── Avatar card ── --}}
            <div class="pcc-card">
                <div class="flex items-center gap-5">
                    @if ($currentUser->profile_photo_url)
                        <img src="{{ $currentUser->profile_photo_url }}" alt="{{ $currentUser->name }}"
                            class="h-16 w-16 rounded-2xl object-cover shadow-md">
                    @else
                        <span class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-400 text-[22px] font-black text-slate-900 shadow-md">
                            {{ $initials }}
                        </span>
                    @endif
                    <div>
                        <p class="text-[17px] font-black text-slate-900">{{ $currentUser->name }}</p>
                        <p class="mt-0.5 text-[13px] font-medium text-slate-400">{{ $currentUser->email }}</p>
                        <span class="mt-2 inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-[11px] font-bold text-emerald-700">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Administrateur
                        </span>
                    </div>
                </div>
            </div>

            {{-- ── Profile information (Livewire) ── --}}
            <div class="pcc-card">
                <p class="pcc-card-title">Informations du profil</p>
                @livewire('profile.update-profile-information-form')
            </div>

            {{-- ── Update password (Livewire) ── --}}
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="pcc-card">
                    <p class="pcc-card-title">Mot de passe</p>
                    @livewire('profile.update-password-form')
                </div>
            @endif

            {{-- ── Two-factor (Livewire) ── --}}
            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="pcc-card">
                    <p class="pcc-card-title">Authentification à deux facteurs</p>
                    @livewire('profile.two-factor-authentication-form')
                </div>
            @endif

            {{-- ── Browser sessions (Livewire) ── --}}
            <div class="pcc-card">
                <p class="pcc-card-title">Sessions actives</p>
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            {{-- ── Delete account (Livewire) ── --}}
            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <div class="pcc-card border-red-100">
                    <p class="pcc-card-title text-red-600">Supprimer le compte</p>
                    @livewire('profile.delete-user-form')
                </div>
            @endif

        </div>
    </div>

</x-app-layout>
