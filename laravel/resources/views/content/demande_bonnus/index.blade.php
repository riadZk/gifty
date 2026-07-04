<x-app-layout>

    <style>
        /* ── Stat cards (same as clients page) ── */
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

        .c-red {
            background: linear-gradient(135deg, #ef4444, #b91c1c);
        }

        /* ── Request cards ── */
        .req-card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 16px;
        }

        @keyframes cardIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .req-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            overflow: hidden;
            transition: transform .18s, box-shadow .18s, border-color .18s;
            box-shadow: 0 1px 3px rgba(15, 23, 42, .06);
            animation: cardIn .35s ease both;
        }

        .req-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px -8px rgba(15, 23, 42, .18);
        }

        /* Colored top strip */
        .req-card-accent {
            height: 4px;
        }

        /* Card sections */
        .req-card-body {
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 13px;
        }

        .req-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .req-ref {
            font-family: 'Courier New', monospace;
            font-size: 10.5px;
            font-weight: 700;
            background: #f1f5f9;
            color: #64748b;
            padding: 3px 8px;
            border-radius: 6px;
            letter-spacing: .03em;
        }

        /* Bonus block */
        .req-card-bonus {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .req-bonus-thumb {
            width: 52px;
            height: 52px;
            border-radius: 13px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .req-bonus-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .req-bonus-name {
            font-size: 13.5px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
        }

        .req-bonus-sub {
            font-size: 11px;
            font-weight: 600;
            color: #94a3b8;
            margin-top: 2px;
        }

        .req-pts-wrap {
            text-align: right;
            flex-shrink: 0;
        }

        .req-pts {
            font-size: 22px;
            font-weight: 900;
            color: #0f172a;
            line-height: 1;
        }

        .req-pts-label {
            font-size: 10px;
            font-weight: 600;
            color: #94a3b8;
            margin-top: 1px;
        }

        /* Footer */
        .req-card-footer {
            display: flex;
            align-items: center;
            gap: 10px;
            padding-top: 13px;
            border-top: 1px solid #f1f5f9;
        }

        .req-avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 9px;
            color: white;
            font-weight: 800;
            font-size: 11px;
            flex-shrink: 0;
        }

        .req-client-name {
            font-size: 12.5px;
            font-weight: 700;
            color: #334155;
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .req-client-email {
            font-size: 10.5px;
            color: #94a3b8;
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .req-date {
            font-size: 11px;
            font-weight: 600;
            color: #94a3b8;
            white-space: nowrap;
        }

        .req-view-btn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            height: 30px;
            padding: 0 13px;
            background: #0f172a;
            color: #fff;
            font-size: 11.5px;
            font-weight: 700;
            border-radius: 999px;
            text-decoration: none;
            transition: background .15s;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .req-view-btn:hover {
            background: #334155;
        }

        /* Status badge */
        .req-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            line-height: 1;
        }

        .req-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .req-badge.pending {
            background: #fffbeb;
            color: #b45309;
        }

        .req-badge.pending .dot {
            background: #f59e0b;
        }

        .req-badge.approved {
            background: #ecfdf5;
            color: #047857;
        }

        .req-badge.approved .dot {
            background: #10b981;
        }

        .req-badge.rejected {
            background: #fef2f2;
            color: #b91c1c;
        }

        .req-badge.rejected .dot {
            background: #ef4444;
        }

        .req-badge.delivered {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .req-badge.delivered .dot {
            background: #3b82f6;
        }

        /* Loading spinner */
        .pcc-spinner {
            display: none;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            padding: 32px 0;
        }

        .pcc-spinner.active {
            display: flex;
        }

        .pcc-spinner-ring {
            width: 32px;
            height: 32px;
            border: 3px solid #e2e8f0;
            border-top-color: #fbbf24;
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Empty state */
        .pcc-empty {
            display: none;
            flex-direction: column;
            align-items: center;
            padding: 64px 24px;
            gap: 12px;
        }

        .pcc-empty.active {
            display: flex;
        }

        /* Counter badge */
        .pcc-counter {
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
        }
    </style>

    <div class="flex flex-col gap-6">

        {{-- ─────── Page header ─────── --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div class="space-y-1">
                <nav class="flex items-center gap-1.5 text-[11.5px] font-semibold text-slate-400">
                    <span>{{ __('demandes.breadcrumb_loyalty') }}</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3 w-3">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                    <span class="text-slate-700">{{ __('demandes.page_title') }}</span>
                </nav>
                <h1 class=" text-[26px] font-black tracking-tight text-slate-900">{{ __('demandes.page_title') }}</h1>
                <p class="text-[13px] text-slate-500">{{ __('demandes.page_subtitle') }}
                </p>
            </div>
        </div>

        {{-- ─────── Insights ─────── --}}
        @php $segTotal = max($counts['total'], 1); @endphp
        <div class="stat-grid">

            {{-- Total --}}
            <div class="stat-card c-blue">
                <div class="glow"></div>
                <div class="glow b"></div>
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.9" class="h-5 w-5">
                        <rect x="3" y="3" width="18" height="18" rx="3" />
                        <path d="M9 9h6M9 13h4" />
                    </svg>
                </div>
                <div class="stat-val">{{ number_format($counts['total']) }}</div>
                <div class="stat-label">{{ __('demandes.stat_total') }}</div>
                <div class="stat-sub">{{ __('demandes.stat_total_sub') }}</div>
            </div>

            {{-- Pending --}}
            <div class="stat-card c-amber">
                <div class="glow"></div>
                <div class="glow b"></div>
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.9" class="h-5 w-5">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                </div>
                <div class="stat-val">{{ number_format($counts['pending']) }}</div>
                <div class="stat-label">{{ __('demandes.stat_pending') }}</div>
                <div class="stat-sub">
                    {{ str_replace(':pct', round(($counts['pending'] / $segTotal) * 100), __('demandes.stat_pending_sub')) }}
                </div>
            </div>

            {{-- Approved + Delivered --}}
            <div class="stat-card c-green">
                <div class="glow"></div>
                <div class="glow b"></div>
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.9" class="h-5 w-5">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </div>
                <div class="stat-val">{{ number_format($counts['approved'] + $counts['delivered']) }}</div>
                <div class="stat-label">{{ __('demandes.stat_approved_delivered') }}</div>
                <div class="stat-sub">
                    {{ str_replace(':rate', $stats['approvalRate'], __('demandes.stat_approved_sub')) }}</div>
            </div>

            {{-- Rejected --}}
            <div class="stat-card c-violet">
                <div class="glow"></div>
                <div class="glow b"></div>
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.9" class="h-5 w-5">
                        <polygon
                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                    </svg>
                </div>
                <div class="stat-val">{{ number_format($stats['pendingPoints']) }}</div>
                <div class="stat-label">{{ __('demandes.stat_points_pending') }}</div>
                <div class="stat-sub">
                    {{ str_replace(':count', number_format($counts['rejected']), __('demandes.stat_rejected_sub')) }}
                </div>
            </div>

        </div>

        {{-- ─────── Toolbar ─────── --}}
        <div class="flex flex-wrap items-center gap-3">
            <label class="relative flex h-11 min-w-[240px] flex-1 items-center md:max-w-md">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                    class="pointer-events-none absolute left-4 h-4 w-4 text-slate-400">
                    <circle cx="11" cy="11" r="7" />
                    <path d="m20 20-3.5-3.5" />
                </svg>
                <input type="search" id="pcc-quick-filter" placeholder="{{ __('demandes.search_placeholder') }}"
                    class="h-full w-full rounded-full border border-slate-200 bg-white pl-11 pr-4 text-[13px] text-slate-700 shadow-sm focus:border-slate-300 focus:outline-none focus:ring-4 focus:ring-pcc-yellow/30">
            </label>

            <div class="w-full md:w-56">
                <x-select2 name="status_filter" id="status_filter"
                    placeholder="{{ __('demandes.filter_placeholder') }}" :options="[
                        'pending' => __('demandes.status_pending'),
                        'approved' => __('demandes.status_approved'),
                        'rejected' => __('demandes.status_rejected'),
                        'delivered' => __('demandes.status_delivered'),
                    ]" :allowClear="true"
                    wrapperClass="!mb-0" />
            </div>

            <button type="button" id="pcc-clear-filters"
                class="inline-flex h-10 items-center gap-2 rounded-full border border-slate-200 bg-white px-4 text-[12.5px] font-semibold text-slate-600 transition hover:bg-slate-50">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4">
                    <path d="M3 6h18M8 12h13M11 18h10" />
                </svg>
                {{ __('demandes.btn_reset') }}
            </button>

            {{-- Live counter --}}
            <span class="pcc-counter ml-auto" id="pcc-counter">—</span>
        </div>

        {{-- ─────── Card grid ─────── --}}
        <div class="req-card-grid" id="pcc-card-grid"></div>

        {{-- Empty state --}}
        <div class="pcc-empty" id="pcc-empty">
            <svg viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" class="h-14 w-14">
                <rect x="3" y="3" width="18" height="18" rx="4" />
                <path d="M9 9h6M9 13h4" />
            </svg>
            <p class="text-[13px] font-semibold text-slate-400">{{ __('demandes.no_results') }}</p>
        </div>

        {{-- Loading spinner --}}
        <div class="pcc-spinner" id="pcc-spinner">
            <div class="pcc-spinner-ring"></div>
            <span class="text-[12px] font-semibold text-slate-400">{{ __('demandes.loading') }}</span>
        </div>

        {{-- Infinite scroll sentinel --}}
        <div id="pcc-sentinel" class="h-1"></div>

    </div>

    @push('scripts')
        <script>
            (function() {
                /* ─── Constants ─── */
                const INITIAL_ITEMS = @json($initialItems);
                const INITIAL_HAS_MORE = @json($hasMore);
                const TOTAL_UNFILTERED = @json($total);
                const FETCH_URL = @json(route('demandes.index'));
                const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

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

                const STATUS_CFG = {
                    pending: {
                        label: '{{ __('demandes.status_pending') }}',
                        cls: 'pending',
                        accent: 'linear-gradient(90deg,#f59e0b,#fbbf24)'
                    },
                    approved: {
                        label: '{{ __('demandes.status_approved') }}',
                        cls: 'approved',
                        accent: 'linear-gradient(90deg,#10b981,#34d399)'
                    },
                    delivered: {
                        label: '{{ __('demandes.status_delivered') }}',
                        cls: 'delivered',
                        accent: 'linear-gradient(90deg,#3b82f6,#60a5fa)'
                    },
                    rejected: {
                        label: '{{ __('demandes.status_rejected') }}',
                        cls: 'rejected',
                        accent: 'linear-gradient(90deg,#ef4444,#f87171)'
                    },
                };

                /* ─── State ─── */
                const state = {
                    page: 1,
                    hasMore: INITIAL_HAS_MORE,
                    loading: false,
                    q: '',
                    status: '',
                    shown: 0,
                    total: TOTAL_UNFILTERED
                };

                /* ─── DOM refs ─── */
                const grid = document.getElementById('pcc-card-grid');
                const spinner = document.getElementById('pcc-spinner');
                const empty = document.getElementById('pcc-empty');
                const sentinel = document.getElementById('pcc-sentinel');
                const counter = document.getElementById('pcc-counter');

                /* ─── Helpers ─── */
                function esc(s) {
                    return String(s ?? '').replace(/[&<>"']/g, c => ({
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&quot;',
                        "'": '&#39;'
                    } [c]));
                }

                function hash(str) {
                    let h = 0;
                    for (let i = 0; i < str.length; i++) {
                        h = ((h << 5) - h) + str.charCodeAt(i);
                        h |= 0;
                    }
                    return Math.abs(h);
                }

                function fmtDate(iso) {
                    if (!iso) return '—';
                    return new Date(iso).toLocaleDateString('fr-FR', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    });
                }

                function updateCounter() {
                    counter.textContent = state.total > 0 ?
                        state.shown + ' / ' + state.total + ' ' + (state.total > 1 ?
                            '{{ __('demandes.js_counter_plural') }}' : '{{ __('demandes.js_counter_singular') }}') :
                        '0 {{ __('demandes.js_counter_singular') }}';
                }

                /* ─── Card renderer ─── */
                function renderCard(item) {
                    const cfg = STATUS_CFG[item.status] || STATUS_CFG.pending;
                    const date = fmtDate(item.requested_at);
                    const pts = new Intl.NumberFormat('fr-FR').format(item.points_required);
                    const initials = (item.client_name || '??').substring(0, 2).toUpperCase();
                    const grad = PALETTE[hash(item.client_name || '') % PALETTE.length];

                    const thumbHtml = item.bonus_image ?
                        `<img src="${esc(item.bonus_image)}" alt="${esc(item.bonus_name)}">` :
                        `<svg viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5" width="22" height="22">
                     <path d="M20 12v10H4V12"/>
                     <path d="M22 7H2v5h20V7z"/>
                     <path d="M12 22V7"/>
                     <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/>
                     <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/>
                   </svg>`;

                    return `<div class="req-card" data-id="${item.id}">
  <div class="req-card-accent" style="background:${cfg.accent}"></div>
  <div class="req-card-body">
    <div class="req-card-header">
      <span class="req-ref">${esc(item.ref)}</span>
      <span class="req-badge ${cfg.cls}"><span class="dot"></span>${esc(cfg.label)}</span>
    </div>
    <div class="req-card-bonus">
      <div class="req-bonus-thumb">${thumbHtml}</div>
      <div style="flex:1;min-width:0;">
        <div class="req-bonus-name">${esc(item.bonus_name)}</div>
        <div class="req-bonus-sub">{{ __('demandes.js_loyalty_bonus') }}</div>
      </div>
      <div class="req-pts-wrap">
        <div class="req-pts">${pts}</div>
        <div class="req-pts-label">{{ __('demandes.js_pts_required') }}</div>
      </div>
    </div>
    <div class="req-card-footer">
      <span class="req-avatar" style="background:${grad}">${esc(initials)}</span>
      <div style="flex:1;min-width:0;">
        <div class="req-client-name">${esc(item.client_name)}</div>
        <div class="req-client-email">${esc(item.client_email)}</div>
      </div>
      <div style="display:flex;flex-direction:column;align-items:flex-end;gap:6px;flex-shrink:0;">
        <span class="req-date">${date}</span>
        <a href="${esc(item.show_url)}" class="req-view-btn">
          {{ __('demandes.js_view') }}
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="11" height="11"><path d="m9 18 6-6-6-6"/></svg>
        </a>
      </div>
    </div>
  </div>
</div>`;
                }

                /* ─── Append items to grid ─── */
                function appendItems(items) {
                    if (!items.length) return;
                    const frag = document.createDocumentFragment();
                    items.forEach((item, i) => {
                        const wrap = document.createElement('div');
                        wrap.innerHTML = renderCard(item);
                        const card = wrap.firstElementChild;
                        card.style.animationDelay = (i * 40) + 'ms';
                        frag.appendChild(card);
                    });
                    grid.appendChild(frag);
                    state.shown += items.length;
                    updateCounter();
                }

                /* ─── Fetch next page ─── */
                async function loadMore() {
                    if (state.loading || !state.hasMore) return;
                    state.loading = true;
                    spinner.classList.add('active');

                    try {
                        const params = new URLSearchParams({
                            page: state.page + 1
                        });
                        if (state.q) params.set('q', state.q);
                        if (state.status) params.set('status', state.status);

                        const res = await fetch(FETCH_URL + '?' + params.toString(), {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': CSRF,
                            },
                        });
                        const data = await res.json();

                        state.page = data.page;
                        state.hasMore = data.has_more;
                        state.total = data.total;

                        appendItems(data.items);

                        if (!state.hasMore) observer.disconnect();
                        if (state.shown === 0) {
                            empty.classList.add('active');
                        }
                    } catch (e) {
                        console.error('Fetch error', e);
                    } finally {
                        state.loading = false;
                        spinner.classList.remove('active');
                    }
                }

                /* ─── Reset + reload (after filter change) ─── */
                function resetAndLoad() {
                    state.page = 0;
                    state.hasMore = true;
                    state.shown = 0;
                    state.total = 0;
                    grid.innerHTML = '';
                    empty.classList.remove('active');
                    counter.textContent = '—';
                    observer.observe(sentinel);
                    loadMore();
                }

                /* ─── IntersectionObserver ─── */
                const observer = new IntersectionObserver(entries => {
                    if (entries[0].isIntersecting) loadMore();
                }, {
                    rootMargin: '300px'
                });

                /* ─── Boot: render initial items from PHP ─── */
                state.page = 1;
                state.hasMore = INITIAL_HAS_MORE;
                state.shown = 0;
                state.total = TOTAL_UNFILTERED;

                appendItems(INITIAL_ITEMS);
                if (!state.hasMore) {
                    observer.disconnect();
                } else {
                    observer.observe(sentinel);
                }
                if (INITIAL_ITEMS.length === 0) {
                    empty.classList.add('active');
                }

                /* ─── Search (debounced 300ms) ─── */
                let searchTimer;
                document.getElementById('pcc-quick-filter')?.addEventListener('input', e => {
                    clearTimeout(searchTimer);
                    searchTimer = setTimeout(() => {
                        state.q = e.target.value.trim();
                        resetAndLoad();
                    }, 300);
                });

                /* ─── Status filter (Select2) ─── */
                if (window.jQuery) {
                    jQuery('#status_filter').on('change', function() {
                        state.status = this.value || '';
                        resetAndLoad();
                    });
                }

                /* ─── Reset button ─── */
                document.getElementById('pcc-clear-filters')?.addEventListener('click', () => {
                    document.getElementById('pcc-quick-filter').value = '';
                    state.q = '';
                    state.status = '';
                    if (window.jQuery) jQuery('#status_filter').val(null).trigger('change.select2');
                    resetAndLoad();
                });

            })();
        </script>
    @endpush

</x-app-layout>
