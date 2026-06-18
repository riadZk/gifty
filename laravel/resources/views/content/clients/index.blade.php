<x-app-layout>

    {{-- ─────── AG Grid Enterprise (CDN) ─────── --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community@32.3.3/styles/ag-grid.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community@32.3.3/styles/ag-theme-quartz.css">
    <script src="https://cdn.jsdelivr.net/npm/ag-grid-enterprise@32.3.3/dist/ag-grid-enterprise.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* PCC theme tuning */
        .ag-theme-pcc {
            --ag-font-family: 'Manrope', system-ui, sans-serif;
            --ag-font-size: 13px;
            --ag-foreground-color: #0f172a;
            --ag-background-color: #ffffff;
            --ag-header-background-color: #f8fafc;
            --ag-header-foreground-color: #475569;
            --ag-odd-row-background-color: #ffffff;
            --ag-row-hover-color: #fff8dd;
            --ag-selected-row-background-color: #fff4c2;
            --ag-border-color: #f1f5f9;
            --ag-row-border-color: #f1f5f9;
            --ag-header-column-separator-display: none;
            --ag-cell-horizontal-padding: 18px;
            --ag-grid-size: 6px;
            --ag-list-item-height: 32px;
            --ag-borders: none;
            --ag-borders-critical: solid 1px;
            --ag-header-height: 44px;
            --ag-row-height: 60px;
            --ag-checkbox-checked-color: #FFC60B;
            --ag-range-selection-border-color: #FFC60B;
            --ag-input-focus-border-color: #FFC60B;
        }

        .ag-theme-pcc .ag-header-cell-text {
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .ag-theme-pcc .ag-root-wrapper {
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #f1f5f9;
        }

        /* Cell renderers */
        .pcc-avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 12px;
            color: white;
            font-weight: 800;
            font-size: 12px;
            text-align: center;
            line-height: 1;
            flex-shrink: 0;
            box-shadow: 0 4px 12px -4px rgba(15, 23, 42, 0.25);
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
        }

        .pcc-badge.active {
            background: #ecfdf5;
            color: #047857;
        }

        .pcc-badge.active .dot {
            background: #10b981;
        }

        .pcc-badge.inactive {
            background: #fffbeb;
            color: #b45309;
        }

        .pcc-badge.inactive .dot {
            background: #f59e0b;
        }

        .pcc-badge.blocked {
            background: #fef2f2;
            color: #b91c1c;
        }

        .pcc-badge.blocked .dot {
            background: #ef4444;
        }

        .pcc-action-btn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            height: 30px;
            padding: 0 12px;
            border-radius: 999px;
            font-size: 11.5px;
            font-weight: 700;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all .15s ease;
        }

        .pcc-action-btn.view {
            background: #0f172a;
            color: white;
        }

        .pcc-action-btn.view:hover {
            background: #334155;
        }

        .pcc-action-btn.block {
            background: #fef2f2;
            color: #b91c1c;
            border-color: #fecaca;
        }

        .pcc-action-btn.block:hover {
            background: #fee2e2;
        }

        .pcc-action-btn.unblock {
            background: #ecfdf5;
            color: #047857;
            border-color: #a7f3d0;
        }

        .pcc-action-btn.unblock:hover {
            background: #d1fae5;
        }

        .pcc-action-btn.activate {
            background: #FFC60B;
            color: #1f2937;
            border-color: #facc15;
        }

        .pcc-action-btn.activate:hover {
            background: #fbbf24;
        }
    </style>

    <div class="flex flex-col gap-6">

        {{-- ─────────────── Page header ─────────────── --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div class="space-y-1">
                <nav class="flex items-center gap-1.5 text-[11.5px] font-semibold text-slate-400">
                    <span>Administration</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3 w-3">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                    <span class="text-slate-700">Clients</span>
                </nav>
                <h1 class="font-display text-[26px] font-black tracking-tight text-slate-900">Clients</h1>
                <p class="text-[13px] text-slate-500">
                    Vue d'ensemble de votre base clients, activité et points de fidélité.
                </p>
            </div>
        </div>

        {{-- ─────────────── Stat tiles ─────────────── --}}
        @php
        $stats = [
        [
        'label' => 'Total clients',
        'value' => $clients->count(),
        'delta' => '+12.5%',
        'sub' => 'vs mois dernier',
        'accent' => '#FFC60B',
        'accent_soft' => 'rgba(255,198,11,0.18)',
        'sparkline' => 'M0,28 C12,26 22,22 34,18 C46,14 58,16 70,10 C82,5 90,4 100,2',
        'icon' => '
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
        <circle cx="9" cy="7" r="4" />
        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
        <path d="M16 3.13a4 4 0 0 1 0 7.75" />',
        ],
        [
        'label' => 'Clients actifs',
        'value' => $activeCount,
        'delta' => '+8.3%',
        'sub' => 'vs mois dernier',
        'accent' => '#10b981',
        'accent_soft' => 'rgba(16,185,129,0.18)',
        'sparkline' => 'M0,26 C12,22 22,18 34,14 C46,10 58,12 70,8 C82,4 90,6 100,3',
        'icon' => '
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
        <circle cx="9" cy="7" r="4" />
        <polyline points="16 11 18 13 22 9" />',
        ],
        [
        'label' => 'Nouveaux ce mois',
        'value' => $newCount,
        'delta' => '+15.2%',
        'sub' => 'vs mois dernier',
        'accent' => '#3b82f6',
        'accent_soft' => 'rgba(59,130,246,0.18)',
        'sparkline' => 'M0,30 C12,28 22,24 34,18 C46,12 58,14 70,8 C82,4 90,6 100,3',
        'icon' => '
        <polygon
            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />',
        ],
        [
        'label' => 'Points distribués',
        'value' => $totalPoints,
        'delta' => '+18.7%',
        'sub' => 'vs mois dernier',
        'accent' => '#a855f7',
        'accent_soft' => 'rgba(168,85,247,0.18)',
        'sparkline' => 'M0,28 C12,24 22,22 34,16 C46,10 58,12 70,6 C82,2 90,4 100,1',
        'icon' => '
        <polyline points="20 12 20 22 4 22 4 12" />
        <rect x="2" y="7" width="20" height="5" />
        <line x1="12" y1="22" x2="12" y2="7" />
        <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z" />
        <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z" />',
        ],
        ];
        @endphp
        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
            @foreach($stats as $s)
            <div
                class="group overflow-hidden rounded-2xl shadow-sm ring-1 ring-slate-200 transition duration-300 hover:shadow-lg hover:ring-transparent">
                {{-- Colored top half --}}
                <div class="relative flex items-center justify-between px-5 py-5 overflow-hidden"
                    style="background: linear-gradient(135deg, {{ $s['accent'] }}ee 0%, {{ $s['accent'] }} 100%);">
                    {{-- Big faded number watermark --}}
                    <span
                        class="pointer-events-none absolute -right-2 -top-2 select-none font-display text-[72px] font-black leading-none tracking-tighter text-white/10">
                        {{ $loop->iteration }}
                    </span>
                    <p class="font-display text-[38px] font-black leading-none tracking-tight text-white">
                        {{ number_format($s['value'], 0, ',', ' ') }}
                    </p>
                    <svg viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.7)" stroke-width="1.6"
                        stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 shrink-0">
                        {!! $s['icon'] !!}
                    </svg>
                </div>

                {{-- White bottom half --}}
                <div class="flex items-center justify-between bg-white px-5 py-3">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-widest text-slate-500">
                            {{ $s['label'] }}
                        </p>
                        <div class="mt-1 flex items-center gap-1 text-[11px]">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.8"
                                stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3">
                                <polyline points="6 15 12 9 18 15" />
                            </svg>
                            <span class="font-bold text-emerald-600">{{ $s['delta'] }}</span>
                            <span class="text-slate-400">{{ $s['sub'] }}</span>
                        </div>
                    </div>
                    {{-- Mini sparkline --}}
                    <svg viewBox="0 0 80 24" width="52" height="18" fill="none"
                        class="opacity-60 transition group-hover:opacity-100">
                        <path d="{{ $s['sparkline'] }}" stroke="{{ $s['accent'] }}" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" transform="scale(0.8,0.66)" />
                    </svg>
                </div>
            </div>
            @endforeach
        </div>

        {{-- ─────────────── Alerts ─────────────── --}}
        @if(session('success'))
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

        {{-- ─────────────── Grid toolbar ─────────────── --}}
        <div class="flex flex-wrap items-center gap-3">
            <label class="relative flex h-11 min-w-[260px] flex-1 items-center md:max-w-md">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                    class="pointer-events-none absolute left-4 h-4 w-4 text-slate-400">
                    <circle cx="11" cy="11" r="7" />
                    <path d="m20 20-3.5-3.5" />
                </svg>
                <input type="search" id="pcc-quick-filter" placeholder="Rechercher par nom, téléphone, email, code…"
                    class="h-full w-full rounded-full border border-slate-200 bg-white pl-11 pr-4 text-[13px] text-slate-700 shadow-sm focus:border-slate-300 focus:outline-none focus:ring-4 focus:ring-pcc-yellow/30">
            </label>

            <div class="ml-auto flex items-center gap-2">
                <button type="button" id="pcc-clear-filters"
                    class="inline-flex h-10 items-center gap-2 rounded-full border border-slate-200 bg-white px-4 text-[12.5px] font-semibold text-slate-600 transition hover:bg-slate-50">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4">
                        <path d="M3 6h18M8 12h13M11 18h10" />
                    </svg>
                    Réinitialiser
                </button>
                <button type="button" id="pcc-autosize"
                    class="inline-flex h-10 items-center gap-2 rounded-full border border-slate-200 bg-white px-4 text-[12.5px] font-semibold text-slate-600 transition hover:bg-slate-50">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4">
                        <path d="M3 12h18M3 6h18M3 18h18" />
                    </svg>
                    Ajuster colonnes
                </button>
                <button type="button" id="pcc-export-csv"
                    class="inline-flex h-10 items-center gap-2 rounded-full bg-slate-900 px-4 text-[12.5px] font-bold text-white transition hover:bg-slate-700">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" y1="15" x2="12" y2="3" />
                    </svg>
                    Exporter CSV
                </button>
            </div>
        </div>

        {{-- ─────────────── AG Grid ─────────────── --}}
        <div id="pcc-clients-grid" class="ag-theme-quartz ag-theme-pcc" style="height: 640px; width: 100%;"></div>
    </div>

    {{-- Toast container --}}
    <div id="pcc-toast"
        class="pointer-events-none fixed top-6 left-1/2 z-50 flex flex-col items-center gap-3 -translate-x-1/2"></div>

    @php
    $rowData = $clients->map(fn ($c) => [
        'id' => $c->id,
        'company_name' => $c->company_name,
        'email' => $c->email,
        'phone' => $c->phone,
        'pcc_customer_code' => $c->pcc_customer_code,
        'points_balance' => (int) $c->points_balance,
        'status' => $c->status,
        'created_at' => optional($c->created_at)->toIso8601String(),
        'view_url' => route('clients.show', $c),
        'activate_url' => route('clients.activate', $c),
        'block_url' => route('clients.block', $c),
        'unblock_url' => route('clients.unblock', $c),
    ])->values();
    @endphp

    <script>
        (function () {
            const LICENSE = @json($aggridLicense);
            const ROW_DATA = @json($rowData);
            const CSRF = '{{ csrf_token() }}';

            /* ── Toast ── */
            function showToast(msg, type) {
                const bg   = type === 'error' ? 'background:#dc2626' : 'background:#059669';
                const icon = type === 'error'
                    ? '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>'
                    : '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>';
                const t = document.createElement('div');
                t.style.cssText = `pointer-events:auto;display:flex;align-items:center;gap:10px;border-radius:16px;padding:10px 18px;font-size:13px;font-weight:600;color:#fff;box-shadow:0 8px 30px -8px rgba(0,0,0,.35);transition:all .3s ease;transform:translateY(12px);opacity:0;${bg}`;
                t.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" width="16" height="16" style="flex-shrink:0">${icon}</svg><span>${msg}</span>`;
                document.getElementById('pcc-toast').appendChild(t);
                requestAnimationFrame(() => requestAnimationFrame(() => { t.style.transform = 'translateY(0)'; t.style.opacity = '1'; }));
                setTimeout(() => { t.style.transform = 'translateY(12px)'; t.style.opacity = '0'; setTimeout(() => t.remove(), 300); }, 3500);
            }

            if (LICENSE && window.agGrid && agGrid.LicenseManager) {
                agGrid.LicenseManager.setLicenseKey(LICENSE);
            }

            const PALETTE = [
                'linear-gradient(135deg,#fb923c,#f97316)',
                'linear-gradient(135deg,#38bdf8,#3b82f6)',
                'linear-gradient(135deg,#34d399,#059669)',
                'linear-gradient(135deg,#a78bfa,#8b5cf6)',
                'linear-gradient(135deg,#2dd4bf,#06b6d4)',
                'linear-gradient(135deg,#f472b6,#ec4899)',
                'linear-gradient(135deg,#fbbf24,#eab308)',
                'linear-gradient(135deg,#fb7185,#ef4444)',
            ];

            const STATUS_LABEL = { active: 'Actif', inactive: 'Inactif', blocked: 'Bloqué' };

            function escapeHtml(s) {
                return String(s ?? '').replace(/[&<>"']/g, c => ({
                    '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
                }[c]));
            }

            function hash(str) {
                let h = 0;
                for (let i = 0; i < str.length; i++) { h = ((h << 5) - h) + str.charCodeAt(i); h |= 0; }
                return Math.abs(h);
            }

            const columnDefs = [
                {
                    headerName: 'Client',
                    field: 'company_name',
                    minWidth: 260,
                    flex: 1.6,
                    pinned: 'left',
                    filter: 'agTextColumnFilter',
                    cellRenderer: (p) => {
                        const name = escapeHtml(p.value || '');
                        const initials = (p.value || '??').substring(0, 2).toUpperCase();
                        const grad = PALETTE[hash(p.value || '') % PALETTE.length];
                        return `
                            <div style="display:flex;align-items:center;gap:12px;height:100%;">
                                <span class="pcc-avatar" style="background:${grad}">${escapeHtml(initials)}</span>
                                <div style="line-height:1.25;">
                                    <div style="font-weight:700;color:#0f172a;">${name}</div>
                                    <div style="font-size:11px;color:#94a3b8;">Entreprise</div>
                                </div>
                            </div>`;
                    },
                },
                {
                    headerName: 'Téléphone',
                    field: 'phone',
                    minWidth: 150,
                    flex: 1,
                    filter: 'agTextColumnFilter',
                },
                {
                    headerName: 'Email',
                    field: 'email',
                    minWidth: 220,
                    flex: 1.2,
                    filter: 'agTextColumnFilter',
                },
                {
                    headerName: 'Code PCC',
                    field: 'pcc_customer_code',
                    minWidth: 130,
                    filter: 'agTextColumnFilter',
                    valueFormatter: p => p.value || '—',
                    cellStyle: { fontFamily: 'ui-monospace, SFMono-Regular, Menlo, monospace', color: '#475569' },
                },
                {
                    headerName: 'Points',
                    field: 'points_balance',
                    minWidth: 130,
                    filter: 'agNumberColumnFilter',
                    type: 'rightAligned',
                    valueFormatter: p => new Intl.NumberFormat('fr-FR').format(p.value ?? 0) + ' pts',
                    cellStyle: { fontWeight: 700, color: '#0f172a' },
                },
                {
                    headerName: 'Statut',
                    field: 'status',
                    minWidth: 130,
                    filter: 'agSetColumnFilter',
                    filterParams: { values: ['active', 'inactive', 'blocked'], valueFormatter: p => STATUS_LABEL[p.value] || p.value },
                    cellRenderer: (p) => {
                        const cls = p.value || 'inactive';
                        const label = STATUS_LABEL[cls] || cls;
                        return `<span class="pcc-badge ${cls}"><span class="dot"></span>${escapeHtml(label)}</span>`;
                    },
                },
                {
                    headerName: 'Membre depuis',
                    field: 'created_at',
                    minWidth: 150,
                    filter: 'agDateColumnFilter',
                    valueFormatter: p => p.value
                        ? new Date(p.value).toLocaleDateString('fr-FR', { day: '2-digit', month: 'short', year: 'numeric' })
                        : '—',
                },
                {
                    headerName: 'Actions',
                    minWidth: 240,
                    pinned: 'right',
                    sortable: false,
                    filter: false,
                    suppressMenu: true,
                    cellRenderer: (p) => {
                        const d = p.data;
                        let toggle = '';
                        if (d.status === 'inactive') {
                            toggle = `<button type="button" class="pcc-action-btn activate" data-action="activate" data-url="${escapeHtml(d.activate_url)}">Activer</button>`;
                        } else if (d.status === 'blocked') {
                            toggle = `<button type="button" class="pcc-action-btn unblock" data-action="unblock" data-url="${escapeHtml(d.unblock_url)}">Débloquer</button>`;
                        } else {
                            toggle = `<button type="button" class="pcc-action-btn block"   data-action="block"   data-url="${escapeHtml(d.block_url)}">Bloquer</button>`;
                        }
                        return `
                            <div style="display:flex;align-items:center;gap:8px;height:100%;">
                                <a href="${escapeHtml(d.view_url)}" class="pcc-action-btn view">
                                    Voir
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" width="12" height="12"><path d="m9 18 6-6-6-6"/></svg>
                                </a>
                                ${toggle}
                            </div>`;
                    },
                },
            ];

            const gridOptions = {
                columnDefs,
                rowData: ROW_DATA,
                defaultColDef: {
                    sortable: true,
                    resizable: true,
                    filter: true,
                    floatingFilter: false,
                    suppressHeaderMenuButton: false,
                },
                animateRows: true,
                pagination: true,
                paginationPageSize: 20,
                paginationPageSizeSelector: [10, 20, 50, 100],
                rowSelection: { mode: 'multiRow', checkboxes: false, headerCheckbox: false },
                cellSelection: false,
                suppressContextMenu: false,
                sideBar: {
                    toolPanels: [
                        { id: 'columns', labelDefault: 'Colonnes', labelKey: 'columns', iconKey: 'columns', toolPanel: 'agColumnsToolPanel' },
                        { id: 'filters', labelDefault: 'Filtres', labelKey: 'filters', iconKey: 'filter',  toolPanel: 'agFiltersToolPanel' },
                    ],
                    defaultToolPanel: '',
                },
                statusBar: {
                    statusPanels: [
                        { statusPanel: 'agTotalAndFilteredRowCountComponent', align: 'left' },
                        { statusPanel: 'agSelectedRowCountComponent', align: 'center' },
                        { statusPanel: 'agAggregationComponent', align: 'right' },
                    ],
                },
                onCellClicked: function (params) {
                    const el = params.event.target.closest('button[data-action]');
                    if (!el) return;
                    const action = el.dataset.action;
                    const url    = el.dataset.url;
                    const name   = params.data?.company_name || 'ce client';
                    const verb   = { block: 'bloquer', unblock: 'débloquer', activate: 'activer' }[action] || action;
                    const iconMap  = { block: 'warning', unblock: 'question', activate: 'success' };
                    const colorMap = { block: '#ef4444', unblock: '#10b981', activate: '#FFC60B' };

                    Swal.fire({
                        title: 'Confirmation',
                        html: `Voulez-vous vraiment <strong>${verb}</strong> <strong>${escapeHtml(name)}</strong> ?`,
                        icon: iconMap[action] || 'question',
                        showCancelButton: true,
                        confirmButtonText: verb.charAt(0).toUpperCase() + verb.slice(1),
                        cancelButtonText: 'Annuler',
                        confirmButtonColor: colorMap[action] || '#0f172a',
                        cancelButtonColor: '#94a3b8',
                        customClass: { popup: 'rounded-2xl', confirmButton: 'font-bold', cancelButton: 'font-bold' },
                    }).then(result => {
                        if (!result.isConfirmed) return;

                        el.disabled = true;
                        el.style.opacity = '0.5';

                        fetch(url, {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json', 'Content-Type': 'application/json' },
                        })
                        .then(r => r.json())
                        .then(data => {
                            if (data.status) {
                                // Update row in AG Grid without page reload
                                params.node.setData({ ...params.data, status: data.status });
                                params.api.refreshCells({ rowNodes: [params.node], force: true });
                                showToast(data.message ?? 'Statut mis à jour.', 'success');
                            } else {
                                showToast(data.message ?? 'Une erreur est survenue.', 'error');
                                el.disabled = false; el.style.opacity = '';
                            }
                        })
                        .catch(() => {
                            showToast('Erreur de connexion.', 'error');
                            el.disabled = false; el.style.opacity = '';
                        });
                    });
                },
            };

            function boot() {
                const eGrid = document.getElementById('pcc-clients-grid');
                if (!eGrid) return;
                const api = agGrid.createGrid(eGrid, gridOptions);

                document.getElementById('pcc-quick-filter')
                    ?.addEventListener('input', (e) => api.setGridOption('quickFilterText', e.target.value));

                document.getElementById('pcc-clear-filters')
                    ?.addEventListener('click', () => {
                        api.setFilterModel(null);
                        api.setGridOption('quickFilterText', '');
                        const input = document.getElementById('pcc-quick-filter');
                        if (input) input.value = '';
                    });

                document.getElementById('pcc-autosize')
                    ?.addEventListener('click', () => {
                        const allCols = api.getColumns()?.map(c => c.getColId()) ?? [];
                        api.autoSizeColumns(allCols, false);
                    });

                document.getElementById('pcc-export-csv')
                    ?.addEventListener('click', () => api.exportDataAsCsv({
                        fileName: 'clients-pcc-' + new Date().toISOString().slice(0, 10) + '.csv',
                        columnKeys: ['company_name', 'phone', 'email', 'pcc_customer_code', 'points_balance', 'status', 'created_at'],
                    }));
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', boot);
            } else {
                boot();
            }
        })();
    </script>
</x-app-layout>