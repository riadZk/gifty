<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* ── Stat cards ── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        @media(max-width:1024px) {
            .stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:560px) {
            .stat-grid {
                grid-template-columns: 1fr;
            }
        }

        .stat-card {
            position: relative;
            overflow: hidden;
            border-radius: 18px;
            padding: 20px;
            color: #fff;
            box-shadow: 0 10px 24px -12px rgba(15, 23, 42, .45);
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 30px -12px rgba(15, 23, 42, .5);
        }

        .stat-card .glow {
            position: absolute;
            top: -40px;
            right: -40px;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .18);
        }

        .stat-card .glow.b {
            top: auto;
            right: auto;
            bottom: -50px;
            left: -30px;
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, .10);
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 13px;
            display: grid;
            place-items: center;
            margin-bottom: 14px;
            background: rgba(255, 255, 255, .22);
            backdrop-filter: blur(4px);
        }

        .stat-val {
            position: relative;
            font-size: 27px;
            font-weight: 900;
            line-height: 1;
            letter-spacing: -.02em;
        }

        .stat-label {
            position: relative;
            font-size: 12.5px;
            font-weight: 800;
            margin-top: 7px;
            opacity: .95;
        }

        .stat-sub {
            position: relative;
            font-size: 11px;
            margin-top: 2px;
            font-weight: 600;
            opacity: .8;
        }

        .c-blue {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }

        .c-amber {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .c-violet {
            background: linear-gradient(135deg, #8b5cf6, #6d28d9);
        }

        .c-green {
            background: linear-gradient(135deg, #10b981, #047857);
        }

        /* ── Client cards ── */
        @keyframes cardIn {
            from {
                opacity: 0;
                transform: translateY(10px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .client-card {
            background: #fff;
            border: 1.5px solid #e8edf4;
            border-radius: 18px;
            overflow: hidden;
            transition: border-color .18s, box-shadow .18s, transform .18s;
            animation: cardIn .35s ease both;
        }

        .client-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 8px 30px -8px rgba(15, 23, 42, .18);
            transform: translateY(-2px);
        }

        .client-card.hidden-card {
            display: none;
        }

        .client-card .card-avatar {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            font-size: 14px;
            font-weight: 900;
            color: #fff;
            box-shadow: 0 4px 12px -4px rgba(15, 23, 42, .3);
        }

        .client-card .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 9px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .02em;
        }

        .status-badge.active {
            background: #dcfce7;
            color: #15803d;
        }

        .status-badge.blocked {
            background: #fee2e2;
            color: #b91c1c;
        }

        .status-badge.inactive {
            background: #fef9c3;
            color: #854d0e;
        }

        .status-badge .dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
        }

        .status-badge.active .dot {
            background: #16a34a;
        }

        .status-badge.blocked .dot {
            background: #dc2626;
        }

        .status-badge.inactive .dot {
            background: #ca8a04;
        }

        .card-info-row {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 5px 0;
        }

        .card-info-row .ico {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: #f1f5f9;
            display: grid;
            place-items: center;
            flex-shrink: 0;
        }

        .card-info-row span {
            font-size: 11.5px;
            color: #475569;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .card-footer {
            border-top: 1.5px solid #f1f5f9;
            background: #f8fafc;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
        }

        .card-footer .pcc-code {
            font-size: 10.5px;
            font-weight: 800;
            color: #64748b;
            font-family: ui-monospace, monospace;
            letter-spacing: .03em;
            flex: 1;
            truncate;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .card-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 28px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: all .15s;
            flex-shrink: 0;
        }

        .card-action.view {
            background: #0f172a;
            color: #fff;
            padding: 0 12px;
            gap: 4px;
        }

        .card-action.view:hover {
            background: #334155;
        }

        .card-action.icon-btn {
            width: 28px;
            background: #fff;
            border: 1.5px solid #e2e8f0;
            color: #64748b;
        }

        .card-action.icon-btn:hover {
            background: #f1f5f9;
        }

        /* ── Action text buttons ── */
        .card-action.act-btn {
            padding: 0 10px;
            gap: 4px;
            font-size: 10.5px;
            font-weight: 800;
        }

        .card-action.act-btn.activate {
            background: #dcfce7;
            color: #15803d;
            border: 1.5px solid #bbf7d0;
        }

        .card-action.act-btn.activate:hover {
            background: #bbf7d0;
        }

        .card-action.act-btn.block {
            background: #fee2e2;
            color: #b91c1c;
            border: 1.5px solid #fecaca;
        }

        .card-action.act-btn.block:hover {
            background: #fecaca;
        }

        .card-action.act-btn.unblock {
            background: #d1fae5;
            color: #065f46;
            border: 1.5px solid #a7f3d0;
        }

        .card-action.act-btn.unblock:hover {
            background: #a7f3d0;
        }

        /* ── Filter buttons ── */
        .filter-seg {
            display: flex;
            background: #f1f5f9;
            border-radius: 12px;
            padding: 4px;
            gap: 2px;
        }

        .filter-seg .fbtn {
            height: 34px;
            padding: 0 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            color: #64748b;
            background: transparent;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            transition: all .18s;
            white-space: nowrap;
        }

        .filter-seg .fbtn:hover {
            color: #0f172a;
            background: rgba(255, 255, 255, .7);
        }

        .filter-seg .fbtn.f-active {
            background: #fff;
            color: #0f172a;
            box-shadow: 0 1px 4px rgba(15, 23, 42, .12), 0 0 0 1px rgba(15, 23, 42, .06);
        }

        .filter-seg .fbtn.f-active .fbadge {
            background: #0f172a;
            color: #fff;
        }

        .fbadge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 20px;
            height: 18px;
            padding: 0 5px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 900;
            line-height: 1;
            background: #e2e8f0;
            color: #64748b;
            transition: all .18s;
        }

        /* ── View toggle ── */
        .view-toggle {
            display: flex;
            background: #f1f5f9;
            border-radius: 12px;
            padding: 4px;
            gap: 2px;
        }

        .view-toggle button {
            height: 34px;
            padding: 0 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            color: #64748b;
            background: transparent;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all .18s;
        }

        .view-toggle button:hover {
            color: #0f172a;
            background: rgba(255, 255, 255, .7);
        }

        .view-toggle button.active {
            background: #fff;
            color: #0f172a;
            box-shadow: 0 1px 4px rgba(15, 23, 42, .12), 0 0 0 1px rgba(15, 23, 42, .06);
        }

        /* ── Export button ── */
        .btn-export {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            height: 42px;
            padding: 0 20px;
            border-radius: 12px;
            background: linear-gradient(135deg, #1e293b, #0f172a);
            color: #fff;
            font-size: 12.5px;
            font-weight: 800;
            border: none;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 14px -4px rgba(15, 23, 42, .5);
            transition: all .18s;
        }

        .btn-export:hover {
            background: linear-gradient(135deg, #334155, #1e293b);
            box-shadow: 0 6px 20px -4px rgba(15, 23, 42, .55);
            transform: translateY(-1px);
        }

        .btn-export:active {
            transform: translateY(0);
        }

        /* ── Empty state ── */
        #no-results {
            display: none;
        }

        /* ── Override global Tailwind forms reset on search input ── */
        #client-search {
            appearance: none;
            background: transparent;
            border: none;
            border-radius: 0;
            padding: 0;
            font-size: 13.5px;
            line-height: 1.5;
            box-shadow: none;
            outline: none;
            color: #475569;
        }

        #client-search:focus {
            outline: none;
            box-shadow: none;
            border-color: transparent;
        }

        #client-search::placeholder {
            color: #94a3b8;
        }
    </style>

    <div class="flex flex-col gap-6">

        {{-- ── Page header ── --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div class="space-y-1">
                <nav class="flex items-center gap-1.5 text-[11.5px] font-semibold text-slate-400">
                    <span>{{ __('clients.breadcrumb_admin') }}</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3 w-3">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                    <span class="text-slate-700">{{ __('clients.page_title') }}</span>
                </nav>
                <h1 class="text-[26px] font-black tracking-tight text-slate-900">{{ __('clients.page_title') }}</h1>
                <p class="text-[13px] text-slate-500">{{ __('clients.page_subtitle') }}</p>
            </div>
        </div>

        {{-- ── Stat tiles ── --}}
        <div class="stat-grid">
            <div class="stat-card c-blue">
                <div class="glow"></div>
                <div class="glow b"></div>
                <div class="stat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.9"
                        class="h-5 w-5">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg></div>
                <div class="stat-val">{{ number_format($clients->count()) }}</div>
                <div class="stat-label">{{ __('clients.stat_total') }}</div>
                <div class="stat-sub">{{ __('clients.stat_total_sub') }}</div>
            </div>
            <div class="stat-card c-green">
                <div class="glow"></div>
                <div class="glow b"></div>
                <div class="stat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.9"
                        class="h-5 w-5">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg></div>
                <div class="stat-val">{{ number_format($activeCount) }}</div>
                <div class="stat-label">{{ __('clients.stat_active') }}</div>
                <div class="stat-sub">
                    {{ __('clients.stat_active_sub', ['pct' => $clients->count() ? round(($activeCount / $clients->count()) * 100) : 0]) }}
                </div>
            </div>
            <div class="stat-card c-amber">
                <div class="glow"></div>
                <div class="glow b"></div>
                <div class="stat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.9"
                        class="h-5 w-5">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <line x1="19" y1="8" x2="19" y2="14" />
                        <line x1="22" y1="11" x2="16" y2="11" />
                    </svg></div>
                <div class="stat-val">{{ number_format($newCount) }}</div>
                <div class="stat-label">{{ __('clients.stat_new') }}</div>
                <div class="stat-sub">{{ __('clients.stat_new_sub') }}</div>
            </div>
            <div class="stat-card c-violet">
                <div class="glow"></div>
                <div class="glow b"></div>
                <div class="stat-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="h-5 w-5"
                        fill="#fff">
                        <path
                            d="M385.5 132.8C393.1 119.9 406.9 112 421.8 112L424 112C446.1 112 464 129.9 464 152C464 174.1 446.1 192 424 192L350.7 192L385.5 132.8zM254.5 132.8L289.3 192L216 192C193.9 192 176 174.1 176 152C176 129.9 193.9 112 216 112L218.2 112C233.1 112 247 119.9 254.5 132.8zM344.1 108.5L320 149.5L295.9 108.5C279.7 80.9 250.1 64 218.2 64L216 64C167.4 64 128 103.4 128 152C128 166.4 131.5 180 137.6 192L96 192C78.3 192 64 206.3 64 224L64 256C64 273.7 78.3 288 96 288L544 288C561.7 288 576 273.7 576 256L576 224C576 206.3 561.7 192 544 192L502.4 192C508.5 180 512 166.4 512 152C512 103.4 472.6 64 424 64L421.8 64C389.9 64 360.3 80.9 344.1 108.4zM544 336L344 336L344 544L480 544C515.3 544 544 515.3 544 480L544 336zM296 336L96 336L96 480C96 515.3 124.7 544 160 544L296 544L296 336z" />
                    </svg></div>
                <div class="stat-val">{{ number_format($totalPoints) }}</div>
                <div class="stat-label">{{ __('clients.stat_points') }}</div>
                <div class="stat-sub">{{ __('clients.stat_points_sub') }}</div>
            </div>
        </div>

        {{-- ── Alerts ── --}}
        @if (session('success'))
            <div role="status"
                class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-3 text-[13px] font-semibold text-emerald-700">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                    class="mt-0.5 h-4 w-4 shrink-0">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- ── Toolbar ── --}}
        <div class="flex flex-wrap items-center gap-3">
            {{-- Search input --}}
            <label
                class="flex h-12 w-72 cursor-text items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 shadow-sm transition-all focus-within:border-slate-400 focus-within:shadow-md">
                <svg viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" class="h-4 w-4 shrink-0">
                    <circle cx="11" cy="11" r="7" />
                    <path d="m20 20-3.5-3.5" />
                </svg>
                <input type="search" id="client-search" placeholder="{{ __('clients.search_placeholder') }}"
                    class="h-full flex-1 bg-transparent text-[13.5px] text-slate-600 placeholder-slate-400 focus:outline-none">
            </label>

            {{-- Status filter --}}
            <div class="filter-seg">
                <button class="fbtn filter-btn f-active" data-status="all">
                    {{ __('clients.filter_all') }}
                    <span class="fbadge">{{ $totalClients }}</span>
                </button>
                <button class="fbtn filter-btn" data-status="active">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    {{ __('clients.filter_active') }}
                    <span class="fbadge">{{ $activeCount }}</span>
                </button>
                <button class="fbtn filter-btn" data-status="inactive">
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span>
                    {{ __('clients.filter_inactive') }}
                    <span class="fbadge">{{ $inactiveCount }}</span>
                </button>
                <button class="fbtn filter-btn" data-status="blocked">
                    <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                    {{ __('clients.filter_blocked') }}
                    <span class="fbadge">{{ $blockedCount }}</span>
                </button>
            </div>

            <div class="ml-auto flex items-center gap-2.5">
                {{-- View toggle --}}
                <div class="view-toggle">
                    <button id="view-cards" class="active">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            class="h-3.5 w-3.5">
                            <rect x="3" y="3" width="7" height="7" rx="1" />
                            <rect x="14" y="3" width="7" height="7" rx="1" />
                            <rect x="3" y="14" width="7" height="7" rx="1" />
                            <rect x="14" y="14" width="7" height="7" rx="1" />
                        </svg>
                        {{ __('clients.view_grid') }}
                    </button>
                    <button id="view-list">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            class="h-3.5 w-3.5">
                            <line x1="3" y1="6" x2="21" y2="6" />
                            <line x1="3" y1="12" x2="21" y2="12" />
                            <line x1="3" y1="18" x2="21" y2="18" />
                        </svg>
                        {{ __('clients.view_list') }}
                    </button>
                </div>
                {{-- Export --}}
                <a href="{{ route('clients') }}" class="btn-export">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" y1="15" x2="12" y2="3" />
                    </svg>
                    {{ __('clients.export_csv') }}
                </a>
            </div>
        </div>

        {{-- ── Results count ── --}}
        <div class="flex items-center gap-2">
            <span class="text-sm font-semibold text-slate-500"><span id="result-count">{{ $clients->total() }}</span>
                {{ __('clients.result_suffix') }}</span>
            <span class="h-1 w-1 rounded-full bg-slate-300"></span>
            <span class="text-[11px] text-slate-400">{{ __('clients.results_hint') }}</span>
        </div>

        {{-- ── Cards grid ── --}}
        <div id="clients-container">
            <div id="cards-view" class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @include('content.clients._cards', ['clients' => $clients])
            </div>

            {{-- List view (hidden by default) --}}
            <div id="list-view" class="hidden overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <table class="w-full text-left text-sm">
                    <thead
                        class="border-b border-slate-100 bg-slate-50 text-[11px] font-black uppercase tracking-widest text-slate-400">
                        <tr>
                            <th class="px-5 py-4">{{ __('clients.col_client') }}</th>
                            <th class="px-4 py-4">{{ __('clients.col_phone') }}</th>
                            <th class="px-4 py-4">{{ __('clients.col_email') }}</th>
                            <th class="px-4 py-4">{{ __('clients.col_pcc_code') }}</th>
                            <th class="px-4 py-4 text-right">{{ __('clients.col_sales_points') }}</th>
                            <th class="px-4 py-4">{{ __('clients.col_status') }}</th>
                            <th class="px-5 py-4 text-right">{{ __('clients.col_actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50" id="list-body">
                        @include('content.clients._rows', ['clients' => $clients])
                    </tbody>
                </table>
            </div>

            {{-- Infinite scroll loader --}}
            <div id="scroll-loader"
                class="hidden items-center justify-center gap-2 py-6 text-[12px] font-bold text-slate-400">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    class="h-4 w-4 animate-spin">
                    <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                </svg>
                {{ __('clients.loading') }}
            </div>

            {{-- Empty state --}}
            <div id="no-results"
                class="flex flex-col items-center gap-4 rounded-2xl border border-dashed border-slate-200 py-16 text-center">
                <div class="grid h-14 w-14 place-items-center rounded-2xl bg-slate-100">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5" class="h-7 w-7">
                        <circle cx="11" cy="11" r="7" />
                        <path d="m20 20-3.5-3.5" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-700">{{ __('clients.no_results') }}</p>
                    <p class="text-xs text-slate-400 mt-1">{{ __('clients.no_results_sub') }}</p>
                </div>
                <button onclick="window.resetClientSearch && window.resetClientSearch()"
                    class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-50">
                    {{ __('clients.reset_search') }}
                </button>
            </div>
        </div>
    </div>

    {{-- Toast --}}
    <div id="pcc-toast"
        class="pointer-events-none fixed top-6 left-1/2 z-50 flex flex-col items-center gap-3 -translate-x-1/2"></div>

    <script>
        (function() {
            const CSRF = '{{ csrf_token() }}';

            /* ── Toast ── */
            function showToast(msg, type) {
                const bg = type === 'error' ? 'background:#dc2626' : 'background:#059669';
                const t = document.createElement('div');
                t.style.cssText =
                    `pointer-events:auto;display:flex;align-items:center;gap:10px;border-radius:16px;padding:10px 18px;font-size:13px;font-weight:600;color:#fff;box-shadow:0 8px 30px -8px rgba(0,0,0,.35);transition:all .3s ease;transform:translateY(12px);opacity:0;${bg}`;
                const icon = type === 'error' ?
                    '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>' :
                    '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>';
                t.innerHTML =
                    `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" width="16" height="16" style="flex-shrink:0">${icon}</svg><span>${msg}</span>`;
                document.getElementById('pcc-toast').appendChild(t);
                requestAnimationFrame(() => requestAnimationFrame(() => {
                    t.style.transform = 'translateY(0)';
                    t.style.opacity = '1';
                }));
                setTimeout(() => {
                    t.style.transform = 'translateY(12px)';
                    t.style.opacity = '0';
                    setTimeout(() => t.remove(), 300);
                }, 3500);
            }

            /* ── View toggle ── */
            let currentView = 'cards';
            document.getElementById('view-cards').addEventListener('click', () => {
                currentView = 'cards';
                document.getElementById('cards-view').classList.remove('hidden');
                document.getElementById('list-view').classList.add('hidden');
                document.getElementById('view-cards').classList.add('active');
                document.getElementById('view-list').classList.remove('active');
                updateLoaderVisibility();
            });
            document.getElementById('view-list').addEventListener('click', () => {
                currentView = 'list';
                document.getElementById('list-view').classList.remove('hidden');
                document.getElementById('cards-view').classList.add('hidden');
                document.getElementById('view-list').classList.add('active');
                document.getElementById('view-cards').classList.remove('active');
                updateLoaderVisibility();
            });

            /* ── Backend pagination + infinite scroll ── */
            const BASE_URL = @json(route('clients'));
            const searchInput = document.getElementById('client-search');
            const cardsView = document.getElementById('cards-view');
            const listBody = document.getElementById('list-body');
            const loader = document.getElementById('scroll-loader');
            const noResults = document.getElementById('no-results');

            let activeStatus = 'all';
            let currentPage = 1;
            let hasMore = {{ $clients->hasMorePages() ? 'true' : 'false' }};
            let loading = false;

            function updateLoaderVisibility() {
                if (loader) loader.style.display = (hasMore && !loading) ? 'flex' : 'none';
            }

            function buildUrl(page) {
                const params = new URLSearchParams();
                const q = searchInput.value.trim();
                if (q) params.set('search', q);
                if (activeStatus !== 'all') params.set('status', activeStatus);
                params.set('page', page);
                return `${BASE_URL}?${params.toString()}`;
            }

            async function loadClients(reset = false) {
                if (loading) return;
                if (!reset && !hasMore) return;
                loading = true;

                const nextPage = reset ? 1 : currentPage + 1;
                if (loader) loader.style.display = 'flex';

                try {
                    const res = await fetch(buildUrl(nextPage), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });
                    const data = await res.json();

                    if (reset) {
                        cardsView.innerHTML = '';
                        listBody.innerHTML = '';
                    }
                    cardsView.insertAdjacentHTML('beforeend', data.cards);
                    listBody.insertAdjacentHTML('beforeend', data.rows);

                    currentPage = data.page;
                    hasMore = data.hasMore;
                    document.getElementById('result-count').textContent = data.total;
                    noResults.style.display = data.total === 0 ? 'flex' : 'none';
                } catch (e) {
                    hasMore = false;
                } finally {
                    loading = false;
                    updateLoaderVisibility();
                }
            }

            /* Debounced search */
            let searchTimer = null;
            searchInput.addEventListener('input', () => {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => loadClients(true), 350);
            });

            /* Status filter buttons */
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    activeStatus = btn.dataset.status;
                    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove(
                        'f-active'));
                    btn.classList.add('f-active');
                    loadClients(true);
                });
            });

            /* Infinite scroll (cards + list) */
            window.addEventListener('scroll', () => {
                if (loading || !hasMore) return;
                if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 350) {
                    loadClients(false);
                }
            });

            /* Reset search (empty state button) */
            window.resetClientSearch = function() {
                searchInput.value = '';
                activeStatus = 'all';
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('f-active'));
                const allBtn = document.querySelector('.filter-btn[data-status="all"]');
                if (allBtn) allBtn.classList.add('f-active');
                loadClients(true);
            };

            updateLoaderVisibility();
            if ({{ $clients->total() }} === 0) noResults.style.display = 'flex';

            /* ── Client actions ── */
            const ACTION_LABEL = {
                activate: '{{ __('clients.js_verb_activate') }}',
                block: '{{ __('clients.js_verb_block') }}',
                unblock: '{{ __('clients.js_verb_unblock') }}'
            };
            const ACTION_COLOR = {
                activate: '#FFC60B',
                block: '#ef4444',
                unblock: '#10b981'
            };
            const ACTION_ICON = {
                activate: 'success',
                block: 'warning',
                unblock: 'question'
            };

            document.addEventListener('click', e => {
                const btn = e.target.closest('.client-action');
                if (!btn) return;
                const {
                    action,
                    url,
                    name
                } = btn.dataset;
                const verb = ACTION_LABEL[action] || action;

                Swal.fire({
                    title: '{{ __('clients.js_confirm_title') }}',
                    html: `{{ __('clients.js_confirm_html', ['verb' => ':verb', 'name' => ':name']) }}`
                        .replace(':verb', verb).replace(':name', name),
                    icon: ACTION_ICON[action] || 'question',
                    showCancelButton: true,
                    confirmButtonText: verb.charAt(0).toUpperCase() + verb.slice(1),
                    cancelButtonText: '{{ __('clients.js_cancel') }}',
                    confirmButtonColor: ACTION_COLOR[action] || '#0f172a',
                    cancelButtonColor: '#94a3b8',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'font-bold',
                        cancelButton: 'font-bold'
                    },
                }).then(r => {
                    if (!r.isConfirmed) return;
                    btn.disabled = true;
                    btn.style.opacity = '.4';
                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': CSRF,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status) {
                                showToast(data.message ?? '{{ __('clients.js_status_updated') }}',
                                    'success');
                                setTimeout(() => location.reload(), 800);
                            } else {
                                showToast(data.message ?? 'Une erreur est survenue.', 'error');
                                btn.disabled = false;
                                btn.style.opacity = '';
                            }
                        })
                        .catch(() => {
                            showToast('Erreur de connexion.', 'error');
                            btn.disabled = false;
                            btn.style.opacity = '';
                        });
                });
            });
        })();
    </script>
</x-app-layout>
