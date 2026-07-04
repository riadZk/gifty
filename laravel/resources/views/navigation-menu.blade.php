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
    <div class="flex h-[64px] w-full items-center px-4 sm:px-6 lg:px-8">

        {{-- Logo (left) --}}
        <div class="flex flex-1 items-center">
            <a href="{{ route('dashboard') }}" class="flex shrink-0 items-center" aria-label="Tractafric Equipment CAT">
                <img src="{{ asset('logo.svg') }}" alt="Tractafric Equipment CAT" class="block h-12 w-auto object-contain">
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
                {{ __('Dashboard') }}
            </a>

            <a href="{{ route('kpis.index') }}"
                class="{{ $linkBase }} {{ $isActive('kpis*') ? $linkActive : $linkIdle }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                    stroke-linejoin="round" class="h-4 w-4 {{ $isActive('kpis*') ? $iconActive : $iconIdle }}"
                    aria-hidden="true">
                    <line x1="18" y1="20" x2="18" y2="10" />
                    <line x1="12" y1="20" x2="12" y2="4" />
                    <line x1="6" y1="20" x2="6" y2="14" />
                </svg>
                {{ __('KPIs') }}
            </a>

            <a href="{{ route('clients') }}"
                class="{{ $linkBase }} {{ $isActive('clients*') ? $linkActive : $linkIdle }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                    stroke-linejoin="round" class="h-4 w-4 {{ $isActive('clients*') ? $iconActive : $iconIdle }}"
                    aria-hidden="true">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                {{ __('Clients') }}
            </a>

            <a href="{{ route('demandes.index') }}"
                class="{{ $linkBase }} {{ $isActive('demandes*') ? $linkActive : $linkIdle }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                    stroke-linejoin="round" class="h-4 w-4 {{ $isActive('demandes*') ? $iconActive : $iconIdle }}"
                    aria-hidden="true">
                    <polyline points="20 12 20 22 4 22 4 12" />
                    <rect x="2" y="7" width="20" height="5" />
                    <line x1="12" y1="22" x2="12" y2="7" />
                    <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z" />
                    <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z" />
                </svg>
                {{ __('Demandes') }}
            </a>

            <a href="{{ route('messaging.index') }}"
                class="{{ $linkBase }} {{ $isActive('messaging*') ? $linkActive : $linkIdle }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                    stroke-linejoin="round" class="h-4 w-4 {{ $isActive('messaging*') ? $iconActive : $iconIdle }}"
                    aria-hidden="true">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                </svg>
                {{ __('Notifier') }}
            </a>




        </div>

        {{-- Right cluster --}}
        <div class="flex flex-1 items-center justify-end gap-2">

            {{-- Notifications --}}
            <div x-data="{
                open: false,
                unread: 0,
                items: [],
                loading: false,
                loadingMore: false,
                hasMore: false,
                page: 1,
                csrfToken: document.querySelector('meta[name=csrf-token]')?.content ?? '',

                async fetchNotifs(append = false) {
                    if (append) { this.loadingMore = true; } else {
                        this.loading = true;
                        this.page = 1;
                    }

                    try {
                        const r = await fetch('{{ route('notifications.index') }}?page=' + this.page, {
                            headers: { 'Accept': 'application/json' }
                        });
                        const d = await r.json();
                        if (append) {
                            this.items = [...this.items, ...(d.items ?? [])];
                        } else {
                            this.items = d.items ?? [];
                            this.unread = d.unread ?? 0;
                        }
                        this.hasMore = d.has_more ?? false;
                    } finally {
                        this.loading = false;
                        this.loadingMore = false;
                    }
                },

                async loadMore() {
                    if (this.loadingMore || !this.hasMore) return;
                    this.page++;
                    await this.fetchNotifs(true);
                },

                async markRead() {
                    await fetch('{{ route('notifications.markRead') }}', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': this.csrfToken, 'Accept': 'application/json' }
                    });
                    this.unread = 0;
                    this.items = this.items.map(n => ({ ...n, read: true }));
                },

                async markOne(id) {
                    await fetch('/notifications/' + id + '/read', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': this.csrfToken, 'Accept': 'application/json' }
                    });
                    this.items = this.items.map(n => n.id == id ? { ...n, read: true } : n);
                    this.unread = Math.max(0, this.unread - 1);
                },

                onScroll(el) {
                    if (el.scrollHeight - el.scrollTop - el.clientHeight < 100) this.loadMore();
                },

                init() {
                    this.fetchNotifs();
                    @auth
                    if (window.Echo) {
                        window.Echo.private('App.Models.User.{{ auth()->id() }}')
                            .notification((notif) => {
                                const alreadyExists = this.items.some(i => i.id === notif.id);
                                if (!alreadyExists) {
                                    this.unread++;
                                    this.items.unshift({
                                        id: notif.id ?? ('rt-' + Date.now()),
                                        data: notif,
                                        read: false,
                                        created_at: 'À l\'instant',
                                    });
                                }
                            });
                    }
                    @endauth
                }
            }" x-init="init()" class="relative" @click.outside="open = false">
                {{-- Bell button --}}
                <button type="button" aria-label="Notifications" @click="open = !open; if (open) fetchNotifs()"
                    class="relative inline-grid h-9 w-9 place-items-center rounded-full text-slate-500 hover:bg-slate-100 transition">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round" class="h-[18px] w-[18px]" aria-hidden="true">
                        <path d="M18 8a6 6 0 1 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9" />
                        <path d="M13.7 21a2 2 0 0 1-3.4 0" />
                    </svg>
                    <span x-show="unread > 0" x-text="unread > 9 ? '9+' : unread"
                        class="absolute -right-0.5 -top-0.5 grid h-4 min-w-[16px] place-items-center rounded-full bg-pcc-yellow px-1 text-[10px] font-black leading-none text-[#101820]">
                    </span>
                </button>

                {{-- Dropdown panel --}}
                <div x-show="open" x-transition
                    class="absolute right-0 top-11 z-50 w-80 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl">
                    {{-- Header --}}
                    <div class="flex items-center justify-between border-b border-slate-100 px-4 py-3">
                        <span class="text-[13px] font-bold text-slate-800">
                            Notifications
                            <span x-show="unread > 0"
                                class="ml-1.5 inline-flex h-5 min-w-[20px] items-center justify-center rounded-full bg-pcc-yellow px-1.5 text-[10px] font-black text-[#101820]"
                                x-text="unread"></span>
                        </span>
                        <button @click="markRead()"
                            class="text-[11px] font-semibold text-slate-400 hover:text-slate-600 transition">
                            {{ __('notifications.mark_all_read') }}
                        </button>
                    </div>

                    {{-- List --}}
                    <div class="max-h-[360px] overflow-y-auto divide-y divide-slate-100"
                        @scroll="onScroll($event.target)">

                        <template x-if="loading">
                            <div class="flex items-center justify-center py-8 text-[12px] text-slate-400">
                                <svg class="mr-2 h-4 w-4 animate-spin text-slate-300" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                                </svg>
                                Chargement…
                            </div>
                        </template>

                        <template x-if="!loading && items.length === 0">
                            <div class="flex flex-col items-center gap-2 py-10">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.4"
                                    class="h-8 w-8">
                                    <path d="M18 8a6 6 0 1 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9" />
                                    <path d="M13.7 21a2 2 0 0 1-3.4 0" />
                                </svg>
                                <span class="text-[12px] text-slate-400">{{ __('notifications.empty') }}</span>
                            </div>
                        </template>

                        <template x-for="n in items" :key="n.id">
                            <a :href="n.data.url ?? '#'"
                                @click.prevent="markOne(n.id); if (n.data.url) window.location.href = n.data.url"
                                class="flex items-start gap-3 px-4 py-3 transition-colors"
                                :class="n.read ?
                                    'bg-white hover:bg-slate-50' :
                                    'bg-amber-50 border-l-4 border-l-pcc-yellow hover:bg-amber-100'">
                                {{-- Icon --}}
                                <span
                                    class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full transition-colors"
                                    :class="n.read ? 'bg-slate-100 text-slate-400' : 'bg-pcc-yellow/25 text-amber-600'">
                                    <template x-if="n.data.type === 'new_bonus_request'">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" class="h-4 w-4">
                                            <polyline points="20 12 20 22 4 22 4 12" />
                                            <rect x="2" y="7" width="20" height="5" />
                                            <line x1="12" y1="22" x2="12" y2="7" />
                                            <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z" />
                                            <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z" />
                                        </svg>
                                    </template>
                                    <template x-if="n.data.type === 'campaign_processed'">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"
                                            fill="currentColor" class="h-4 w-4">
                                            <path
                                                d="M568.4 37.7C578.2 34.2 589 36.7 596.4 44C603.8 51.3 606.2 62.2 602.7 72L424.7 568.9C419.7 582.8 406.6 592 391.9 592C377.7 592 364.9 583.4 359.6 570.3L295.4 412.3C290.9 401.3 292.9 388.7 300.6 379.7L395.1 267.3C400.2 261.2 399.8 252.3 394.2 246.7C388.6 241.1 379.6 240.7 373.6 245.8L261.2 340.1C252.1 347.7 239.6 349.7 228.6 345.3L70.1 280.8C57 275.5 48.4 262.7 48.4 248.5C48.4 233.8 57.6 220.7 71.5 215.7L568.4 37.7z" />
                                        </svg>
                                    </template>
                                    <template
                                        x-if="n.data.type !== 'new_bonus_request' && n.data.type !== 'campaign_processed'">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" class="h-4 w-4">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                            <circle cx="9" cy="7" r="4" />
                                            <line x1="19" y1="8" x2="19" y2="14" />
                                            <line x1="22" y1="11" x2="16" y2="11" />
                                        </svg>
                                    </template>
                                </span>
                                {{-- Text --}}
                                <div class="flex-1 min-w-0">
                                    <p class="text-[12.5px] truncate transition-colors"
                                        :class="n.read ? 'font-medium text-slate-600' : 'font-bold text-slate-900'"
                                        x-text="n.data.message"></p>
                                    <p class="text-[11px] mt-0.5 transition-colors"
                                        :class="n.read ? 'text-slate-400' : 'text-amber-600 font-medium'"
                                        x-text="n.created_at"></p>
                                </div>
                                {{-- Unread badge --}}
                                <span x-show="!n.read"
                                    class="mt-2 h-2 w-2 shrink-0 rounded-full bg-pcc-yellow ring-2 ring-amber-200"></span>
                            </a>
                        </template>

                        {{-- Load-more spinner --}}
                        <template x-if="loadingMore">
                            <div class="flex items-center justify-center py-3 text-[11px] text-slate-400">
                                <svg class="mr-1.5 h-3.5 w-3.5 animate-spin text-slate-300" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                                </svg>
                                Chargement…
                            </div>
                        </template>

                    </div>

                    {{-- Footer --}}
                    <div class="border-t border-slate-100 px-4 py-2.5">
                        <a href="{{ route('notifications.all') }}"
                            class="flex items-center justify-center gap-1 text-[12px] font-semibold text-slate-500 hover:text-slate-800 transition">
                            {{ __('notifications.view_all') }}
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Profile --}}
            <x-dropdown align="right" width="56">
                <x-slot name="trigger">
                    <button type="button"
                        class="flex items-center gap-2 rounded-full py-1 pl-1 pr-3 bg-slate-100 transition">
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
                    @php
                        $currentLocale = app()->getLocale();
                    @endphp


                    {{-- Nav items --}}
                    <div class="px-2 py-2 space-y-0.5">

                        {{-- Configuration --}}
                        <a href="{{ route('config.profile') }}"
                            class="{{ $linkBase }} {{ $isActive('config*') ? $linkActive : $linkIdle }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="h-4 w-4 {{ $isActive('config*') ? $iconActive : $iconIdle }}"
                                aria-hidden="true">
                                <circle cx="12" cy="12" r="3" />
                                <path
                                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />
                            </svg>
                            {{ __('nav.configuration') }}
                        </a>


                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            {{-- API Tokens --}}
                            <a href="{{ route('api-tokens.index') }}"
                                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-[13px] font-semibold text-slate-600 hover:bg-slate-100 transition">
                                <span
                                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-500">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                        class="h-3.5 w-3.5">
                                        <path
                                            d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4" />
                                    </svg>
                                </span>
                                API Tokens
                            </a>
                        @endif

                        {{-- Language accordion --}}
                        @php
                            $langsMeta = [
                                'en' => [
                                    'code' => 'EN',
                                    'name' => 'English',
                                    'flag' => 'https://loupiot.zyfed.fr/assets/img/countries/english.png',
                                ],
                                'fr' => [
                                    'code' => 'FR',
                                    'name' => 'Français',
                                    'flag' => 'https://loupiot.zyfed.fr/assets/img/countries/french.png',
                                ],
                            ];
                            $activeLangFlag = $langsMeta[$currentLocale]['flag'] ?? $langsMeta['en']['flag'];
                            $activeLangCode = strtoupper($currentLocale);
                        @endphp

                        {{-- Hidden locale forms --}}
                        @foreach ($langsMeta as $locale => $lang)
                            <form method="POST" action="{{ route('locale.switch', $locale) }}"
                                id="locale-form-{{ $locale }}" style="display:none;">
                                @csrf
                            </form>
                        @endforeach

                        {{-- Language selector --}}
                        <div x-data="{ open: false }" @click.outside="open = false" class="relative" @click.stop>
                            <button type="button" @click.stop="open = !open"
                                class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-[13px] font-semibold text-slate-700 hover:bg-slate-100 transition">
                                {{-- Current flag --}}
                                <span
                                    class="flex h-5 w-5 shrink-0 items-center justify-center overflow-hidden rounded border border-slate-200 bg-slate-100">
                                    <img src="{{ $activeLangFlag }}" alt="{{ $activeLangCode }}"
                                        class="h-full w-full object-cover">
                                </span>
                                {{ __('nav.language') }}
                                <span class="ml-auto flex items-center gap-1.5">
                                    <span
                                        class="rounded-md bg-slate-100 px-1.5 py-0.5 text-[11px] font-bold text-slate-500">{{ $activeLangCode }}</span>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        class="h-3 w-3 text-slate-400 transition-transform duration-200"
                                        :class="open ? 'rotate-180' : ''">
                                        <path d="m6 9 6 6 6-6" />
                                    </svg>
                                </span>
                            </button>

                            <div x-show="open" x-transition x-cloak
                                class="mt-1 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg">
                                @foreach ($langsMeta as $locale => $lang)
                                    <button type="button"
                                        @click.stop="document.getElementById('locale-form-{{ $locale }}').submit()"
                                        class="flex w-full items-center gap-3 px-3 py-2.5 text-[13px] transition-colors {{ $currentLocale === $locale ? 'bg-indigo-50' : 'hover:bg-slate-50' }}">
                                        {{-- Flag --}}
                                        <span
                                            class="flex h-5 w-5 shrink-0 overflow-hidden rounded border border-slate-200">
                                            <img src="{{ $lang['flag'] }}" alt="{{ $lang['code'] }}"
                                                class="h-full w-full object-cover">
                                        </span>
                                        <span
                                            class="flex-1 text-left font-semibold {{ $currentLocale === $locale ? 'text-indigo-700' : 'text-slate-700' }}">{{ $lang['name'] }}</span>
                                        <span
                                            class="text-[11px] font-bold {{ $currentLocale === $locale ? 'text-indigo-400' : 'text-slate-400' }}">{{ $lang['code'] }}</span>
                                        @if ($currentLocale === $locale)
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2.5" class="h-3.5 w-3.5 text-indigo-500">
                                                <path d="m5 12 5 5L20 7" />
                                            </svg>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    {{-- Logout --}}
                    <div class="border-t border-slate-100 px-2 py-2">
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <button type="button" @click="$root.submit()"
                                class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-[13px] font-semibold text-red-500 hover:bg-red-50 transition">
                                <span
                                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-400">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                        class="h-3.5 w-3.5">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                        <polyline points="16 17 21 12 16 7" />
                                        <line x1="21" y1="12" x2="9" y2="12" />
                                    </svg>
                                </span>
                                {{ __('nav.logout') }}
                            </button>
                        </form>
                    </div>
                </x-slot>
            </x-dropdown>

            {{-- Mobile hamburger --}}
            <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Menu"
                class="inline-grid h-9 w-9 place-items-center rounded-full text-slate-500 hover:bg-slate-100 transition lg:hidden">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" class="h-5 w-5">
                    <path d="M3 6h18M3 12h18M3 18h18" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="mobileMenuOpen" x-cloak x-transition class="border-t border-slate-100 bg-white px-4 py-3 lg:hidden">
        <div class="flex flex-col gap-1">

            <a href="{{ route('dashboard') }}"
                class="{{ $linkBase }} {{ $isActive('dashboard') ? $linkActive : $linkIdle }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                    stroke-linecap="round" stroke-linejoin="round"
                    class="h-4 w-4 {{ $isActive('dashboard') ? $iconActive : $iconIdle }}">
                    <path d="M3 11l9-8 9 8" />
                    <path d="M5 10v10h14V10" />
                    <path d="M9 20v-6h6v6" />
                </svg>
                {{ __('nav.dashboard') }}
            </a>

            <a href="{{ route('kpis.index') }}"
                class="{{ $linkBase }} {{ $isActive('kpis*') ? $linkActive : $linkIdle }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                    stroke-linecap="round" stroke-linejoin="round"
                    class="h-4 w-4 {{ $isActive('kpis*') ? $iconActive : $iconIdle }}">
                    <line x1="18" y1="20" x2="18" y2="10" />
                    <line x1="12" y1="20" x2="12" y2="4" />
                    <line x1="6" y1="20" x2="6" y2="14" />
                </svg>
                {{ __('nav.kpis') }}
            </a>

            <a href="{{ route('clients') }}"
                class="{{ $linkBase }} {{ $isActive('clients*') ? $linkActive : $linkIdle }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                    stroke-linecap="round" stroke-linejoin="round"
                    class="h-4 w-4 {{ $isActive('clients*') ? $iconActive : $iconIdle }}">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                {{ __('nav.clients') }}
            </a>

            <a href="{{ route('demandes.index') }}"
                class="{{ $linkBase }} {{ $isActive('demandes*') ? $linkActive : $linkIdle }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                    stroke-linecap="round" stroke-linejoin="round"
                    class="h-4 w-4 {{ $isActive('demandes*') ? $iconActive : $iconIdle }}">
                    <polyline points="20 12 20 22 4 22 4 12" />
                    <rect x="2" y="7" width="20" height="5" />
                    <line x1="12" y1="22" x2="12" y2="7" />
                    <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z" />
                    <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z" />
                </svg>
                {{ __('nav.demandes') }}
            </a>

            <a href="{{ route('messaging.index') }}"
                class="{{ $linkBase }} {{ $isActive('messaging*') ? $linkActive : $linkIdle }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                    stroke-linecap="round" stroke-linejoin="round"
                    class="h-4 w-4 {{ $isActive('messaging*') ? $iconActive : $iconIdle }}">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                </svg>
                {{ __('nav.notifier') }}
            </a>

        </div>
    </div>
</nav>
