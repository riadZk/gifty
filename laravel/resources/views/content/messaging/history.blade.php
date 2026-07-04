<x-app-layout>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community@32.3.3/styles/ag-grid.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community@32.3.3/styles/ag-theme-quartz.css">
    <script src="https://cdn.jsdelivr.net/npm/ag-grid-enterprise@32.3.3/dist/ag-grid-enterprise.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --pcc: #FFC60B;
        }

        /* ── AG Grid theme ── */
        .ag-theme-pcc {
            --ag-font-family: 'Manrope', system-ui, sans-serif;
            --ag-font-size: 13px;
            --ag-foreground-color: #0f172a;
            --ag-background-color: #ffffff;
            --ag-header-background-color: #f8fafc;
            --ag-header-foreground-color: #64748b;
            --ag-row-hover-color: #fffbeb;
            --ag-selected-row-background-color: #fff4c2;
            --ag-border-color: #eef2f7;
            --ag-row-border-color: #f1f5f9;
            --ag-header-column-separator-display: none;
            --ag-cell-horizontal-padding: 18px;
            --ag-grid-size: 6px;
            --ag-borders: none;
            --ag-header-height: 46px;
            --ag-row-height: 64px;
            --ag-checkbox-checked-color: var(--pcc);
            --ag-input-focus-border-color: var(--pcc);
        }

        .ag-theme-pcc .ag-header-cell-text {
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .ag-theme-pcc .ag-root-wrapper {
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #b9b9b84b;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        /* ── Stat cards ── */
        .m-stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        @media (max-width:1024px) {
            .m-stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width:560px) {
            .m-stat-grid {
                grid-template-columns: 1fr;
            }
        }

        .m-stat {
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            border-radius: 18px;
            padding: 18px;
            border: 1px solid transparent;
            transition: transform .18s, box-shadow .18s;
        }

        .m-stat:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 32px -18px rgba(15, 23, 42, .45);
        }

        .m-stat .ic {
            width: 46px;
            height: 46px;
            border-radius: 13px;
            display: grid;
            place-items: center;
            color: #fff;
            margin-bottom: 16px;
            box-shadow: 0 8px 16px -6px rgba(15, 23, 42, .35);
        }

        .m-stat .meta {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .m-stat .val {
            font-size: 27px;
            font-weight: 900;
            line-height: 1;
            letter-spacing: -.02em;
        }

        .m-stat .lab {
            font-size: 12px;
            font-weight: 700;
            color: #64748b;
            margin-top: 8px;
        }

        .s-blue {
            background: #eff6ff;
            border-color: #dbeafe;
        }

        .s-blue .ic {
            background: #3b82f6;
        }

        .s-blue .val {
            color: #1d4ed8;
        }

        .s-green {
            background: #ecfdf5;
            border-color: #d1fae5;
        }

        .s-green .ic {
            background: #10b981;
        }

        .s-green .val {
            color: #047857;
        }

        .s-amber {
            background: #fffbeb;
            border-color: #fef3c7;
        }

        .s-amber .ic {
            background: #f59e0b;
        }

        .s-amber .val {
            color: #b45309;
        }

        .s-red {
            background: #fef2f2;
            border-color: #fee2e2;
        }

        .s-red .ic {
            background: #ef4444;
        }

        .s-red .val {
            color: #b91c1c;
        }

        /* ── Charts ── */
        .m-chart-grid {
            display: grid;
            grid-template-columns: 1.6fr 1fr;
            gap: 16px;
            margin-bottom: 22px;
        }

        @media (max-width: 1024px) {
            .m-chart-grid {
                grid-template-columns: 1fr;
            }
        }

        .m-card {
            background: #fff;
            border: 1px solid #eef2f7;
            border-radius: 18px;
            padding: 18px 20px;
            box-shadow: 0 1px 2px rgba(15, 23, 42, .04);
        }

        .m-card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .m-card-title {
            font-size: 14px;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -.01em;
        }

        .m-card-sub {
            font-size: 11.5px;
            color: #94a3b8;
            margin-top: 1px;
        }

        .m-legend {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .m-legend span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11.5px;
            font-weight: 700;
            color: #64748b;
        }

        .m-legend i {
            width: 10px;
            height: 10px;
            border-radius: 3px;
            display: inline-block;
        }

        .m-chart-wrap {
            position: relative;
            height: 240px;
        }

        /* ── Panel head / toolbar ── */
        .panel-head {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
        }

        .panel-title {
            font-size: 16px;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -.01em;
        }

        .panel-subtitle {
            font-size: 12.5px;
            color: #94a3b8;
            margin-top: 1px;
        }

        .pcc-search {
            position: relative;
            display: flex;
            align-items: center;
            height: 42px;
        }

        .pcc-search input {
            height: 100%;
            min-width: 250px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 0 14px 0 40px;
            font-size: 13px;
            color: #0f172a;
            outline: none;
            background: #fff;
            transition: all .15s;
        }

        .pcc-search input:focus {
            border-color: var(--pcc);
            box-shadow: 0 0 0 4px rgba(255, 198, 11, .16);
        }

        .pcc-search svg {
            position: absolute;
            left: 13px;
            color: #94a3b8;
        }

        .pcc-tbtn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            height: 42px;
            padding: 0 16px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all .15s;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #475569;
        }

        .pcc-tbtn:hover {
            background: #f8fafc;
        }

        .pcc-tbtn.dark {
            background: #0f172a;
            border-color: #0f172a;
            color: #fff;
        }

        .pcc-tbtn.dark:hover {
            background: #1e293b;
        }

        /* ── Cell renderers ── */
        .pcc-avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 11px;
            color: #fff;
            font-weight: 800;
            font-size: 12px;
            flex-shrink: 0;
            box-shadow: 0 4px 12px -4px rgba(15, 23, 42, .3);
        }

        .pcc-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            line-height: 1;
        }

        .pcc-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .pcc-badge.b-sent {
            background: #ecfdf5;
            color: #047857;
        }

        .pcc-badge.b-partial {
            background: #fffbeb;
            color: #b45309;
        }

        .pcc-badge.b-failed {
            background: #fef2f2;
            color: #b91c1c;
        }

        .pcc-badge.b-queued {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .ch-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px 4px 7px;
            border-radius: 999px;
            margin: 2px 4px 2px 0;
            border: 1px solid transparent;
            line-height: 1;
        }

        .ch-pill svg {
            width: 13px;
            height: 13px;
            flex-shrink: 0;
        }

        .p-push {
            background: #eff6ff;
            color: #2563eb;
            border-color: #dbeafe;
        }

        .p-mail {
            background: #f5f3ff;
            color: #7c3aed;
            border-color: #ede9fe;
        }

        .p-whatsapp {
            background: #ecfdf5;
            color: #059669;
            border-color: #d1fae5;
        }

        .num-cell {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            height: 100%;
            font-size: 14px;
            font-weight: 800;
            font-variant-numeric: tabular-nums;
        }

        .num-cell svg {
            opacity: .9;
        }

        .n-slate {
            color: #334155;
        }

        .n-green {
            color: #059669;
        }

        .n-red {
            color: #dc2626;
        }

        .n-muted {
            color: #cbd5e1;
        }

        /* ── Row action buttons ── */
        .pcc-actions {
            display: flex;
            align-items: center;
            gap: 6px;
            height: 100%;
        }

        .pcc-abtn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            height: 32px;
            padding: 0 11px;
            border-radius: 9px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #475569;
            transition: all .15s;
        }

        .pcc-abtn:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

        .pcc-abtn svg {
            width: 14px;
            height: 14px;
        }

        .pcc-abtn.resend {
            background: #fff7ed;
            border-color: #fed7aa;
            color: #c2410c;
        }

        .pcc-abtn.resend:hover {
            background: #ffedd5;
            border-color: #fdba74;
        }

        /* ── Detail modal ── */
        .pcc-modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 60;
            display: none;
            align-items: flex-start;
            justify-content: center;
            padding: 40px 16px;
            background: rgba(15, 23, 42, .45);
            backdrop-filter: blur(2px);
            overflow-y: auto;
        }

        .pcc-modal-overlay.open {
            display: flex;
        }

        .pcc-modal {
            width: 100%;
            max-width: 760px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 24px 60px -20px rgba(15, 23, 42, .5);
            overflow: hidden;
            animation: pccModalIn .18s ease-out;
        }

        @keyframes pccModalIn {
            from {
                opacity: 0;
                transform: translateY(12px) scale(.98);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .pcc-modal-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            padding: 20px 22px;
            border-bottom: 1px solid #eef2f7;
        }

        .pcc-modal-head h3 {
            font-size: 17px;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -.01em;
        }

        .pcc-modal-head .sub {
            font-size: 12px;
            font-weight: 700;
            color: #94a3b8;
            margin-top: 2px;
        }

        .pcc-modal-close {
            display: grid;
            place-items: center;
            width: 34px;
            height: 34px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #64748b;
            cursor: pointer;
            flex-shrink: 0;
        }

        .pcc-modal-close:hover {
            background: #f8fafc;
        }

        .pcc-modal-body {
            padding: 20px 22px;
            max-height: 62vh;
            overflow-y: auto;
        }

        .pcc-detail-msg {
            background: #f8fafc;
            border: 1px solid #eef2f7;
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 18px;
        }

        .pcc-detail-msg .t {
            font-size: 14px;
            font-weight: 800;
            color: #0f172a;
        }

        .pcc-detail-msg .b {
            font-size: 13px;
            color: #475569;
            margin-top: 6px;
            white-space: pre-wrap;
            line-height: 1.5;
        }

        .pcc-detail-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 12px;
        }

        .pcc-detail-meta .chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11.5px;
            font-weight: 700;
            color: #64748b;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 999px;
            padding: 4px 10px;
        }

        .pcc-rtable {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
        }

        .pcc-rtable th {
            text-align: left;
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #94a3b8;
            padding: 8px 10px;
            border-bottom: 1px solid #eef2f7;
        }

        .pcc-rtable td {
            padding: 10px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            vertical-align: middle;
        }

        .pcc-rtable .r-name {
            font-weight: 700;
            color: #0f172a;
        }

        .pcc-rtable .r-contact {
            font-size: 11px;
            color: #94a3b8;
        }

        .pcc-rtable .r-err {
            font-size: 11px;
            color: #b91c1c;
        }

        .pcc-badge.b-pending {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .pcc-modal-foot {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            padding: 16px 22px;
            border-top: 1px solid #eef2f7;
            background: #fcfcfd;
        }
    </style>


    <div class="flex flex-col gap-6">

        {{-- Header --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div class="flex flex-col gap-1">
                <nav class="flex items-center gap-1.5 text-[11.5px] font-semibold text-slate-400">
                    <span>{{ __('messaging.breadcrumb_communication') }}</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3 w-3">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                    <span class="text-slate-700">{{ __('messaging.history_breadcrumb') }}</span>
                </nav>
                <h1 class="text-[26px] font-black tracking-tight text-slate-900">{{ __('messaging.history_title') }}
                </h1>
                <p class="text-[13px] text-slate-500">{{ __('messaging.history_subtitle') }}
                </p>
            </div>
            <a href="{{ route('messaging.index') }}"
                class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-amber-400 px-5 text-[13.5px] font-extrabold text-slate-900 shadow-sm transition hover:bg-amber-500">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                {{ __('messaging.btn_new_message') }}
            </a>
        </div>

        {{-- Stat cards --}}
        <div class="m-stat-grid">
            <div class="m-stat s-blue">
                <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
                        class="h-5 w-5">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg></div>
                <div class="meta">
                    <div class="val">{{ number_format($stats['total']) }}</div>
                    <div class="lab">{{ __('messaging.stat_messages_sent') }}</div>
                </div>
            </div>
            <div class="m-stat s-green">
                <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
                        class="h-5 w-5">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg></div>
                <div class="meta">
                    <div class="val">{{ number_format($stats['delivered']) }}</div>
                    <div class="lab">{{ __('messaging.stat_delivered') }}</div>
                </div>
            </div>
            <div class="m-stat s-amber">
                <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
                        class="h-5 w-5">
                        <path
                            d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                        <line x1="12" y1="9" x2="12" y2="13" />
                        <line x1="12" y1="17" x2="12.01" y2="17" />
                    </svg></div>
                <div class="meta">
                    <div class="val">{{ number_format($stats['partial']) }}</div>
                    <div class="lab">{{ __('messaging.stat_partial') }}</div>
                </div>
            </div>
            <div class="m-stat s-red">
                <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
                        class="h-5 w-5">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="15" y1="9" x2="9" y2="15" />
                        <line x1="9" y1="9" x2="15" y2="15" />
                    </svg></div>
                <div class="meta">
                    <div class="val">{{ number_format($stats['failed']) }}</div>
                    <div class="lab">{{ __('messaging.stat_failed') }}</div>
                </div>
            </div>
        </div>

        {{-- Charts --}}
        <div class="m-chart-grid">
            <div class="m-card">
                <div class="m-card-head">
                    <div>
                        <div class="m-card-title">{{ __('messaging.chart_trend_title') }}</div>
                        <div class="m-card-sub">{{ __('messaging.chart_trend_sub') }}</div>
                    </div>
                    <div class="m-legend">
                        <span><i style="background:#10b981"></i>{{ __('messaging.legend_delivered') }}</span>
                        <span><i style="background:#ef4444"></i>{{ __('messaging.legend_failed') }}</span>
                    </div>
                </div>
                <div class="m-chart-wrap">
                    <canvas id="chart-trend"></canvas>
                </div>
            </div>
            <div class="m-card">
                <div class="m-card-head">
                    <div>
                        <div class="m-card-title">{{ __('messaging.chart_channels_title') }}</div>
                        <div class="m-card-sub">{{ __('messaging.chart_channels_sub') }}</div>
                    </div>
                </div>
                <div class="m-chart-wrap">
                    <canvas id="chart-channels"></canvas>
                </div>
            </div>
        </div>

        {{-- Grid panel --}}
        <div>
            <div class="panel-head">
                <div>
                    <div class="panel-title">{{ __('messaging.grid_title') }}</div>
                    <div class="panel-subtitle">{{ __('messaging.grid_subtitle') }}</div>
                </div>
                <div class="ml-auto flex items-center gap-2">
                    <div class="pcc-search">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            class="h-4 w-4">
                            <circle cx="11" cy="11" r="7" />
                            <path d="m20 20-3.5-3.5" />
                        </svg>
                        <input type="search" id="messages-quick-filter"
                            placeholder="{{ __('messaging.search_placeholder') }}">
                    </div>
                    <button type="button" id="btn-messages-export" class="pcc-tbtn dark">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            class="h-4 w-4">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        {{ __('messaging.btn_export') }}
                    </button>
                </div>
            </div>

            <div id="messages-grid" class="ag-theme-quartz ag-theme-pcc" style="height:600px;width:100%;"></div>
        </div>
    </div>

    {{-- Detail modal --}}
    <div id="msg-modal" class="pcc-modal-overlay" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="pcc-modal">
            <div class="pcc-modal-head">
                <div>
                    <h3>{{ __('messaging.detail_title') }}</h3>
                    <div class="sub" id="msg-modal-key"></div>
                </div>
                <button type="button" class="pcc-modal-close" data-close-modal aria-label="{{ __('messaging.detail_close') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>
            <div class="pcc-modal-body" id="msg-modal-body">
                <p style="color:#94a3b8;font-size:13px;">{{ __('messaging.detail_loading') }}</p>
            </div>
            <div class="pcc-modal-foot">
                <button type="button" class="pcc-tbtn" data-close-modal>{{ __('messaging.detail_close') }}</button>
                <button type="button" class="pcc-tbtn dark" id="msg-modal-resend" style="display:none;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="h-4 w-4">
                        <path d="M21 2v6h-6" />
                        <path d="M3 12a9 9 0 0 1 15-6.7L21 8" />
                        <path d="M3 22v-6h6" />
                        <path d="M21 12a9 9 0 0 1-15 6.7L3 16" />
                    </svg>
                    {{ __('messaging.action_resend') }}
                </button>
            </div>
        </div>
    </div>

    {{-- Hidden resend form (submitted programmatically) --}}
    <form id="msg-resend-form" method="POST" action="" class="hidden">
        @csrf
    </form>

    <script>
        (function() {
            const MESSAGE_ROWS = @json($messageRows);
            const CHARTS = @json($charts);

            // ── Charts ──
            if (window.Chart) {
                Chart.defaults.font.family = "'Manrope', system-ui, sans-serif";
                Chart.defaults.color = '#94a3b8';

                // Activity trend (delivered vs failed)
                const trendEl = document.getElementById('chart-trend');
                if (trendEl) {
                    const ctx = trendEl.getContext('2d');
                    const gDel = ctx.createLinearGradient(0, 0, 0, 240);
                    gDel.addColorStop(0, 'rgba(16,185,129,.30)');
                    gDel.addColorStop(1, 'rgba(16,185,129,0)');
                    const gFail = ctx.createLinearGradient(0, 0, 0, 240);
                    gFail.addColorStop(0, 'rgba(239,68,68,.25)');
                    gFail.addColorStop(1, 'rgba(239,68,68,0)');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: CHARTS.trendLabels,
                            datasets: [{
                                label: '{{ __('messaging.dataset_delivered') }}',
                                data: CHARTS.trendDelivered,
                                borderColor: '#10b981',
                                backgroundColor: gDel,
                                fill: true,
                                tension: .4,
                                borderWidth: 2.5,
                                pointRadius: 0,
                                pointHoverRadius: 5,
                                pointHoverBackgroundColor: '#10b981',
                            }, {
                                label: '{{ __('messaging.dataset_failed') }}',
                                data: CHARTS.trendFailed,
                                borderColor: '#ef4444',
                                backgroundColor: gFail,
                                fill: true,
                                tension: .4,
                                borderWidth: 2.5,
                                pointRadius: 0,
                                pointHoverRadius: 5,
                                pointHoverBackgroundColor: '#ef4444',
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: {
                                mode: 'index',
                                intersect: false
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: '#0f172a',
                                    padding: 12,
                                    cornerRadius: 10,
                                    titleColor: '#fff',
                                    bodyColor: '#e2e8f0',
                                    usePointStyle: true,
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        font: {
                                            size: 11
                                        }
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    border: {
                                        display: false
                                    },
                                    grid: {
                                        color: '#f1f5f9'
                                    },
                                    ticks: {
                                        precision: 0,
                                        font: {
                                            size: 11
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

                // Channel breakdown (doughnut)
                const chEl = document.getElementById('chart-channels');
                if (chEl) {
                    const ch = CHARTS.channels || {};
                    new Chart(chEl.getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            labels: ['Push', 'E-mail', 'WhatsApp'],
                            datasets: [{
                                data: [ch.push || 0, ch.mail || 0, ch.whatsapp || 0],
                                backgroundColor: ['#3b82f6', '#8b5cf6', '#10b981'],
                                borderWidth: 0,
                                hoverOffset: 8,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '64%',
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        usePointStyle: true,
                                        pointStyle: 'circle',
                                        padding: 16,
                                        font: {
                                            size: 12,
                                            weight: '600'
                                        }
                                    }
                                },
                                tooltip: {
                                    backgroundColor: '#0f172a',
                                    padding: 12,
                                    cornerRadius: 10,
                                    usePointStyle: true,
                                }
                            }
                        }
                    });
                }
            }

            function esc(s) {
                return String(s ?? '').replace(/[&<>"']/g, c => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;'
                } [c]));
            }

            function fmtNum(n) {
                return new Intl.NumberFormat('fr-FR').format(n ?? 0);
            }

            function hash(str) {
                let h = 0;
                for (let i = 0; i < str.length; i++) {
                    h = ((h << 5) - h) + str.charCodeAt(i);
                    h |= 0;
                }
                return Math.abs(h);
            }
            const PALETTE = [
                'linear-gradient(135deg,#fb923c,#f97316)', 'linear-gradient(135deg,#38bdf8,#3b82f6)',
                'linear-gradient(135deg,#34d399,#059669)', 'linear-gradient(135deg,#a78bfa,#8b5cf6)',
                'linear-gradient(135deg,#2dd4bf,#06b6d4)', 'linear-gradient(135deg,#f472b6,#ec4899)',
                'linear-gradient(135deg,#fbbf24,#eab308)', 'linear-gradient(135deg,#fb7185,#ef4444)',
            ];

            const STATUS_META = {
                sent: ['b-sent', '{{ __('messaging.status_sent') }}'],
                partial: ['b-partial', '{{ __('messaging.status_partial') }}'],
                failed: ['b-failed', '{{ __('messaging.status_failed') }}'],
                queued: ['b-queued', '{{ __('messaging.status_queued') }}'],
            };
            const CH_META = {
                push: ['p-push', 'Push',
                    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>'
                ],
                mail: ['p-mail', 'E-mail',
                    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 5L2 7"/></svg>'
                ],
                whatsapp: ['p-whatsapp', 'WhatsApp',
                    '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.5 14.4c-.3-.1-1.7-.8-1.9-.9-.3-.1-.5-.1-.6.1-.2.3-.7.9-.8 1-.2.2-.3.2-.6.1-.3-.1-1.2-.4-2.2-1.4-.8-.7-1.4-1.6-1.5-1.9-.2-.3 0-.4.1-.6.1-.1.3-.3.4-.5.1-.1.2-.3.3-.4.1-.2 0-.3 0-.5 0-.1-.6-1.5-.8-2-.2-.5-.5-.5-.6-.5h-.5c-.2 0-.5.1-.7.3-.3.3-1 .9-1 2.3s1 2.7 1.2 2.9c.1.2 2 3 4.8 4.2.7.3 1.2.5 1.6.6.7.2 1.3.2 1.8.1.5-.1 1.7-.7 1.9-1.4.2-.7.2-1.2.2-1.4-.1-.1-.3-.2-.6-.3zM12 2a10 10 0 0 0-8.7 15l-1.3 4.7 4.8-1.3A10 10 0 1 0 12 2z"/></svg>'
                ],
            };

            function initials(name) {
                return String(name || '?').trim().split(/\s+/).map(p => p.charAt(0).toUpperCase()).slice(0, 2)
                    .join('') || '?';
            }

            const defaultColDef = {
                sortable: true,
                resizable: true,
                filter: true
            };

            const columnDefs = [{
                    headerName: '{{ __('messaging.col_message') }}',
                    field: 'title',
                    minWidth: 280,
                    flex: 1.6,
                    // pinned: 'left',
                    filter: 'agTextColumnFilter',
                    cellRenderer: p => {
                        const title = esc(p.value || '');
                        const body = esc(p.data?.body || '');
                        const key = esc(p.data?.message_key || '');
                        return `<div style="display:flex;flex-direction:column;justify-content:center;height:100%;line-height:1.35;max-width:360px;">
                            <div style="font-weight:700;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${title}</div>
                            <div style="font-size:11.5px;color:#94a3b8;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${body}</div>
                            <div style="font-size:10px;font-weight:700;color:#cbd5e1;margin-top:1px;">${key}</div>
                        </div>`;
                    },
                },
                {
                    headerName: '{{ __('messaging.col_channels') }}',
                    field: 'channels',
                    minWidth: 180,
                    filter: false,
                    sortable: false,
                    valueGetter: p => (p.data?.channels || []).join(', '),
                    cellRenderer: p => {
                        const chs = p.data?.channels || [];
                        if (!chs.length) return '<span style="color:#cbd5e1;">—</span>';
                        const pills = chs.map(c => {
                            const m = CH_META[c] || ['p-push', c, ''];
                            return `<span class="ch-pill ${m[0]}">${m[2]}${esc(m[1])}</span>`;
                        }).join('');
                        return `<div style="display:flex;align-items:center;flex-wrap:wrap;height:100%;">${pills}</div>`;
                    },
                },
                {
                    headerName: '{{ __('messaging.col_sent_by') }}',
                    field: 'sent_by',
                    minWidth: 180,
                    flex: 1,
                    filter: 'agTextColumnFilter',
                    cellRenderer: p => {
                        const name = esc(p.value || '{{ __('messaging.sender_system') }}');
                        const grad = PALETTE[hash(p.value || '') % PALETTE.length];
                        return `<div style="display:flex;align-items:center;gap:10px;height:100%;">
                            <span class="pcc-avatar" style="background:${grad}">${esc(initials(p.value))}</span>
                            <span style="font-weight:600;color:#334155;">${name}</span>
                        </div>`;
                    },
                },
                {
                    headerName: '{{ __('messaging.col_recipients') }}',
                    field: 'recipients_count',
                    minWidth: 140,
                    filter: 'agNumberColumnFilter',
                    headerClass: 'ag-right-aligned-header',
                    cellRenderer: p =>
                        `<div class="num-cell n-slate">${fmtNum(p.value)}</div>`,
                },
                {
                    headerName: '{{ __('messaging.col_delivered') }}',
                    field: 'delivered_count',
                    minWidth: 120,
                    filter: 'agNumberColumnFilter',
                    headerClass: 'ag-right-aligned-header',
                    cellRenderer: p => {
                        const cls = p.value > 0 ? 'n-green' : 'n-muted';
                        const icon = p.value > 0 ?
                            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" width="13" height="13"><path d="m5 12 5 5L20 7"/></svg>' :
                            '';
                        return `<div class="num-cell ${cls}">${icon}${fmtNum(p.value)}</div>`;
                    },
                },
                {
                    headerName: '{{ __('messaging.col_failed') }}',
                    field: 'failed_count',
                    minWidth: 120,
                    filter: 'agNumberColumnFilter',
                    headerClass: 'ag-right-aligned-header',
                    cellRenderer: p => {
                        const cls = p.value > 0 ? 'n-red' : 'n-muted';
                        return `<div class="num-cell ${cls}">${fmtNum(p.value)}</div>`;
                    },
                },
                {
                    headerName: '{{ __('messaging.col_status') }}',
                    field: 'status',
                    minWidth: 130,
                    filter: 'agSetColumnFilter',
                    filterParams: {
                        values: ['sent', 'partial', 'failed', 'queued'],
                        valueFormatter: p => (STATUS_META[p.value] || [, p.value])[1]
                    },
                    cellRenderer: p => {
                        const m = STATUS_META[p.value] || ['b-queued', p.value];
                        return `<div style="display:flex;align-items:center;height:100%;"><span class="pcc-badge ${m[0]}"><span class="dot"></span>${esc(m[1])}</span></div>`;
                    },
                },
                {
                    headerName: '{{ __('messaging.col_date') }}',
                    field: 'created_at',
                    minWidth: 150,
                    filter: 'agDateColumnFilter',
                    sort: 'desc',
                    cellRenderer: p => {
                        if (!p.value) return '<span style="color:#cbd5e1;">—</span>';
                        const d = new Date(p.value);
                        const date = d.toLocaleDateString('fr-FR', {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric'
                        });
                        const time = d.toLocaleTimeString('fr-FR', {
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                        return `<div style="display:flex;flex-direction:column;justify-content:center;height:100%;line-height:1.3;">
                            <span style="font-weight:600;color:#334155;">${date}</span>
                            <span style="font-size:11.5px;color:#94a3b8;">${time}</span>
                        </div>`;
                    },
                },
                {
                    headerName: '{{ __('messaging.col_actions') }}',
                    field: 'actions',
                    minWidth: 200,
                    maxWidth: 240,
                    // pinned: 'right',
                    filter: false,
                    sortable: false,
                    resizable: false,
                    cellRenderer: p => {
                        const id = p.data?.id;
                        const failed = Number(p.data?.failed_count || 0);
                        const detailBtn = `<button type="button" class="pcc-abtn" data-detail="${id}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
                            {{ __('messaging.action_detail') }}
                        </button>`;
                        // const resendBtn = failed > 0 ? `<button type="button" class="pcc-abtn resend" data-resend="${id}">
                        //     <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 2v6h-6"/><path d="M3 12a9 9 0 0 1 15-6.7L21 8"/><path d="M3 22v-6h6"/><path d="M21 12a9 9 0 0 1-15 6.7L3 16"/></svg>
                        //     {{ __('messaging.action_resend') }}
                        // </button>` : '';
                        // return `<div class="pcc-actions">${detailBtn}${resendBtn}</div>`;
                        return `<div class="pcc-actions">${detailBtn}</div>`;
                    },
                },
            ];

            let gridApi;

            // AG Grid Enterprise license
            agGrid.LicenseManager.setLicenseKey('{{ env('AG_GRID_LICENSE_KEY') }}');

            function bootGrid() {
                const el = document.getElementById('messages-grid');
                if (!el) return;
                gridApi = agGrid.createGrid(el, {
                    columnDefs,
                    rowData: MESSAGE_ROWS,
                    defaultColDef,
                    animateRows: true,
                    pagination: true,
                    paginationPageSize: 20,
                    paginationPageSizeSelector: [10, 20, 50, 100],
                    cellSelection: false,
                    statusBar: {
                        statusPanels: [{
                            statusPanel: 'agTotalAndFilteredRowCountComponent',
                            align: 'left'
                        }]
                    },
                });
                document.getElementById('messages-quick-filter')?.addEventListener('input', e =>
                    gridApi.setGridOption('quickFilterText', e.target.value));
                document.getElementById('btn-messages-export')?.addEventListener('click', () =>
                    gridApi.exportDataAsCsv({
                        fileName: 'messages-' + new Date().toISOString().slice(0, 10) + '.csv',
                        columnKeys: ['title', 'channels', 'sent_by', 'recipients_count',
                            'delivered_count', 'failed_count', 'status', 'created_at'
                        ],
                    }));

                // Row action buttons (detail / resend) via event delegation.
                el.addEventListener('click', e => {
                    const dBtn = e.target.closest('[data-detail]');
                    if (dBtn) {
                        openDetail(dBtn.getAttribute('data-detail'));
                        return;
                    }
                    const rBtn = e.target.closest('[data-resend]');
                    if (rBtn) {
                        resend(rBtn.getAttribute('data-resend'));
                    }
                });
            }

            // ── Detail modal + resend ──
            const MSG_BASE = @json(url('messaging'));
            const REC_STATUS = {
                sent: ['b-sent', '{{ __('messaging.status_sent') }}'],
                failed: ['b-failed', '{{ __('messaging.status_failed') }}'],
                pending: ['b-pending', '{{ __('messaging.status_pending') }}'],
            };
            const CH_LABEL = {
                push: 'Push',
                mail: 'E-mail',
                whatsapp: 'WhatsApp'
            };
            const RESEND_CONFIRM = '{{ __('messaging.resend_confirm') }}';

            const modal = document.getElementById('msg-modal');
            const modalBody = document.getElementById('msg-modal-body');
            const modalKey = document.getElementById('msg-modal-key');
            const modalResend = document.getElementById('msg-modal-resend');
            const resendForm = document.getElementById('msg-resend-form');

            function closeModal() {
                modal.classList.remove('open');
                modal.setAttribute('aria-hidden', 'true');
            }

            document.querySelectorAll('[data-close-modal]').forEach(b => b.addEventListener('click', closeModal));
            modal.addEventListener('click', e => {
                if (e.target === modal) closeModal();
            });
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape' && modal.classList.contains('open')) closeModal();
            });

            function fmtDate(iso) {
                if (!iso) return '—';
                const d = new Date(iso);
                return d.toLocaleDateString('fr-FR', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                }) + ' ' + d.toLocaleTimeString('fr-FR', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }

            function openDetail(id) {
                modal.classList.add('open');
                modal.setAttribute('aria-hidden', 'false');
                modalKey.textContent = '';
                modalResend.style.display = 'none';
                modalBody.innerHTML =
                    `<p style="color:#94a3b8;font-size:13px;">{{ __('messaging.detail_loading') }}</p>`;

                fetch(`${MSG_BASE}/${id}/detail`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(r => {
                        if (!r.ok) throw new Error('HTTP ' + r.status);
                        return r.json();
                    })
                    .then(data => renderDetail(data))
                    .catch(() => {
                        modalBody.innerHTML =
                            `<p style="color:#b91c1c;font-size:13px;">{{ __('messaging.detail_load_error') }}</p>`;
                    });
            }

            function renderDetail(d) {
                modalKey.textContent = d.message_key || '';

                const st = STATUS_META[d.status] || ['b-queued', d.status];
                const chips = [
                    `<span class="chip"><span class="pcc-badge ${st[0]}"><span class="dot"></span>${esc(st[1])}</span></span>`,
                    `<span class="chip">{{ __('messaging.col_sent_by') }}: ${esc(d.sent_by)}</span>`,
                    `<span class="chip">{{ __('messaging.col_recipients') }}: ${fmtNum(d.recipients_count)}</span>`,
                    `<span class="chip" style="color:#059669">{{ __('messaging.col_delivered') }}: ${fmtNum(d.delivered_count)}</span>`,
                    `<span class="chip" style="color:#b91c1c">{{ __('messaging.col_failed') }}: ${fmtNum(d.failed_count)}</span>`,
                    `<span class="chip">${fmtDate(d.created_at)}</span>`,
                ].join('');

                const rows = (d.recipients || []).map(r => {
                    const rs = REC_STATUS[r.status] || ['b-queued', r.status];
                    const err = r.error ?
                        `<div class="r-err">${esc(r.error)}</div>` : '';
                    return `<tr>
                        <td><div class="r-name">${esc(r.name)}</div><div class="r-contact">${esc(r.contact)}</div></td>
                        <td>${esc(CH_LABEL[r.channel] || r.channel)}</td>
                        <td><span class="pcc-badge ${rs[0]}"><span class="dot"></span>${esc(rs[1])}</span>${err}</td>
                        <td>${fmtDate(r.sent_at)}</td>
                    </tr>`;
                }).join('');

                const table = (d.recipients && d.recipients.length) ? `
                    <table class="pcc-rtable">
                        <thead><tr>
                            <th>{{ __('messaging.detail_recipient') }}</th>
                            <th>{{ __('messaging.detail_channel') }}</th>
                            <th>{{ __('messaging.detail_status') }}</th>
                            <th>{{ __('messaging.detail_sent_at') }}</th>
                        </tr></thead>
                        <tbody>${rows}</tbody>
                    </table>` :
                    `<p style="color:#94a3b8;font-size:13px;">{{ __('messaging.detail_no_recipients') }}</p>`;

                modalBody.innerHTML = `
                    <div class="pcc-detail-msg">
                        <div class="t">${esc(d.title)}</div>
                        <div class="b">${esc(d.body)}</div>
                        <div class="pcc-detail-meta">${chips}</div>
                    </div>
                    <div style="font-size:12px;font-weight:800;color:#0f172a;margin-bottom:8px;">{{ __('messaging.detail_recipients') }}</div>
                    ${table}`;

                if (Number(d.failed_count) > 0) {
                    modalResend.style.display = '';
                    modalResend.onclick = () => resend(d.id);
                } else {
                    modalResend.style.display = 'none';
                    modalResend.onclick = null;
                }
            }

            function resend(id) {
                if (!window.confirm(RESEND_CONFIRM)) return;
                resendForm.action = `${MSG_BASE}/${id}/resend`;
                resendForm.submit();
            }

            document.readyState === 'loading' ?
                document.addEventListener('DOMContentLoaded', bootGrid) : bootGrid();
        })();
    </script>

</x-app-layout>
