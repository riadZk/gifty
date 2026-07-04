<x-app-layout>

    @php
        /* ── Identity ── */
        $initials = strtoupper(mb_substr($client->company_name, 0, 2));

        /* ── Status config ── */
        $statusCfg = [
            'active' => [
                'label' => __('clients.status_active'),
                'cls' => 'bg-emerald-100 text-emerald-700',
                'dot' => 'bg-emerald-500',
            ],
            'inactive' => [
                'label' => __('clients.status_inactive'),
                'cls' => 'bg-amber-100 text-amber-700',
                'dot' => 'bg-amber-400',
            ],
            'blocked' => [
                'label' => __('clients.status_blocked'),
                'cls' => 'bg-red-100 text-red-600',
                'dot' => 'bg-red-500',
            ],
        ];
        $sc = $statusCfg[$client->status] ?? $statusCfg['inactive'];

        /* ── Avatar gradient (deterministic) ── */
        $palette = [
            'linear-gradient(135deg,#34d399,#059669)',
            'linear-gradient(135deg,#38bdf8,#3b82f6)',
            'linear-gradient(135deg,#a78bfa,#8b5cf6)',
            'linear-gradient(135deg,#fb923c,#f97316)',
            'linear-gradient(135deg,#2dd4bf,#06b6d4)',
            'linear-gradient(135deg,#f472b6,#ec4899)',
            'linear-gradient(135deg,#fbbf24,#eab308)',
            'linear-gradient(135deg,#818cf8,#6366f1)',
        ];
        $avatarGrad = $palette[crc32($client->company_name) % count($palette)];

        $pointsBalance = (int) $client->points_balance;
        $totalSales = (float) $client->total_sales;

        /* ── Activity logs (bonus requests) ── */
        $logs = $logs ?? collect();
        $logStatusCfg = [
            'pending' => [
                'label' => __('clients.log_pending'),
                'cls' => 'bg-amber-100 text-amber-700',
                'dot' => 'bg-amber-400',
            ],
            'approved' => [
                'label' => __('clients.log_approved'),
                'cls' => 'bg-emerald-100 text-emerald-700',
                'dot' => 'bg-emerald-500',
            ],
            'rejected' => [
                'label' => __('clients.log_rejected'),
                'cls' => 'bg-red-100 text-red-600',
                'dot' => 'bg-red-500',
            ],
            'delivered' => [
                'label' => __('clients.log_delivered'),
                'cls' => 'bg-blue-100 text-blue-700',
                'dot' => 'bg-blue-500',
            ],
        ];

        /* ── Activity stats (defaults if not provided) ── */
        $statusCounts = $statusCounts ?? ['pending' => 0, 'approved' => 0, 'rejected' => 0, 'delivered' => 0];
        $requestsCount = $requestsCount ?? array_sum($statusCounts);
        $approvedCount = $approvedCount ?? 0;
        $pointsSpent = $pointsSpent ?? 0;
        $pointsEarned = $pointsEarned ?? 0;
        $monthlyLabels = $monthlyLabels ?? [];
        $monthlyData = $monthlyData ?? [];
    @endphp

    {{-- ══ Styles ══ --}}
    <style>
        .seg-wrap {
            display: inline-flex;
            gap: 4px;
            padding: 4px;
            background: #f1f5f9;
            border-radius: 12px;
        }

        .tab-btn {
            border: none;
            background: none;
            color: #64748b;
            font-size: 12.5px;
            font-weight: 600;
            padding: 7px 16px;
            border-radius: 9px;
            cursor: pointer;
            transition: all .15s;
            white-space: nowrap;
        }

        .tab-btn.active {
            background: #fff;
            color: #0f172a;
            box-shadow: 0 1px 2px rgba(15, 23, 42, .08);
        }

        .tab-btn:hover:not(.active) {
            color: #334155;
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
        }
    </style>

    <div class="flex flex-col gap-5">

        {{-- ══ Header ══ --}}
        <div>
            <nav class="flex items-center gap-1.5 text-[11.5px] font-medium text-slate-400">
                <a href="{{ route('clients') }}" class="hover:text-slate-600 transition">Clients</a>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3 w-3">
                    <path d="m9 18 6-6-6-6" />
                </svg>
                <span class="text-slate-600">{{ __('clients.show_title') }}</span>
            </nav>

            <div class="mt-2 flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <a href="{{ route('clients') }}"
                        class="inline-flex h-9 items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 text-[12.5px] font-semibold text-slate-600 shadow-sm transition hover:bg-slate-50">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                        {{ __('clients.btn_back') }}
                    </a>
                    <h1 class="text-[22px] font-black tracking-tight text-slate-900">{{ __('clients.show_title') }}</h1>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <div id="action-buttons" class="flex items-center gap-2" data-status="{{ $client->status }}"
                        data-activate-url="{{ route('clients.activate', $client) }}"
                        data-block-url="{{ route('clients.block', $client) }}"
                        data-unblock-url="{{ route('clients.unblock', $client) }}" data-csrf="{{ csrf_token() }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Flash --}}
        @if (session('success'))
            <div
                class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-[13px] font-semibold text-emerald-700">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 shrink-0">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- ══ Profile card (multi-zone) ══ --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-wrap divide-y divide-slate-100 lg:flex-nowrap lg:divide-x lg:divide-y-0">

                {{-- Zone 1 : Identity --}}
                <div class="flex items-start gap-4 p-6 lg:w-[320px] shrink-0">
                    @php $pictureUrl = $client->getFirstMediaUrl('picture'); @endphp
                    @if ($pictureUrl)
                        <img src="{{ $pictureUrl }}" alt="{{ $client->company_name }}"
                            class="h-14 w-14 shrink-0 rounded-2xl object-cover shadow-md"
                            style="background:{{ $avatarGrad }};">
                    @else
                        <span
                            class="inline-flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl text-[18px] font-black text-white shadow-md"
                            style="background:{{ $avatarGrad }};">{{ $initials }}</span>
                    @endif
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span
                                class="text-[16px] font-black leading-tight text-slate-900">{{ $client->company_name }}</span>
                            <span data-status-badge
                                class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-[11px] font-bold {{ $sc['cls'] }}">
                                <span data-status-dot class="h-1.5 w-1.5 rounded-full {{ $sc['dot'] }}"></span>
                                <span data-status-label>{{ $sc['label'] }}</span>
                            </span>
                        </div>
                        @if ($client->contact_name)
                            <p class="mt-0.5 text-[12px] font-medium text-slate-400">{{ $client->contact_name }}</p>
                        @endif
                        <div class="mt-3 space-y-1.5 text-[12.5px] text-slate-600">
                            <div class="flex items-center gap-2">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                    class="h-3.5 w-3.5 shrink-0 text-slate-400">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
                                </svg>
                                {{ $client->phone ?: '—' }}
                            </div>
                            <div class="flex items-center gap-2">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                    class="h-3.5 w-3.5 shrink-0 text-slate-400">
                                    <path
                                        d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                    <polyline points="22,6 12,13 2,6" />
                                </svg>
                                <span class="truncate">{{ $client->email ?: '—' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Zone 2 : Key details --}}
                <div class="flex-1 p-6">
                    <dl class="grid grid-cols-2 gap-x-8 gap-y-4 text-[13px]">
                        <div>
                            <dt class="text-[10.5px] font-semibold uppercase tracking-wider text-slate-400">
                                {{ __('clients.label_pcc_code') }}
                            </dt>
                            <dd class="mt-1 flex items-center gap-2 font-mono font-semibold text-slate-800">
                                {{ $client->pcc_customer_code ?: '—' }}
                                @if ($client->pcc_customer_code)
                                    <button onclick="navigator.clipboard.writeText('{{ $client->pcc_customer_code }}')"
                                        title="{{ __('clients.btn_copy') }}"
                                        class="text-slate-400 transition hover:text-slate-600">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                            class="h-3.5 w-3.5">
                                            <rect x="9" y="9" width="13" height="13" rx="2" />
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                        </svg>
                                    </button>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-[10.5px] font-semibold uppercase tracking-wider text-slate-400">
                                {{ __('clients.label_member_since') }}</dt>
                            <dd class="mt-1 font-semibold text-slate-800">
                                {{ $client->created_at?->translatedFormat('d M Y') ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-[10.5px] font-semibold uppercase tracking-wider text-slate-400">
                                {{ __('clients.label_validated_on') }}</dt>
                            <dd class="mt-1 font-semibold text-slate-800">
                                {{ $client->accepted_at?->translatedFormat('d M Y') ?? __('clients.pending_validation') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-[10.5px] font-semibold uppercase tracking-wider text-slate-400">
                                {{ __('clients.label_bonus_requests') }}
                            </dt>
                            <dd class="mt-1 font-semibold text-slate-800">{{ $logs->count() }}</dd>
                        </div>
                    </dl>
                </div>

                {{-- Zone 3 : Points summary --}}
                <div class="flex flex-col justify-center gap-1 bg-slate-50/60 p-6 lg:w-[220px] shrink-0">
                    <p class="text-[10.5px] font-semibold uppercase tracking-wider text-slate-400">
                        {{ __('clients.label_points_balance') }}</p>
                    <p class="text-[28px] font-black leading-none text-slate-900">
                        {{ number_format($pointsBalance, 0, ',', ' ') }}
                        <span class="text-[14px] font-semibold text-slate-400">pts</span>
                    </p>
                    <p class="mt-2 text-[12px] font-medium text-slate-500">
                        {{ __('clients.sales_suffix', ['amount' => number_format($totalSales, 0, ',', ' ')]) }}
                    </p>
                </div>
            </div>
        </div>

        {{-- ══ Stat tiles ══ --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            {{-- Points --}}
            <div class="flex items-center gap-3.5 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="1.8" class="h-5 w-5">
                        <polygon
                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                    </svg>
                </span>
                <div>
                    <p class="text-[11px] font-semibold text-slate-400">{{ __('clients.label_points_balance') }}</p>
                    <p class="text-[20px] font-black leading-tight text-slate-900">
                        {{ number_format($pointsBalance, 0, ',', ' ') }} <span
                            class="text-[12px] text-slate-400">pts</span>
                    </p>
                    <p class="text-[10.5px] font-medium text-slate-400">{{ __('clients.tile_points_sub') }}</p>
                </div>
            </div>

            {{-- Total sales --}}
            <div class="flex items-center gap-3.5 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-purple-50">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="1.8" class="h-5 w-5">
                        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                        <line x1="3" y1="6" x2="21" y2="6" />
                        <path d="M16 10a4 4 0 0 1-8 0" />
                    </svg>
                </span>
                <div>
                    <p class="text-[11px] font-semibold text-slate-400">{{ __('clients.tile_sales') }}</p>
                    <p class="text-[20px] font-black leading-tight text-slate-900">
                        {{ number_format($totalSales, 0, ',', ' ') }} <span
                            class="text-[12px] text-slate-400">MAD</span>
                    </p>
                    <p class="text-[10.5px] font-medium text-slate-400">{{ __('clients.tile_sales_sub') }}</p>
                </div>
            </div>

            {{-- Status --}}
            <div class="flex items-center gap-3.5 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="1.8" class="h-5 w-5">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                </span>
                <div>
                    <p class="text-[11px] font-semibold text-slate-400">{{ __('clients.tile_status') }}</p>
                    <p data-status-label class="text-[20px] font-black leading-tight text-slate-900">
                        {{ $sc['label'] }}</p>
                    <p class="text-[10.5px] font-medium text-slate-400">{{ __('clients.tile_status_sub') }}</p>
                </div>
            </div>

            {{-- Member since --}}
            <div class="flex items-center gap-3.5 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-50">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="1.8" class="h-5 w-5">
                        <rect x="3" y="4" width="18" height="18" rx="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                </span>
                <div>
                    <p class="text-[11px] font-semibold text-slate-400">{{ __('clients.tile_member') }}</p>
                    <p class="text-[16px] font-black leading-tight text-slate-900">
                        {{ $client->created_at?->translatedFormat('d M Y') ?? '—' }}
                    </p>
                    <p class="text-[10.5px] font-medium text-slate-400">
                        {{ $client->created_at?->diffForHumans() ?? '—' }}</p>
                </div>
            </div>
        </div>

        {{-- ══ Charts ══ --}}
        <div class="grid gap-5 lg:grid-cols-3">
            {{-- Points overview --}}
            <div class="lg:col-span-2 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-1 flex items-center justify-between">
                    <h3 class="text-[14px] font-bold text-slate-800">{{ __('clients.chart_points_title') }}</h3>
                    <span class="text-[11.5px] font-medium text-slate-400">{{ __('clients.chart_points_sub') }}</span>
                </div>
                <div id="chart-points" class="min-h-[220px]"></div>
            </div>

            {{-- Status breakdown --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h3 class="mb-1 text-[14px] font-bold text-slate-800">{{ __('clients.chart_status_title') }}</h3>
                @if ($requestsCount > 0)
                    <div id="chart-status" class="min-h-[220px]"></div>
                @else
                    <div class="flex h-[220px] flex-col items-center justify-center gap-2 text-center">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.6"
                                class="h-6 w-6">
                                <path d="M21.21 15.89A10 10 0 1 1 8 2.83" />
                                <path d="M22 12A10 10 0 0 0 12 2v10z" />
                            </svg>
                        </span>
                        <p class="text-[12.5px] font-semibold text-slate-500">{{ __('clients.chart_no_data') }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ══ Tabs card ══ --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            {{-- Tab bar --}}
            <div class="overflow-x-auto border-b border-slate-200 px-5 py-4">
                <div class="seg-wrap">
                    <button class="tab-btn active" data-tab="infos">{{ __('clients.tab_info') }}</button>
                    <button class="tab-btn" data-tab="logs">{{ __('clients.tab_activity') }}</button>
                    <button class="tab-btn" data-tab="loyalty">{{ __('clients.tab_loyalty') }}</button>
                </div>
            </div>

            {{-- Pane: Infos --}}
            <div class="tab-pane active p-6" id="tab-infos">
                <dl class="grid grid-cols-1 gap-x-10 gap-y-4 sm:grid-cols-2">
                    @php
                        $rows = [
                            [__('clients.info_company'), $client->company_name],
                            [__('clients.info_contact'), $client->contact_name ?: '—'],
                            [__('clients.info_phone'), $client->phone ?: '—'],
                            [__('clients.info_email'), $client->email ?: '—'],
                            [__('clients.info_pcc_code'), $client->pcc_customer_code ?: '—'],
                            [__('clients.info_member_since'), $client->created_at?->translatedFormat('d F Y') ?? '—'],
                        ];
                    @endphp
                    @foreach ($rows as [$lbl, $val])
                        <div class="flex items-center justify-between gap-4 border-b border-slate-50 pb-3">
                            <dt class="text-[12.5px] font-medium text-slate-400">{{ $lbl }}</dt>
                            <dd class="truncate text-right text-[13px] font-semibold text-slate-800">
                                {{ $val }}</dd>
                        </div>
                    @endforeach
                    <div class="flex items-center justify-between gap-4 border-b border-slate-50 pb-3">
                        <dt class="text-[12.5px] font-medium text-slate-400">{{ __('clients.info_status') }}</dt>
                        <dd>
                            <span data-status-badge
                                class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-[11px] font-bold {{ $sc['cls'] }}">
                                <span data-status-dot class="h-1.5 w-1.5 rounded-full {{ $sc['dot'] }}"></span>
                                <span data-status-label>{{ $sc['label'] }}</span>
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            {{-- Pane: Activity log --}}
            <div class="tab-pane p-6" id="tab-logs">
                @forelse ($logs as $log)
                    @php $ls = $logStatusCfg[$log->status] ?? $logStatusCfg['pending']; @endphp
                    <div class="flex items-start gap-4 border-b border-slate-50 py-3.5 last:border-0">
                        <span class="mt-1 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-100">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="1.8"
                                class="h-4 w-4">
                                <polyline points="20 12 20 22 4 22 4 12" />
                                <rect x="2" y="7" width="20" height="5" />
                                <line x1="12" y1="22" x2="12" y2="7" />
                            </svg>
                        </span>
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span
                                    class="font-mono text-[12.5px] font-bold text-slate-900">{{ $log->demande_key }}</span>
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-[11px] font-bold {{ $ls['cls'] }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $ls['dot'] }}"></span>
                                    {{ $ls['label'] }}
                                </span>
                            </div>
                            <p class="mt-0.5 text-[12.5px] text-slate-500">
                                {{ $log->bonusLevel->name ?? __('clients.log_deleted_level') }}
                                <span class="mx-1 text-slate-300">•</span>
                                {{ number_format((int) $log->points_required, 0, ',', ' ') }}
                                {{ __('clients.log_pts_required') }}
                            </p>
                        </div>
                        <div class="shrink-0 text-right text-[11.5px] font-medium text-slate-400">
                            {{ optional($log->requested_at ?? $log->created_at)->translatedFormat('d M Y') ?? '—' }}
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center gap-2 py-10 text-center">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.6"
                                class="h-6 w-6">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                        </span>
                        <p class="text-[13px] font-semibold text-slate-500">{{ __('clients.log_no_activity') }}</p>
                        <p class="text-[12px] text-slate-400">{{ __('clients.log_no_activity_sub') }}</p>
                    </div>
                @endforelse
            </div>

            {{-- Pane: Loyalty --}}
            <div class="tab-pane p-6" id="tab-loyalty">
                <div class="grid grid-cols-2 gap-4 lg:grid-cols-3">
                    <div class="rounded-xl border border-slate-200 p-4">
                        <p class="text-[11px] font-semibold text-slate-400">{{ __('clients.loyalty_balance') }}</p>
                        <p class="mt-1 text-[22px] font-black text-slate-900">
                            {{ number_format($pointsBalance, 0, ',', ' ') }} <span
                                class="text-[12px] text-slate-400">pts</span></p>
                    </div>
                    <div class="rounded-xl border border-slate-200 p-4">
                        <p class="text-[11px] font-semibold text-slate-400">{{ __('clients.loyalty_sales') }}</p>
                        <p class="mt-1 text-[22px] font-black text-slate-900">
                            {{ number_format($totalSales, 0, ',', ' ') }} <span
                                class="text-[12px] text-slate-400">MAD</span></p>
                    </div>
                    <div class="rounded-xl border border-slate-200 p-4">
                        <p class="text-[11px] font-semibold text-slate-400">{{ __('clients.loyalty_used') }}</p>
                        <p class="mt-1 text-[22px] font-black text-slate-900">
                            {{ number_format((int) $pointsSpent, 0, ',', ' ') }} <span
                                class="text-[12px] text-slate-400">pts</span></p>
                    </div>
                    <div class="rounded-xl border border-slate-200 p-4">
                        <p class="text-[11px] font-semibold text-slate-400">{{ __('clients.loyalty_total_req') }}</p>
                        <p class="mt-1 text-[22px] font-black text-slate-900">{{ $requestsCount }}</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 p-4">
                        <p class="text-[11px] font-semibold text-slate-400">{{ __('clients.loyalty_approved') }}</p>
                        <p class="mt-1 text-[22px] font-black text-emerald-600">{{ $approvedCount }}</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 p-4">
                        <p class="text-[11px] font-semibold text-slate-400">{{ __('clients.loyalty_rate') }}</p>
                        <p class="mt-1 text-[22px] font-black text-slate-900">2 <span
                                class="text-[12px] text-slate-400">{{ __('clients.loyalty_rate_sub') }}</span></p>
                    </div>
                </div>
                <p class="mt-4 text-[12px] font-medium text-slate-400">
                    {{ __('clients.loyalty_note') }}
                </p>
            </div>
        </div>

        {{-- Footer --}}
        <p class="px-1 text-[11.5px] font-medium text-slate-400">
            {{ __('clients.footer_created') }} {{ $client->created_at?->translatedFormat('d F Y') ?? '—' }}
        </p>
    </div>

    {{-- Toast --}}
    <div id="pcc-toast"
        class="pointer-events-none fixed top-6 left-1/2 z-50 flex flex-col items-center gap-3 -translate-x-1/2"></div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        /* ── Charts ── */
        (function() {
            if (typeof ApexCharts === 'undefined') return;

            const pointsEl = document.getElementById('chart-points');
            if (pointsEl) {
                const earned = {{ (int) $pointsEarned }};
                const used = {{ (int) $pointsSpent }};
                const balance = {{ (int) $pointsBalance }};
                new ApexCharts(pointsEl, {
                    chart: {
                        type: 'bar',
                        height: 230,
                        toolbar: {
                            show: false
                        },
                        fontFamily: 'inherit'
                    },
                    series: [{
                        name: 'Points',
                        data: [earned, used, balance]
                    }],
                    plotOptions: {
                        bar: {
                            borderRadius: 8,
                            columnWidth: '45%',
                            distributed: true
                        }
                    },
                    colors: ['#10b981', '#f59e0b', '#3b82f6'],
                    xaxis: {
                        categories: ['{{ __('clients.chart_earned') }}', '{{ __('clients.chart_used') }}',
                            '{{ __('clients.chart_balance') }}'
                        ],
                        labels: {
                            style: {
                                colors: '#94a3b8',
                                fontSize: '11.5px'
                            }
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: '#94a3b8',
                                fontSize: '11px'
                            },
                            formatter: v => Math.round(v)
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        style: {
                            colors: ['#334155'],
                            fontSize: '12px',
                            fontWeight: 700
                        },
                        offsetY: -22,
                        formatter: v => new Intl.NumberFormat('fr-FR').format(Math.round(v)),
                    },
                    legend: {
                        show: false
                    },
                    grid: {
                        borderColor: '#f1f5f9',
                        strokeDashArray: 4
                    },
                    tooltip: {
                        theme: 'light',
                        y: {
                            formatter: v => new Intl.NumberFormat('fr-FR').format(Math.round(v)) + ' pts'
                        },
                    },
                }).render();
            }

            const statusEl = document.getElementById('chart-status');
            if (statusEl) {
                const counts = @json(array_values($statusCounts));
                new ApexCharts(statusEl, {
                    chart: {
                        type: 'donut',
                        height: 230,
                        fontFamily: 'inherit'
                    },
                    series: counts,
                    labels: ['{{ __('clients.log_pending') }}', '{{ __('clients.log_approved') }}',
                        '{{ __('clients.log_rejected') }}', '{{ __('clients.log_delivered') }}'
                    ],
                    colors: ['#fbbf24', '#10b981', '#ef4444', '#3b82f6'],
                    legend: {
                        position: 'bottom',
                        fontSize: '12px',
                        labels: {
                            colors: '#64748b'
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 2
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '68%',
                                labels: {
                                    show: true,
                                    total: {
                                        show: true,
                                        label: '{{ __('clients.chart_total') }}',
                                        color: '#64748b',
                                        fontSize: '12px',
                                        formatter: () => counts.reduce((a, b) => a + b, 0),
                                    },
                                },
                            },
                        },
                    },
                }).render();
            }
        })();

        /* ── Tabs ── */
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById('tab-' + btn.dataset.tab)?.classList.add('active');
            });
        });

        /* ── Toast ── */
        function showToast(msg, type) {
            const bg = type === 'error' ? 'background:#dc2626' : 'background:#059669';
            const icon = type === 'error' ?
                '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>' :
                '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>';
            const t = document.createElement('div');
            t.style.cssText =
                `pointer-events:auto;display:flex;align-items:center;gap:10px;border-radius:16px;padding:10px 20px;font-size:13px;font-weight:600;color:#fff;box-shadow:0 8px 30px -8px rgba(0,0,0,.35);transition:all .3s ease;transform:translateY(-12px);opacity:0;${bg}`;
            t.innerHTML =
                `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" width="16" height="16" style="flex-shrink:0">${icon}</svg><span>${msg}</span>`;
            document.getElementById('pcc-toast').appendChild(t);
            requestAnimationFrame(() => requestAnimationFrame(() => {
                t.style.transform = 'translateY(0)';
                t.style.opacity = '1';
            }));
            setTimeout(() => {
                t.style.transform = 'translateY(-12px)';
                t.style.opacity = '0';
                setTimeout(() => t.remove(), 300);
            }, 3500);
        }

        /* ── Status config ── */
        const STATUS_CFG = {
            active: {
                label: '{{ __('clients.status_active') }}',
                badgeCls: 'bg-emerald-100 text-emerald-700',
                dotCls: 'bg-emerald-500'
            },
            inactive: {
                label: '{{ __('clients.status_inactive') }}',
                badgeCls: 'bg-amber-100 text-amber-700',
                dotCls: 'bg-amber-400'
            },
            blocked: {
                label: '{{ __('clients.status_blocked') }}',
                badgeCls: 'bg-red-100 text-red-600',
                dotCls: 'bg-red-500'
            },
        };

        function renderButtons(status) {
            const el = document.getElementById('action-buttons');
            if (!el) return;
            const urls = {
                activate: el.dataset.activateUrl,
                block: el.dataset.blockUrl,
                unblock: el.dataset.unblockUrl
            };
            const base =
                'inline-flex h-9 items-center gap-1.5 rounded-xl px-4 text-[12.5px] font-semibold shadow-sm transition';
            const iOk =
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>';
            const iBan =
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>';
            let html = '';
            if (status === 'inactive') {
                html +=
                    `<button type="button" class="${base} bg-emerald-500 text-white hover:bg-emerald-600" data-action="activate" data-url="${urls.activate}">${iOk} {{ __('clients.action_activate') }}</button>`;
            } else if (status === 'blocked') {
                html +=
                    `<button type="button" class="${base} bg-emerald-500 text-white hover:bg-emerald-600" data-action="unblock" data-url="${urls.unblock}">${iOk} {{ __('clients.action_unblock') }}</button>`;
            }
            if (status !== 'blocked') {
                html +=
                    `<button type="button" class="${base} border border-red-200 bg-white text-red-600 hover:bg-red-50" data-action="block" data-url="${urls.block}">${iBan} {{ __('clients.js_block_client_btn') }}</button>`;
            }
            el.innerHTML = html;
            el.querySelectorAll('button[data-action]').forEach(b => b.addEventListener('click', handleAction));
        }

        function updateBadge(status) {
            const cfg = STATUS_CFG[status];
            if (!cfg) return;
            document.querySelectorAll('[data-status-badge]').forEach(badge => {
                badge.className =
                    `inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-[11px] font-bold ${cfg.badgeCls}`;
                const dot = badge.querySelector('[data-status-dot]');
                if (dot) dot.className = `h-1.5 w-1.5 rounded-full ${cfg.dotCls}`;
            });
            document.querySelectorAll('[data-status-label]').forEach(l => l.textContent = cfg.label);
        }

        /* ── SweetAlert2 config per action ── */
        const SWAL_CFG = {
            activate: {
                title: 'Activer ce client ?',
                text: 'Le client pourra se connecter et accéder à ses avantages.',
                icon: 'question',
                confirmButtonText: 'Oui, activer',
                confirmButtonColor: '#10b981',
            },
            unblock: {
                title: 'Débloquer ce client ?',
                text: 'Le compte du client sera réactivé.',
                icon: 'question',
                confirmButtonText: 'Oui, débloquer',
                confirmButtonColor: '#10b981',
            },
            block: {
                title: 'Bloquer ce client ?',
                text: 'Le client ne pourra plus se connecter ni effectuer de demandes.',
                icon: 'warning',
                confirmButtonText: 'Oui, bloquer',
                confirmButtonColor: '#ef4444',
            },
        };

        function handleAction(e) {
            const btn = e.currentTarget;
            const action = btn.dataset.action;
            const csrf = document.getElementById('action-buttons').dataset.csrf;
            const cfg = SWAL_CFG[action] ?? {};
            const clientName = '{{ addslashes($client->company_name) }}';

            Swal.fire({
                title: cfg.title ?? '{{ __('clients.js_swal_confirm') }}',
                html: `<span style="font-size:13.5px;color:#475569">${cfg.text ?? ''}</span><br><strong style="font-size:13px;color:#0f172a">${clientName}</strong>`,
                icon: cfg.icon ?? 'question',
                showCancelButton: true,
                cancelButtonText: '{{ __('clients.js_swal_cancel') }}',
                confirmButtonText: cfg.confirmButtonText ?? '{{ __('clients.js_swal_confirm') }}',
                confirmButtonColor: cfg.confirmButtonColor ?? '#3b82f6',
                cancelButtonColor: '#e2e8f0',
                reverseButtons: true,
                customClass: {
                    cancelButton: 'swal-cancel',
                    popup: 'swal-popup',
                },
                didOpen: () => {
                    const cancel = document.querySelector('.swal2-cancel');
                    if (cancel) cancel.style.color = '#475569';
                },
            }).then(result => {
                if (!result.isConfirmed) return;
                btn.disabled = true;
                btn.style.opacity = '0.6';
                fetch(btn.dataset.url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.status) {
                            document.getElementById('action-buttons').dataset.status = data.status;
                            renderButtons(data.status);
                            updateBadge(data.status);
                            showToast(data.message ?? '{{ __('clients.js_status_ok') }}', 'success');
                            setTimeout(() => location.reload(), 1200);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ __('clients.js_error_title') }}',
                                text: data.message ?? '{{ __('clients.js_error_occurred') }}',
                                confirmButtonColor: '#3b82f6'
                            });
                            btn.disabled = false;
                            btn.style.opacity = '';
                        }
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __('clients.js_conn_error_title') }}',
                            text: '{{ __('clients.js_conn_error_text') }}',
                            confirmButtonColor: '#3b82f6'
                        });
                        btn.disabled = false;
                        btn.style.opacity = '';
                    });
            });
        }

        (function() {
            const el = document.getElementById('action-buttons');
            if (el) renderButtons(el.dataset.status);
        })();
    </script>

</x-app-layout>
