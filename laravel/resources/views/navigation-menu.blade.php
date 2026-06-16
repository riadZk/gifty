@php
$isActive = fn (string $route) => request()->routeIs($route);

$linkBase = 'group flex items-center gap-3 rounded-2xl px-4 py-3 text-[13px] font-semibold transition';
$linkIdle = 'text-slate-700 hover:bg-slate-100 hover:text-slate-900';
$linkActive = 'bg-pcc-yellow/15 text-[#101820] shadow-[inset_0_0_0_1px_rgba(255,198,11,0.25)]';
@endphp

<aside
    class="fixed inset-y-0 left-0 z-40 flex w-[240px] -translate-x-full flex-col bg-white transition-transform lg:translate-x-0 lg:shadow-[4px_0_24px_rgba(0,0,0,0.12)]"
    :class="sidebarOpen ? 'translate-x-0 shadow-2xl' : '-translate-x-full lg:translate-x-0'"
    aria-label="Barre latérale">

    {{-- Brand --}}
    <div class="flex h-[72px] shrink-0 items-center gap-3 px-5">
        <a href="{{ route('dashboard') }}"
            class="inline-flex h-11 w-full items-center justify-center overflow-hidden rounded-2xl bg-pcc-yellow shadow-sm"
            aria-label="Tractafric Equipment CAT">
            <img src="{{ asset('logo.svg') }}" alt="Tractafric Equipment CAT"
                class="block h-9 w-auto max-w-full object-contain">
        </a>
        <button type="button" @click="sidebarOpen = false" aria-label="Fermer"
            class="inline-grid h-9 w-9 place-items-center rounded-full bg-slate-100 text-slate-500 transition hover:bg-slate-200 hover:text-slate-800 lg:hidden">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="h-4 w-4">
                <path d="M18 6 6 18M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Nav --}}
    <nav class="flex flex-1 flex-col gap-7 overflow-y-auto px-4 py-4">
        <div>
            <p class="px-4 pb-2 text-[10px] font-bold uppercase tracking-[0.14em] text-slate-500">Menu</p>
            <div class="flex flex-col gap-1">
                <a href="{{ route('dashboard') }}"
                    class="{{ $linkBase }} {{ $isActive('dashboard') ? $linkActive : $linkIdle }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                        stroke-linejoin="round" class="h-[18px] w-[18px]" aria-hidden="true">
                        <path d="M3 11l9-8 9 8" />
                        <path d="M5 10v10h14V10" />
                        <path d="M9 20v-6h6v6" />
                    </svg>
                    <span>Tableau de bord</span>
                </a>

                <a href="#" class="{{ $linkBase }} {{ $linkIdle }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                        stroke-linejoin="round" class="h-[18px] w-[18px]" aria-hidden="true">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    <span>Clients</span>
                </a>

                <a href="#" class="{{ $linkBase }} {{ $linkIdle }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                        stroke-linejoin="round" class="h-[18px] w-[18px]" aria-hidden="true">
                        <circle cx="9" cy="21" r="1" />
                        <circle cx="20" cy="21" r="1" />
                        <path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h8.7a2 2 0 0 0 2-1.6L22 6H6" />
                    </svg>
                    <span>Ventes &amp; Points</span>
                </a>

                <a href="#" class="{{ $linkBase }} {{ $linkIdle }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                        stroke-linejoin="round" class="h-[18px] w-[18px]" aria-hidden="true">
                        <path d="M20 12v10H4V12" />
                        <path d="M2 7h20v5H2z" />
                        <path d="M12 22V7" />
                        <path d="M12 7H8.5a2.5 2.5 0 1 1 2.2-3.7L12 7z" />
                        <path d="M12 7h3.5a2.5 2.5 0 1 0-2.2-3.7L12 7z" />
                    </svg>
                    <span>Bonus &amp; Livraisons</span>
                </a>

                <a href="#" class="{{ $linkBase }} {{ $linkIdle }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                        stroke-linejoin="round" class="h-[18px] w-[18px]" aria-hidden="true">
                        <path d="M18 8a6 6 0 1 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9" />
                        <path d="M13.7 21a2 2 0 0 1-3.4 0" />
                    </svg>
                    <span class="flex-1">Notifications</span>
                    <span
                        class="grid h-5 min-w-[20px] place-items-center rounded-full bg-pcc-yellow px-1.5 text-[10px] font-black leading-none text-[#101820]">8</span>
                </a>

                <a href="#" class="{{ $linkBase }} {{ $linkIdle }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                        stroke-linejoin="round" class="h-[18px] w-[18px]" aria-hidden="true">
                        <path d="M3 3v18h18" />
                        <rect x="7" y="12" width="3" height="6" />
                        <rect x="12" y="8" width="3" height="10" />
                        <rect x="17" y="5" width="3" height="13" />
                    </svg>
                    <span>Rapports</span>
                </a>
            </div>
        </div>

        <div>
            <p class="px-4 pb-2 text-[10px] font-bold uppercase tracking-[0.14em] text-slate-500">Général</p>
            <div class="flex flex-col gap-1">
                <a href="{{ route('profile.show') }}" class="{{ $linkBase }} {{ $linkIdle }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                        stroke-linejoin="round" class="h-[18px] w-[18px]" aria-hidden="true">
                        <circle cx="12" cy="12" r="3" />
                        <path
                            d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.6V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.9.3l-.1.1A2 2 0 1 1 4.2 17l.1-.1A1.7 1.7 0 0 0 4.6 15a1.7 1.7 0 0 0-1.6-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.3-1.9l-.1-.1A2 2 0 1 1 7 4.2l.1.1A1.7 1.7 0 0 0 9 4.6a1.7 1.7 0 0 0 1-1.6V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.9-.3l.1-.1A2 2 0 1 1 19.8 7l-.1.1a1.7 1.7 0 0 0-.3 1.9 1.7 1.7 0 0 0 1.6 1h.1a2 2 0 1 1 0 4H21a1.7 1.7 0 0 0-1.6 1z" />
                    </svg>
                    <span>Paramètres</span>
                </a>

                <a href="#" class="{{ $linkBase }} {{ $linkIdle }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                        stroke-linejoin="round" class="h-[18px] w-[18px]" aria-hidden="true">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M9.1 9a3 3 0 1 1 5.8 1c0 2-3 2-3 4" />
                        <path d="M12 17h.01" />
                    </svg>
                    <span>Aide</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" x-data class="contents">
                    @csrf
                    <button type="button" @click="$root.submit();"
                        class="{{ $linkBase }} {{ $linkIdle }} w-full text-left">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round" class="h-[18px] w-[18px]" aria-hidden="true">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <path d="m16 17 5-5-5-5" />
                            <path d="M21 12H9" />
                        </svg>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>
</aside>