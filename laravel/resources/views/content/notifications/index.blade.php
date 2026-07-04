<x-app-layout>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        function openNotif(markUrl, destUrl) {
            fetch(markUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json',
                },
            }).finally(() => {
                if (destUrl) window.location.href = destUrl;
            });
        }
    </script>

    <style>
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(12px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .au {
            animation: fadeUp .35s ease both;
        }

        .d1 {
            animation-delay: .04s
        }

        .d2 {
            animation-delay: .08s
        }

        .d3 {
            animation-delay: .13s
        }
    </style>

    @php
        $typeCfg = [
            'new_bonus_request' => [
                __('notifications.type_bonus'),
                'bg-violet-100 text-violet-700',
                'bg-violet-100',
                '#7c3aed',
            ],
            'new_client_registered' => [
                __('notifications.type_client'),
                'bg-blue-100 text-blue-700',
                'bg-blue-100',
                '#2563eb',
            ],
            'campaign_processed' => [
                __('notifications.type_campaign'),
                'bg-amber-100 text-amber-700',
                'bg-amber-100',
                '#d97706',
            ],
        ];
    @endphp

    <div class="flex flex-col gap-5">

        {{-- ── Header ── --}}
        <div class="au flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-[22px] font-black tracking-tight text-slate-900 leading-tight">
                    {{ __('notifications.title') }}</h1>
                <p class="text-[12.5px] text-slate-400 mt-0.5">
                    {{ trans_choice('notifications.count', $notifications->total()) }}
                    @if ($unreadCount > 0)
                        &nbsp;·&nbsp;<span
                            class="font-bold text-amber-500">{{ trans_choice('notifications.unread_count', $unreadCount) }}</span>
                    @endif
                </p>
            </div>
            @if ($unreadCount > 0)
                <form method="POST" action="{{ route('notifications.markRead') }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-[12.5px] font-bold text-white shadow-sm hover:bg-slate-700 transition-all active:scale-95">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                            class="h-3.5 w-3.5">
                            <path d="M20 6 9 17l-5-5" />
                        </svg>
                        {{ __('notifications.mark_all_read') }}
                    </button>
                </form>
            @endif
        </div>

        {{-- ── Filters ── --}}
        <div class="au d1">
            <form method="GET" action="{{ route('notifications.all') }}">
                <div
                    class="flex flex-wrap items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm">

                    {{-- Filter icon label --}}
                    <div class="flex items-center gap-2 pr-3 border-r border-slate-100 mr-1">
                        <div class="grid h-7 w-7 place-items-center rounded-lg bg-slate-100">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"
                                class="h-3.5 w-3.5">
                                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" />
                            </svg>
                        </div>
                        <span
                            class="text-[12px] font-bold text-slate-500 whitespace-nowrap">{{ __('notifications.filters') }}</span>
                    </div>

                    {{-- Status chips --}}
                    <div class="flex items-center gap-1.5">
                        @foreach (['' => __('notifications.filter_all'), 'unread' => __('notifications.filter_unread'), 'read' => __('notifications.filter_read')] as $val => $lbl)
                            <a href="{{ request()->fullUrlWithQuery(['status' => $val ?: null]) }}"
                                class="inline-flex items-center gap-1.5 rounded-xl px-3 py-1.5 text-[11.5px] font-bold transition-all
                        {{ request('status', '') === $val
                            ? 'bg-slate-900 text-white shadow-sm'
                            : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}">
                                @if ($val === 'unread')
                                    <span
                                        class="h-1.5 w-1.5 rounded-full {{ request('status') === 'unread' ? 'bg-amber-400' : 'bg-slate-400' }}"></span>
                                @elseif($val === 'read')
                                    <span
                                        class="h-1.5 w-1.5 rounded-full {{ request('status') === 'read' ? 'bg-emerald-400' : 'bg-slate-400' }}"></span>
                                @endif
                                {{ $lbl }}
                            </a>
                        @endforeach
                    </div>

                    <div class="h-5 w-px bg-slate-100 mx-1"></div>

                    {{-- Date range --}}
                    <div class="flex items-center gap-2">
                        <div class="relative">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8"
                                class="pointer-events-none absolute left-2.5 top-1/2 h-3.5 w-3.5 -translate-y-1/2">
                                <rect x="3" y="4" width="18" height="18" rx="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                            <x-datepicker id="date_from" name="date_from" placeholder="Du…" :value="request('date_from')"
                                dateFormat="Y-m-d" style="border: 1px solid;"
                                class="!h-8 !w-32 !pl-8 !pr-2 !text-[12px] !rounded-xl !border-slate-200 !bg-slate-50" />
                        </div>
                        <span class="text-[11px] font-semibold text-slate-300">→</span>
                        <div class="relative">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8"
                                class="pointer-events-none absolute left-2.5 top-1/2 h-3.5 w-3.5 -translate-y-1/2">
                                <rect x="3" y="4" width="18" height="18" rx="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                            <x-datepicker id="date_to" name="date_to" placeholder="Au…" :value="request('date_to')"
                                dateFormat="Y-m-d" style="border: 1px solid;"
                                class="!h-8 !w-32 !pl-8 !pr-2 !text-[12px] !rounded-xl !border-slate-200 !bg-slate-50" />
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 ml-auto">
                        @if (request()->hasAny(['status', 'date_from', 'date_to']))
                            <a href="{{ route('notifications.all') }}"
                                class="inline-flex h-8 items-center gap-1.5 rounded-xl px-3 text-[11.5px] font-semibold text-slate-400 hover:text-slate-600 transition">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    class="h-3 w-3">
                                    <path d="M18 6 6 18M6 6l12 12" />
                                </svg>
                                {{ __('notifications.clear') }}
                            </a>
                        @endif
                        <button type="submit"
                            class="inline-flex h-8 items-center gap-1.5 rounded-xl bg-slate-900 px-4 text-[11.5px] font-bold text-white hover:bg-slate-700 active:scale-95 transition-all">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                class="h-3 w-3">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.35-4.35" />
                            </svg>
                            {{ __('notifications.apply') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- ── List ── --}}
        <div class="au d2 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            @forelse ($notifications as $i => $n)
                @php
                    $isRead = !is_null($n->read_at);
                    $data = is_array($n->data) ? $n->data : (array) $n->data;
                    $type = $data['type'] ?? '';
                    [$typeLabel, $typeBadge, $iconBg, $iconColor] = $typeCfg[$type] ?? [
                        __('notifications.type_system'),
                        'bg-slate-100 text-slate-500',
                        'bg-slate-100',
                        '#64748b',
                    ];
                    $url = $data['url'] ?? null;
                @endphp

                <div class="group relative {{ !$loop->last ? 'border-b border-slate-100' : '' }}"
                    style="{{ !$isRead ? 'background:#fffbf0a1;' : '' }} animation:fadeUp .3s ease {{ $i * 0.04 }}s both;">

                    {{-- Unread left bar --}}
                    @if (!$isRead)
                        <div class="absolute inset-y-0 left-0 w-[3px] rounded-r bg-amber-400"></div>
                    @endif

                    <div class="flex items-center gap-3 px-5 py-3 {{ !$isRead || $url ? 'cursor-pointer' : '' }} hover:bg-slate-50/70 transition-colors"
                        onclick="openNotif('{{ route('notifications.markSingle', $n->id) }}', '{{ $url }}')">

                        {{-- Icon --}}
                        <div class="grid h-9 w-9 shrink-0 place-items-center rounded-xl {{ $iconBg }}">
                            @if ($type === 'new_bonus_request')
                                <svg viewBox="0 0 24 24" fill="none" stroke="{{ $iconColor }}"
                                    stroke-width="1.9" class="h-4 w-4">
                                    <polyline points="20 12 20 22 4 22 4 12" />
                                    <rect x="2" y="7" width="20" height="5" />
                                    <line x1="12" y1="22" x2="12" y2="7" />
                                    <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z" />
                                    <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z" />
                                </svg>
                            @elseif($type === 'new_client_registered')
                                <svg viewBox="0 0 24 24" fill="none" stroke="{{ $iconColor }}"
                                    stroke-width="1.9" class="h-4 w-4">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                    <line x1="19" y1="8" x2="19" y2="14" />
                                    <line x1="22" y1="11" x2="16" y2="11" />
                                </svg>
                            @elseif($type === 'campaign_processed')
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"
                                    fill="{{ $iconColor }}" class="h-4 w-4">
                                    <path
                                        d="M568.4 37.7C578.2 34.2 589 36.7 596.4 44C603.8 51.3 606.2 62.2 602.7 72L424.7 568.9C419.7 582.8 406.6 592 391.9 592C377.7 592 364.9 583.4 359.6 570.3L295.4 412.3C290.9 401.3 292.9 388.7 300.6 379.7L395.1 267.3C400.2 261.2 399.8 252.3 394.2 246.7C388.6 241.1 379.6 240.7 373.6 245.8L261.2 340.1C252.1 347.7 239.6 349.7 228.6 345.3L70.1 280.8C57 275.5 48.4 262.7 48.4 248.5C48.4 233.8 57.6 220.7 71.5 215.7L568.4 37.7z" />
                                </svg>
                            @else
                                <svg viewBox="0 0 24 24" fill="none" stroke="{{ $iconColor }}"
                                    stroke-width="1.9" class="h-4 w-4">
                                    <path d="M18 8a6 6 0 1 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9" />
                                    <path d="M13.7 21a2 2 0 0 1-3.4 0" />
                                </svg>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-0.5">
                                <span
                                    class="inline-flex items-center rounded-md px-2 py-0.5 text-[10px] font-bold {{ $typeBadge }}">
                                    {{ $typeLabel }}
                                </span>
                                @if (!$isRead)
                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-400 shrink-0"></span>
                                @endif
                            </div>
                            <p
                                class="text-[12.5px] leading-snug truncate {{ $isRead ? 'text-slate-500' : 'font-semibold text-slate-800' }}">
                                {{ $data['message'] ?? __('notifications.fallback') }}
                            </p>
                            @if (!empty($data['description']))
                                <p class="text-[11.5px] text-slate-400 truncate">{{ $data['description'] }}</p>
                            @endif
                        </div>

                        {{-- Right: time + arrow --}}
                        <div class="shrink-0 flex flex-col items-end gap-1 ml-1">
                            <span
                                class="text-[11px] {{ $isRead ? 'text-slate-400' : 'text-amber-500 font-semibold' }} whitespace-nowrap">
                                {{ $n->created_at->diffForHumans() }}
                            </span>
                            @if ($url)
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    class="h-3.5 w-3.5 text-slate-300 group-hover:text-slate-500 transition-colors">
                                    <path d="M5 12h14M12 5l7 7-7 7" />
                                </svg>
                            @endif
                        </div>
                    </div>
                </div>

            @empty
                <div class="flex flex-col items-center gap-3 py-20">
                    <div class="grid h-14 w-14 place-items-center rounded-2xl bg-slate-100">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.4"
                            class="h-7 w-7">
                            <path d="M18 8a6 6 0 1 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9" />
                            <path d="M13.7 21a2 2 0 0 1-3.4 0" />
                        </svg>
                    </div>
                    <p class="text-[13.5px] font-bold text-slate-400">{{ __('notifications.not_found') }}</p>
                    @if (request()->hasAny(['status', 'date_from', 'date_to']))
                        <a href="{{ route('notifications.all') }}"
                            class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 px-4 py-2 text-[12px] font-semibold text-slate-500 hover:bg-slate-50 transition">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                class="h-3.5 w-3.5">
                                <path d="M18 6 6 18M6 6l12 12" />
                            </svg>
                            {{ __('notifications.reset_filters') }}
                        </a>
                    @endif
                </div>
            @endforelse
        </div>

        {{-- ── Pagination ── --}}
        @if ($notifications->hasPages())
            <div class="au d3 flex items-center justify-between text-[12px] text-slate-500">
                <span>
                    {{ __('notifications.page_info', ['current' => $notifications->currentPage(), 'last' => $notifications->lastPage()]) }}
                    &nbsp;·&nbsp;{{ trans_choice('notifications.results', $notifications->total()) }}
                </span>
                <div class="flex items-center gap-1">
                    @if ($notifications->onFirstPage())
                        <span
                            class="inline-flex h-8 w-8 items-center justify-center rounded-xl border border-slate-200 text-slate-300 cursor-not-allowed">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                class="h-3.5 w-3.5">
                                <path d="m15 18-6-6 6-6" />
                            </svg>
                        </span>
                    @else
                        <a href="{{ $notifications->previousPageUrl() }}"
                            class="inline-flex h-8 w-8 items-center justify-center rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-50 transition">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                class="h-3.5 w-3.5">
                                <path d="m15 18-6-6 6-6" />
                            </svg>
                        </a>
                    @endif

                    @foreach ($notifications->getUrlRange(max(1, $notifications->currentPage() - 2), min($notifications->lastPage(), $notifications->currentPage() + 2)) as $page => $url)
                        <a href="{{ $url }}"
                            class="inline-flex h-8 min-w-[32px] items-center justify-center rounded-xl border px-2 font-bold transition
                    {{ $page === $notifications->currentPage() ? 'border-slate-900 bg-slate-900 text-white' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                            {{ $page }}
                        </a>
                    @endforeach

                    @if ($notifications->hasMorePages())
                        <a href="{{ $notifications->nextPageUrl() }}"
                            class="inline-flex h-8 w-8 items-center justify-center rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-50 transition">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                class="h-3.5 w-3.5">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </a>
                    @else
                        <span
                            class="inline-flex h-8 w-8 items-center justify-center rounded-xl border border-slate-200 text-slate-300 cursor-not-allowed">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                class="h-3.5 w-3.5">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </span>
                    @endif
                </div>
            </div>
        @endif

    </div>

</x-app-layout>
