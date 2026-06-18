@php
$isActive = fn(string $route) => request()->routeIs($route);
$user = Auth::user();

$linkBase = 'relative flex items-center gap-2 px-4 py-2 text-[13px] font-semibold rounded-full transition-colors';
$linkIdle = 'text-slate-600 hover:bg-orange-50 hover:text-slate-900';
$linkActive = 'bg-orange-50 text-slate-900';
$iconIdle = 'text-slate-500';
$iconActive = 'text-[rgb(255,198,11)]';

@endphp

<nav class="sticky top-0 z-40 w-full bg-white shadow-sm border-b border-slate-100" aria-label="Navigation principale">
    <div class="mx-auto flex h-[64px] max-w-screen-2xl items-center px-4 sm:px-6 lg:px-8">

        {{-- Logo (left) --}}
        <div class="flex flex-1 items-center">
            <a href="{{ route('dashboard') }}"
                class="flex h-10 shrink-0 items-center gap-2 overflow-hidden rounded-xl bg-pcc-yellow px-3 shadow-sm"
                aria-label="Tractafric Equipment CAT">
                <img src="{{ asset('logo.svg') }}" alt="Tractafric Equipment CAT"
                    class="block h-7 w-auto object-contain">
            </a>
        </div>

        {{-- Desktop nav links (center) --}}
        <div class="hidden items-center gap-1 lg:flex">

            <a href="{{ route('dashboard') }}"
                class="{{ $linkBase }} {{ $isActive('dashboard') ? $linkActive : $linkIdle }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                    stroke-linejoin="round" class="h-4 w-4 {{ $isActive('dashboard') ? $iconActive : $iconIdle }}"
                    aria-hidden="true">
                    <path d="M3 11l9-8 9 8" />
                    <path d="M5 10v10h14V10" />
                    <path d="M9 20v-6h6v6" />
                </svg>
                Dashboard
            </a>

            <a href="#" class="{{ $linkBase }} {{ $isActive('operations*') ? $linkActive : $linkIdle }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                    stroke-linejoin="round" class="h-4 w-4 {{ $isActive('operations*') ? $iconActive : $iconIdle }}"
                    aria-hidden="true">
                    <rect x="2" y="7" width="20" height="14" rx="2" />
                    <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" />
                    <line x1="12" y1="12" x2="12" y2="16" />
                    <line x1="10" y1="14" x2="14" y2="14" />
                </svg>
                Opérations
            </a>

            <a href="#" class="{{ $linkBase }} {{ $isActive('envois*') ? $linkActive : $linkIdle }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                    stroke-linejoin="round" class="h-4 w-4 {{ $isActive('envois*') ? $iconActive : $iconIdle }}"
                    aria-hidden="true">
                    <path d="M22 2 11 13" />
                    <path d="M22 2 15 22 11 13 2 9l20-7z" />
                </svg>
                Envois
            </a>

            <a href="{{ route('clients') }}" class="{{ $linkBase }} {{ $isActive('clients*') ? $linkActive : $linkIdle }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                    stroke-linejoin="round" class="h-4 w-4 {{ $isActive('clients*') ? $iconActive : $iconIdle }}"
                    aria-hidden="true">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                Clients
            </a>

            <a href="#" class="{{ $linkBase }} {{ $isActive('map*') ? $linkActive : $linkIdle }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                    stroke-linejoin="round" class="h-4 w-4 {{ $isActive('map*') ? $iconActive : $iconIdle }}"
                    aria-hidden="true">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 8v4l3 3" />
                </svg>
                Map
            </a>

            <a href="#" class="{{ $linkBase }} {{ $isActive('calendar*') ? $linkActive : $linkIdle }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                    stroke-linejoin="round" class="h-4 w-4 {{ $isActive('calendar*') ? $iconActive : $iconIdle }}"
                    aria-hidden="true">
                    <rect x="3" y="4" width="18" height="18" rx="2" />
                    <line x1="16" y1="2" x2="16" y2="6" />
                    <line x1="8" y1="2" x2="8" y2="6" />
                    <line x1="3" y1="10" x2="21" y2="10" />
                </svg>
                Calendar
            </a>

            {{-- Administration dropdown --}}
            {{-- <div x-data="{ adminOpen: false }" class="relative">
                <button @click="adminOpen = !adminOpen" @click.outside="adminOpen = false"
                    class="{{ $linkBase }} {{ $linkIdle }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                        stroke-linejoin="round" class="h-4 w-4" aria-hidden="true">
                        <circle cx="12" cy="12" r="3" />
                        <path
                            d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.6V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.9.3l-.1.1A2 2 0 1 1 4.2 17l.1-.1A1.7 1.7 0 0 0 4.6 15a1.7 1.7 0 0 0-1.6-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.3-1.9l-.1-.1A2 2 0 1 1 7 4.2l.1.1A1.7 1.7 0 0 0 9 4.6a1.7 1.7 0 0 0 1-1.6V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.9-.3l.1-.1A2 2 0 1 1 19.8 7l-.1.1a1.7 1.7 0 0 0-.3 1.9 1.7 1.7 0 0 0 1.6 1h.1a2 2 0 1 1 0 4H21a1.7 1.7 0 0 0-1.6 1z" />
                    </svg>
                    Administration
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        class="h-3 w-3 transition-transform" :class="adminOpen ? 'rotate-180' : ''">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </button>
                <div x-show="adminOpen" x-cloak x-transition
                    class="absolute left-0 top-full mt-1 w-48 rounded-2xl border border-slate-100 bg-white py-2 shadow-lg">
                    <a href="{{ route('profile.show') }}"
                        class="flex items-center gap-2.5 px-4 py-2.5 text-[13px] font-semibold text-slate-700 hover:bg-slate-50">
                        Paramètres
                    </a>
                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <a href="{{ route('api-tokens.index') }}"
                        class="flex items-center gap-2.5 px-4 py-2.5 text-[13px] font-semibold text-slate-700 hover:bg-slate-50">
                        API Tokens
                    </a>
                    @endif
                    <div class="my-1 mx-3 h-px bg-slate-100"></div>
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <button type="button" @click="$root.submit();"
                            class="flex w-full items-center gap-2.5 px-4 py-2.5 text-[13px] font-semibold text-red-500 hover:bg-red-50">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div> --}}
        </div>

        {{-- Right cluster --}}
        <div class="flex flex-1 items-center justify-end gap-2">

            {{-- Messages --}}
            <button type="button" aria-label="Messages"
                class="inline-grid h-9 w-9 place-items-center rounded-full text-slate-500 hover:bg-slate-100 transition">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                    stroke-linejoin="round" class="h-[18px] w-[18px]" aria-hidden="true">
                    <path d="M4 6h16v12H4z" />
                    <path d="m4 6 8 7 8-7" />
                </svg>
            </button>

            {{-- Notifications --}}
            <button type="button" aria-label="Notifications"
                class="relative inline-grid h-9 w-9 place-items-center rounded-full text-slate-500 hover:bg-slate-100 transition">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                    stroke-linejoin="round" class="h-[18px] w-[18px]" aria-hidden="true">
                    <path d="M18 8a6 6 0 1 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9" />
                    <path d="M13.7 21a2 2 0 0 1-3.4 0" />
                </svg>
                <span
                    class="absolute -right-0.5 -top-0.5 grid h-4 min-w-[16px] place-items-center rounded-full bg-pcc-yellow px-1 text-[10px] font-black leading-none text-[#101820]">6</span>
            </button>

            {{-- Profile --}}
            <x-dropdown align="right" width="56">
                <x-slot name="trigger">
                    <button type="button"
                        class="flex items-center gap-2 rounded-full py-1 pl-1 pr-3 hover:bg-slate-100 transition">
                        @if ($user && $user->profile_photo_url)
                        <img class="h-8 w-8 rounded-full object-cover" src="{{ $user->profile_photo_url }}"
                            alt="{{ $user->name }}">
                        @else
                        <span
                            class="grid h-8 w-8 place-items-center rounded-full bg-pcc-yellow text-[12px] font-bold text-[#101820]">
                            {{ $user ? strtoupper(substr($user->name, 0, 1)) : '?' }}
                        </span>
                        @endif
                        <span class="hidden flex-col text-left leading-tight sm:flex">
                            <span class="text-[13px] font-bold text-slate-800">{{ $user?->name }}</span>
                            <span class="text-[11px] text-slate-500">{{ $user?->email }}</span>
                        </span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="hidden h-3 w-3 text-slate-400 sm:block">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="block px-4 py-3">
                        <div class="text-[13px] font-bold text-slate-800">{{ $user?->name }}</div>
                        <div class="text-[11px] text-slate-500">{{ $user?->email }}</div>
                    </div>

                    <x-dropdown-link href="{{ route('profile.show') }}">{{ __('Profile') }}</x-dropdown-link>

                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-dropdown-link href="{{ route('api-tokens.index') }}">{{ __('API Tokens') }}</x-dropdown-link>
                    @endif

                    <div class="mx-3 my-1 h-px bg-slate-100"></div>

                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>

            {{-- Mobile hamburger --}}
            <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Menu"
                class="inline-grid h-9 w-9 place-items-center rounded-full text-slate-500 hover:bg-slate-100 transition lg:hidden">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    class="h-5 w-5">
                    <path d="M3 6h18M3 12h18M3 18h18" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="mobileMenuOpen" x-cloak x-transition class="border-t border-slate-100 bg-white px-4 py-3 lg:hidden">
        <div class="flex flex-col gap-1">
            <a href="{{ route('dashboard') }}"
                class="{{ $linkBase }} {{ $isActive('dashboard') ? $linkActive : $linkIdle }}">Dashboard</a>
            <a href="#" class="{{ $linkBase }} {{ $linkIdle }}">Opérations</a>
            <a href="#" class="{{ $linkBase }} {{ $linkIdle }}">Envois</a>
            <a href="#" class="{{ $linkBase }} {{ $linkIdle }}">Clients</a>
            <a href="#" class="{{ $linkBase }} {{ $linkIdle }}">Map</a>
            <a href="#" class="{{ $linkBase }} {{ $linkIdle }}">Calendar</a>
            <a href="{{ route('profile.show') }}" class="{{ $linkBase }} {{ $linkIdle }}">Administration</a>
        </div>
    </div>
</nav>