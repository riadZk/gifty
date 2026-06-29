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
                Dashboard
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
                KPIs
            </a>

            <a href="{{ route('clients') }}"
                class="{{ $linkBase }} {{ $isActive('clients*') ? $linkActive : $linkIdle }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                    stroke-linejoin="round" class="h-4 w-4 {{ $isActive('clients*') ? $iconActive : $iconIdle }}"
                    aria-hidden="true">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                Clients
            </a>

            {{-- <a href="{{ route('loyalty.index') }}"
                class="{{ $linkBase }} {{ $isActive('loyalty*') ? $linkActive : $linkIdle }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"
                    class="h-4 w-4 {{ $isActive('loyalty*') ? $iconActive : $iconIdle }}" fill="currentColor"
                    aria-hidden="true">
                    <path
                        d="M385.5 132.8C393.1 119.9 406.9 112 421.8 112L424 112C446.1 112 464 129.9 464 152C464 174.1 446.1 192 424 192L350.7 192L385.5 132.8zM254.5 132.8L289.3 192L216 192C193.9 192 176 174.1 176 152C176 129.9 193.9 112 216 112L218.2 112C233.1 112 247 119.9 254.5 132.8zM344.1 108.5L320 149.5L295.9 108.5C279.7 80.9 250.1 64 218.2 64L216 64C167.4 64 128 103.4 128 152C128 166.4 131.5 180 137.6 192L96 192C78.3 192 64 206.3 64 224L64 256C64 273.7 78.3 288 96 288L544 288C561.7 288 576 273.7 576 256L576 224C576 206.3 561.7 192 544 192L502.4 192C508.5 180 512 166.4 512 152C512 103.4 472.6 64 424 64L421.8 64C389.9 64 360.3 80.9 344.1 108.4zM544 336L344 336L344 544L480 544C515.3 544 544 515.3 544 480L544 336zM296 336L96 336L96 480C96 515.3 124.7 544 160 544L296 544L296 336z" />
                </svg>
                Loyalty Settings
            </a> --}}

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
                Demandes
            </a>

            <a href="{{ route('messaging.index') }}"
                class="{{ $linkBase }} {{ $isActive('messaging*') ? $linkActive : $linkIdle }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                    stroke-linejoin="round" class="h-4 w-4 {{ $isActive('messaging*') ? $iconActive : $iconIdle }}"
                    aria-hidden="true">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                </svg>
                Notifier
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
                                this.unread++;
                                this.items.unshift({
                                    id: notif.id ?? ('rt-' + Date.now()),
                                    data: notif,
                                    read: false,
                                    created_at: 'À l\'instant',
                                });
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
                            Tout marquer lu
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
                                <span class="text-[12px] text-slate-400">Aucune notification</span>
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
                                    <template x-if="n.data.type !== 'new_bonus_request'">
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
                            Voir toutes les notifications
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
                        $localeLabels = ['en' => 'EN', 'fr' => 'FR', 'ar' => 'AR'];
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
                            Configuration
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
                        <div x-data="{ open: false }" @click.stop>
                            <button type="button" @click.stop="open = !open"
                                class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-[13px] font-semibold text-slate-600 hover:bg-slate-100 transition">
                                <span
                                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-500">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                        class="h-3.5 w-3.5">
                                        <circle cx="12" cy="12" r="10" />
                                        <path
                                            d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                                    </svg>
                                </span>
                                Language
                                <span class="ml-auto flex items-center gap-1.5">
                                    <span
                                        class="rounded-md bg-slate-100 px-1.5 py-0.5 text-[11px] font-bold text-slate-500">
                                        {{ strtoupper($currentLocale) }}
                                    </span>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        class="h-3 w-3 text-slate-400 transition-transform duration-200"
                                        :class="open ? 'rotate-180' : ''">
                                        <path d="m6 9 6 6 6-6" />
                                    </svg>
                                </span>
                            </button>

                            <div x-show="open" x-transition
                                class="mt-1 overflow-hidden rounded-xl border border-slate-200 bg-white">
                                @php
                                    $langs = [
                                        'en' => ['code' => 'EN', 'name' => 'English'],
                                        'fr' => ['code' => 'FR', 'name' => 'Français'],
                                        'ar' => ['code' => 'AR', 'name' => 'العربية'],
                                    ];
                                @endphp
                                @foreach ($langs as $locale => $lang)
                                    <button type="button"
                                        @click.stop="fetch('{{ url('/locale') }}/{{ $locale }}', {
                                            method: 'POST',
                                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                                        }).then(() => window.location.reload())"
                                        class="flex w-full items-center gap-3 px-3 py-2.5 text-[12.5px] transition-colors {{ $currentLocale === $locale ? 'bg-blue-500 text-white font-semibold' : 'text-slate-700 hover:bg-slate-50' }}">
                                        <span
                                            class="w-7 shrink-0 text-left text-[11px] font-bold {{ $currentLocale === $locale ? 'text-blue-200' : 'text-slate-400' }}">{{ $lang['code'] }}</span>
                                        <span class="flex-1 text-left">{{ $lang['name'] }}</span>
                                        @if ($currentLocale === $locale)
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2.5" class="h-3.5 w-3.5 text-white">
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
                                Log Out
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
                class="{{ $linkBase }} {{ $isActive('dashboard') ? $linkActive : $linkIdle }}">Dashboard</a>
            <a href="#" class="{{ $linkBase }} {{ $linkIdle }}">Opérations</a>
            <a href="#" class="{{ $linkBase }} {{ $linkIdle }}">Envois</a>
            <a href="#" class="{{ $linkBase }} {{ $linkIdle }}">Clients</a>
            <a href="#" class="{{ $linkBase }} {{ $linkIdle }}">Map</a>
            <a href="#" class="{{ $linkBase }} {{ $linkIdle }}">Calendar</a>
            <a href="{{ route('profile.show') }}"
                class="{{ $linkBase }} {{ $linkIdle }}">Administration</a>
        </div>
    </div>
</nav>
