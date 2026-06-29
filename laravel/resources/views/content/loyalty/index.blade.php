<x-app-layout>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community@32.3.3/styles/ag-grid.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community@32.3.3/styles/ag-theme-quartz.css">
    <script src="https://cdn.jsdelivr.net/npm/ag-grid-enterprise@32.3.3/dist/ag-grid-enterprise.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @php
        $levelsDesc = $levels->sortByDesc('required_points');
        $clientRows = $clients
            ->map(function ($c) use ($levelsDesc) {
                $level = $levelsDesc->first(fn($l) => $c->points_balance >= $l->required_points);
                return [
                    'id' => $c->id,
                    'company_name' => $c->company_name,
                    'contact_name' => $c->contact_name ?? '',
                    'email' => $c->email,
                    'phone' => $c->phone,
                    'pcc_customer_code' => $c->pcc_customer_code ?? '',
                    'points_balance' => (float) $c->points_balance,
                    'total_sales' => (float) $c->total_sales,
                    'status' => $c->status,
                    'created_at' => optional($c->created_at)->toIso8601String(),
                    'current_level' => $level
                        ? $level->name . ' (' . number_format($level->required_points) . ' pts)'
                        : null,
                    'view_url' => route('clients.show', $c),
                ];
            })
            ->values();

        $levelsJson = $levels
            ->map(
                fn($l) => [
                    'id' => $l->id,
                    'name' => $l->name,
                    'required_points' => (float) $l->required_points,
                    'reward_name' => $l->reward_name,
                    'reward_description' => $l->reward_description,
                    'is_active' => (bool) $l->is_active,
                    'sort_order' => $l->sort_order,
                    'image' => $l->image,
                ],
            )
            ->values();

        $settingsJson = [
            'currency' => $settings->currency,
            'amount_value' => (float) $settings->amount_value,
            'points_value' => (float) $settings->points_value,
            'annual_reset' => (bool) $settings->annual_reset,
            'updated_at' => optional($settings->updated_at)->format('d M Y \a\t H:i'),
        ];

        // ── Points Rules tab stats ──
        $totalClients = $clients->count();
        $totalPoints = $clients->sum('points_balance');
        $totalSales = $clients->sum('total_sales');
        $clientsWithPoints = $clients->where('points_balance', '>', 0)->count();

        // ── Bonus Levels tab stats ──
        $statsLevels = $levels->where('is_active', true);
        
    @endphp

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
            --ag-row-height: 62px;
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
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1),
                0 2px 4px -2px rgb(0 0 0 / 0.1);
            /* Tailwind shadow-md */
        }

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
        }

        .pcc-badge.active {
            background: #dcfce7;
            color: #15803d;
        }

        .pcc-badge.active .dot {
            background: #16a34a;
        }

        .pcc-badge.inactive {
            background: #fef9c3;
            color: #a16207;
        }

        .pcc-badge.inactive .dot {
            background: #ca8a04;
        }

        .pcc-badge.blocked {
            background: #fee2e2;
            color: #b91c1c;
        }

        .pcc-badge.blocked .dot {
            background: #ef4444;
        }

        .pcc-level-badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 9px;
            border-radius: 7px;
            font-size: 11px;
            font-weight: 700;
            line-height: 1.4;
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            white-space: nowrap;
        }

        .pcc-action-btn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            height: 30px;
            padding: 0 12px;
            border-radius: 9px;
            font-size: 11.5px;
            font-weight: 700;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all .15s;
        }

        .pcc-action-btn.view {
            background: #0f172a;
            color: #fff;
        }

        .pcc-action-btn.view:hover {
            background: #1e293b;
        }

        .pcc-action-btn.edit {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }

        .pcc-action-btn.edit:hover {
            background: #dbeafe;
        }

        .pcc-action-btn.delete {
            background: #fef2f2;
            color: #b91c1c;
            border-color: #fecaca;
        }

        .pcc-action-btn.delete:hover {
            background: #fee2e2;
        }

        .icon-only {
            width: 32px;
            height: 32px;
            padding: 0;
            justify-content: center;
        }

        /* ── Tabs (pill style) ── */
        .pcc-tabs {
            display: inline-flex;
            padding: 4px;
            background: #f1f5f9;
            border-radius: 14px;
            margin-bottom: 24px;
            gap: 4px;
        }

        .pcc-tab {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 20px;
            font-size: 13.5px;
            font-weight: 700;
            color: #64748b;
            cursor: pointer;
            border: none;
            background: none;
            border-radius: 10px;
            transition: all .18s;
        }

        .pcc-tab.active {
            color: #0f172a;
            background: #fff;
            box-shadow: 0 2px 8px -2px rgba(15, 23, 42, .12);
        }

        .pcc-tab:hover:not(.active) {
            color: #334155;
        }

        /* ── Stat cards (full-color gradients) ── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        @media (max-width:1024px) {
            .stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width:560px) {
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

        .stat-icon svg {
            stroke: #fff !important;
            fill: #fff !important;
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

        .c-pink {
            background: linear-gradient(135deg, #ec4899, #be185d);
        }

        .c-cyan {
            background: linear-gradient(135deg, #06b6d4, #0e7490);
        }

        .c-orange {
            background: linear-gradient(135deg, #fb7185, #e11d48);
        }

        .c-teal {
            background: linear-gradient(135deg, #2dd4bf, #0d9488);
        }

        /* ── Conversion card (light) ── */
        .conv-card {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            padding: 22px 26px;
            background: #fff;
            border: 1px solid #eef2f7;
            box-shadow: 0 1px 3px rgba(15, 23, 42, .04);
            display: flex;
            align-items: center;
            gap: 26px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        .conv-card .cb-icon {
            width: 58px;
            height: 58px;
            border-radius: 16px;
            background: linear-gradient(135deg, #fffbeb, #fef3c7);
            border: 1px solid #fde68a;
            display: grid;
            place-items: center;
            flex-shrink: 0;
        }

        .conv-card .cb-formula {
            font-size: 24px;
            font-weight: 900;
            letter-spacing: -.02em;
            color: #0f172a;
        }

        .conv-card .cb-tag {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: #d97706;
            margin-bottom: 4px;
        }

        .conv-card .cb-stat label {
            display: block;
            font-size: 10.5px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 3px;
        }

        .conv-card .cb-stat span {
            font-size: 15px;
            font-weight: 800;
            color: #0f172a;
        }

        .conv-card .cb-divider {
            width: 1px;
            height: 44px;
            background: #eef2f7;
        }

        /* ── Panel + toolbar ── */
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

        .pcc-tbtn.primary {
            background: var(--pcc);
            border-color: var(--pcc);
            color: #101820;
        }

        .pcc-tbtn.primary:hover {
            background: #f0b800;
        }

        /* ── Modals ── */
        .pcc-modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 60;
            background: rgba(15, 23, 42, .5);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .pcc-modal {
            background: #fff;
            border-radius: 22px;
            width: 100%;
            max-width: 540px;
            box-shadow: 0 30px 70px -15px rgba(15, 23, 42, .4);
            animation: modalIn .22s cubic-bezier(.2, .8, .3, 1);
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: scale(.95) translateY(10px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .pcc-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 22px 26px 18px;
            border-bottom: 1px solid #f1f5f9;
        }

        .pcc-modal-body {
            padding: 22px 26px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .pcc-modal-footer {
            padding: 18px 26px;
            border-top: 1px solid #f1f5f9;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .pcc-field label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .pcc-field input,
        .pcc-field select,
        .pcc-field textarea {
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 11px;
            padding: 10px 13px;
            font-size: 13px;
            color: #0f172a;
            outline: none;
            transition: all .15s;
        }

        .pcc-field input:focus,
        .pcc-field select:focus,
        .pcc-field textarea:focus {
            border-color: var(--pcc);
            box-shadow: 0 0 0 4px rgba(255, 198, 11, .16);
        }

        .pcc-field textarea {
            resize: vertical;
            min-height: 76px;
        }

        .pcc-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            height: 40px;
            padding: 0 20px;
            border-radius: 12px;
            background: var(--pcc);
            color: #101820;
            font-size: 13px;
            font-weight: 800;
            border: none;
            cursor: pointer;
        }

        .pcc-btn-primary:hover {
            background: #f0b800;
        }

        .pcc-btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            height: 40px;
            padding: 0 20px;
            border-radius: 12px;
            background: #f1f5f9;
            color: #475569;
            font-size: 13px;
            font-weight: 800;
            border: none;
            cursor: pointer;
        }



        /* ── Image dropzone ── */
        .img-drop {
            border: 2px dashed #e2e8f0;
            border-radius: 13px;
            padding: 20px;
            cursor: pointer;
            transition: all .18s;
            background: #fafafa;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100px;
        }

        .img-drop:hover,
        .img-drop.drag {
            border-color: var(--pcc);
            background: #fffbeb;
        }

        .img-drop input[type=file] {
            display: none;
        }

        .img-preview {
            position: relative;
            display: inline-block;
            margin-top: 10px;
        }

        .img-preview img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            display: block;
        }

        .img-preview .img-remove {
            position: absolute;
            top: -7px;
            right: -7px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #ef4444;
            color: #fff;
            border: none;
            cursor: pointer;
            display: grid;
            place-items: center;
            font-size: 12px;
            font-weight: 900;
            line-height: 1;
        }
    </style>

    {{-- Page header --}}
    <div class="mb-5 flex flex-wrap items-end justify-between gap-3">
        <div>
            <h1 class="text-[26px] font-black tracking-tight text-slate-900" id="page-title">Loyalty Settings</h1>
            <p class="text-[13px] text-slate-500 mt-0.5" id="page-sub">Configure points rules and manage bonus levels</p>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="pcc-tabs">
        <button class="pcc-tab active" onclick="switchTab('points-rules',this)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
                <circle cx="12" cy="12" r="10" />
                <path d="M12 6v6l4 2" />
            </svg>
            Points Rules
        </button>
        <button class="pcc-tab" onclick="switchTab('bonus-levels',this)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
                <path d="M12 2 15 8.5 22 9.5 17 14.5 18.5 21.5 12 18 5.5 21.5 7 14.5 2 9.5 9 8.5z" />
            </svg>
            Bonus Levels
        </button>
    </div>

    {{-- ══════════ TAB 1 — Points Rules ══════════ --}}
    <div id="tab-points-rules">

        {{-- Stat cards --}}
        <div class="stat-grid">
            <div class="stat-card c-blue">
                <div class="glow"></div>
                <div class="glow b"></div>
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.9" class="h-5 w-5">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <div class="stat-val">{{ number_format($totalClients) }}</div>
                <div class="stat-label">Total Clients</div>
                <div class="stat-sub">Registered members</div>
            </div>
            <div class="stat-card c-amber">
                <div class="glow"></div>
                <div class="glow b"></div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="h-5 w-5" fill="#fff">
                        <path
                            d="M385.5 132.8C393.1 119.9 406.9 112 421.8 112L424 112C446.1 112 464 129.9 464 152C464 174.1 446.1 192 424 192L350.7 192L385.5 132.8zM254.5 132.8L289.3 192L216 192C193.9 192 176 174.1 176 152C176 129.9 193.9 112 216 112L218.2 112C233.1 112 247 119.9 254.5 132.8zM344.1 108.5L320 149.5L295.9 108.5C279.7 80.9 250.1 64 218.2 64L216 64C167.4 64 128 103.4 128 152C128 166.4 131.5 180 137.6 192L96 192C78.3 192 64 206.3 64 224L64 256C64 273.7 78.3 288 96 288L544 288C561.7 288 576 273.7 576 256L576 224C576 206.3 561.7 192 544 192L502.4 192C508.5 180 512 166.4 512 152C512 103.4 472.6 64 424 64L421.8 64C389.9 64 360.3 80.9 344.1 108.4zM544 336L344 336L344 544L480 544C515.3 544 544 515.3 544 480L544 336zM296 336L96 336L96 480C96 515.3 124.7 544 160 544L296 544L296 336z" />
                    </svg>
                </div>
                <div class="stat-val">{{ number_format($totalPoints) }}</div>
                <div class="stat-label">Total Points Distributed</div>
                <div class="stat-sub">Across all clients</div>
            </div>
            <div class="stat-card c-violet">
                <div class="glow"></div>
                <div class="glow b"></div>
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.9" class="h-5 w-5">
                        <line x1="12" y1="1" x2="12" y2="23" />
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                    </svg>
                </div>
                <div class="stat-val">{{ number_format($totalSales, 0, ',', ' ') }} DH</div>
                <div class="stat-label">CA Total HT</div>
                <div class="stat-sub">Chiffre d'affaires cumulé</div>
            </div>
            <div class="stat-card c-green">
                <div class="glow"></div>
                <div class="glow b"></div>
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.9" class="h-5 w-5">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </div>
                <div class="stat-val">{{ number_format($clientsWithPoints) }}</div>
                <div class="stat-label">Clients avec points</div>
                <div class="stat-sub">{{ $totalClients ? round(($clientsWithPoints / $totalClients) * 100) : 0 }}%
                    engagés dans le programme</div>
            </div>
        </div>

        {{-- Conversion card --}}
        <div class="conv-card">
            <div class="cb-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="h-7 w-7" fill="#d97706">
                    <path
                        d="M385.5 132.8C393.1 119.9 406.9 112 421.8 112L424 112C446.1 112 464 129.9 464 152C464 174.1 446.1 192 424 192L350.7 192L385.5 132.8zM254.5 132.8L289.3 192L216 192C193.9 192 176 174.1 176 152C176 129.9 193.9 112 216 112L218.2 112C233.1 112 247 119.9 254.5 132.8zM344.1 108.5L320 149.5L295.9 108.5C279.7 80.9 250.1 64 218.2 64L216 64C167.4 64 128 103.4 128 152C128 166.4 131.5 180 137.6 192L96 192C78.3 192 64 206.3 64 224L64 256C64 273.7 78.3 288 96 288L544 288C561.7 288 576 273.7 576 256L576 224C576 206.3 561.7 192 544 192L502.4 192C508.5 180 512 166.4 512 152C512 103.4 472.6 64 424 64L421.8 64C389.9 64 360.3 80.9 344.1 108.4zM544 336L344 336L344 544L480 544C515.3 544 544 515.3 544 480L544 336zM296 336L96 336L96 480C96 515.3 124.7 544 160 544L296 544L296 336z" />
                </svg>
            </div>
            <div class="cb-stat">
                <div class="cb-tag">Points Conversion</div>
                <div class="cb-formula" id="conv-formula-display">{{ $settings->amount_value }}
                    {{ $settings->currency }} = {{ $settings->points_value }} Points</div>
            </div>
            <div class="cb-divider hidden md:block"></div>
            <div class="cb-stat"><label>Amount Value</label><span
                    id="conv-amount-display">{{ number_format($settings->amount_value, 2) }}
                    {{ $settings->currency }}</span></div>
            <div class="cb-divider hidden md:block"></div>
            <div class="cb-stat"><label>Points Value</label><span
                    id="conv-points-display">{{ number_format($settings->points_value, 2) }}</span></div>
            <div class="cb-divider hidden md:block"></div>
            <div class="cb-stat"><label>Annual Reset</label><span>{{ $settings->annual_reset ? 'Yes' : 'No' }}</span>
            </div>
            <div class="cb-divider hidden md:block"></div>
            <div class="cb-stat">
                <label>Updated</label><span>{{ optional($settings->updated_at)->format('d M Y') ?? '—' }}</span>
            </div>
            <button type="button" id="btn-open-settings"
                class="ml-auto inline-flex items-center gap-2 h-10 px-5 rounded-xl bg-[var(--pcc)] text-[13px] font-extrabold text-[#101820] hover:bg-[#f0b800] transition">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                </svg>
                Edit Rules
            </button>
        </div>

        {{-- Clients panel --}}
        <div class="panel-head">
            <div>
                <div class="panel-title">Clients &amp; Points Summary</div>
                <div class="panel-subtitle">All clients with their points balance and current bonus level</div>
            </div>
            <div class="ml-auto flex items-center gap-2">
                <div class="pcc-search">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        class="h-4 w-4">
                        <circle cx="11" cy="11" r="7" />
                        <path d="m20 20-3.5-3.5" />
                    </svg>
                    <input type="search" id="clients-quick-filter" placeholder="Search clients…">
                </div>
                <button type="button" id="btn-clients-export" class="pcc-tbtn dark">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        class="h-4 w-4">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" y1="15" x2="12" y2="3" />
                    </svg>
                    Export
                </button>
            </div>
        </div>

        <div id="clients-grid" class="ag-theme-quartz ag-theme-pcc" style="height:560px;width:100%;"></div>
    </div>

    {{-- ══════════ TAB 2 — Bonus Levels ══════════ --}}
    <div id="tab-bonus-levels" style="display:none;">

        {{-- Stat cards --}}
        <div class="stat-grid">
            <div class="stat-card c-violet">
                <div class="glow"></div>
                <div class="glow b"></div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="h-5 w-5" fill="#fff">
                        <path
                            d="M385.5 132.8C393.1 119.9 406.9 112 421.8 112L424 112C446.1 112 464 129.9 464 152C464 174.1 446.1 192 424 192L350.7 192L385.5 132.8zM254.5 132.8L289.3 192L216 192C193.9 192 176 174.1 176 152C176 129.9 193.9 112 216 112L218.2 112C233.1 112 247 119.9 254.5 132.8zM344.1 108.5L320 149.5L295.9 108.5C279.7 80.9 250.1 64 218.2 64L216 64C167.4 64 128 103.4 128 152C128 166.4 131.5 180 137.6 192L96 192C78.3 192 64 206.3 64 224L64 256C64 273.7 78.3 288 96 288L544 288C561.7 288 576 273.7 576 256L576 224C576 206.3 561.7 192 544 192L502.4 192C508.5 180 512 166.4 512 152C512 103.4 472.6 64 424 64L421.8 64C389.9 64 360.3 80.9 344.1 108.4zM544 336L344 336L344 544L480 544C515.3 544 544 515.3 544 480L544 336zM296 336L96 336L96 480C96 515.3 124.7 544 160 544L296 544L296 336z" />
                    </svg>
                </div>
                <div class="stat-val">{{ $statsLevels->count() }}</div>
                <div class="stat-label">Total Bonus Levels</div>
                <div class="stat-sub">Active levels</div>
            </div>
            <div class="stat-card c-green">
                <div class="glow"></div>
                <div class="glow b"></div>
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.9" class="h-5 w-5">
                        <path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z" />
                    </svg>
                </div>
                <div class="stat-val">
                    {{ $statsLevels->min('required_points') ? number_format((float) $statsLevels->min('required_points')) : '—' }}
                </div>
                <div class="stat-label">Lowest Required Points</div>
                <div class="stat-sub">{{ $statsLevels->sortBy('required_points')->first()?->name ?? '—' }}</div>
            </div>
            <div class="stat-card c-amber">
                <div class="glow"></div>
                <div class="glow b"></div>
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.9" class="h-5 w-5">
                        <circle cx="12" cy="8" r="6" />
                        <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11" />
                    </svg>
                </div>
                <div class="stat-val">
                    {{ $statsLevels->max('required_points') ? number_format((float) $statsLevels->max('required_points')) : '—' }}
                </div>
                <div class="stat-label">Highest Required Points</div>
                <div class="stat-sub">{{ $statsLevels->sortByDesc('required_points')->first()?->name ?? '—' }}</div>
            </div>
            <div class="stat-card c-cyan">
                <div class="glow"></div>
                <div class="glow b"></div>
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.9" class="h-5 w-5">
                        <polyline points="20 12 20 22 4 22 4 12" />
                        <rect x="2" y="7" width="20" height="5" />
                        <line x1="12" y1="22" x2="12" y2="7" />
                        <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z" />
                        <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z" />
                    </svg>
                </div>
                <div class="stat-val">{{ $levels->count() }}</div>
                <div class="stat-label">Total Rewards</div>
                <div class="stat-sub">Available rewards</div>
            </div>
        </div>

        {{-- Levels panel --}}
        <div class="panel-head">
            <div>
                <div class="panel-title">Bonus Levels</div>
                <div class="panel-subtitle">Define reward tiers and the points required to reach them</div>
            </div>
            <div class="ml-auto flex items-center gap-2">
                <div class="pcc-search">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        class="h-4 w-4">
                        <circle cx="11" cy="11" r="7" />
                        <path d="m20 20-3.5-3.5" />
                    </svg>
                    <input type="search" id="levels-quick-filter" placeholder="Search levels…">
                </div>
                <button type="button" id="btn-levels-export" class="pcc-tbtn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        class="h-4 w-4">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" y1="15" x2="12" y2="3" />
                    </svg>
                    Export
                </button>
                <button type="button" id="btn-open-level" class="pcc-tbtn primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"
                        class="h-4 w-4">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Add Bonus Level
                </button>
            </div>
        </div>

        <div id="levels-grid" class="ag-theme-quartz ag-theme-pcc" style="height:460px;width:100%;"></div>
    </div>

    {{-- Toast --}}
    <div id="pcc-toast"
        class="pointer-events-none fixed top-6 left-1/2 z-50 flex flex-col items-center gap-3 -translate-x-1/2"></div>

    {{-- Modal: Edit Rules --}}
    <div id="modal-settings" class="pcc-modal-backdrop" style="display:none;">
        <div class="pcc-modal">
            <div class="pcc-modal-header">
                <span class="text-[16px] font-black text-slate-900">Edit Points Rules</span>
                <button type="button" data-close="modal-settings"
                    class="grid h-8 w-8 place-items-center rounded-full hover:bg-slate-100 text-slate-400">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                        class="h-4 w-4">
                        <path d="M18 6 6 18M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="form-settings">
                <div class="pcc-modal-body">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="pcc-field"><label>Amount Value</label><input type="number" id="s-amount"
                                step="0.01" min="0.01" required></div>
                        <div class="pcc-field"><label>Points Value</label><input type="number" id="s-points"
                                step="0.01" min="0.01" required></div>
                    </div>
                    <div class="pcc-field">
                        <label>Currency</label>
                        <select id="s-currency">
                            <option value="MAD">MAD — Dirham marocain</option>
                            <option value="EUR">EUR — Euro</option>
                            <option value="USD">USD — Dollar</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="s-reset" class="h-4 w-4 rounded accent-[#FFC60B]">
                        <label for="s-reset" class="text-[13px] font-semibold text-slate-700">Annual points
                            reset</label>
                    </div>
                    <div
                        class="rounded-xl bg-amber-50 border border-amber-100 px-4 py-3 text-[12.5px] text-amber-800 font-bold">
                        Formula: <span id="formula-preview">—</span>
                    </div>
                </div>
                <div class="pcc-modal-footer">
                    <button type="button" data-close="modal-settings" class="pcc-btn-secondary">Cancel</button>
                    <button type="submit" class="pcc-btn-primary">Save Rules</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal: Add / Edit Bonus Level --}}
    <div id="modal-level" class="pcc-modal-backdrop" style="display:none;">
        <div class="pcc-modal">
            <div class="pcc-modal-header">
                <span id="modal-level-title" class="text-[16px] font-black text-slate-900">Add Bonus Level</span>
                <button type="button" data-close="modal-level"
                    class="grid h-8 w-8 place-items-center rounded-full hover:bg-slate-100 text-slate-400">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                        class="h-4 w-4">
                        <path d="M18 6 6 18M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="form-level">
                <input type="hidden" id="l-id">
                <div class="pcc-modal-body">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="pcc-field col-span-2"><label>Bonus Name</label><input type="text"
                                id="l-name" required maxlength="100" placeholder="e.g. Gold"></div>
                        <div class="pcc-field"><label>Required Points</label><input type="number" id="l-points"
                                step="0.01" min="0" required></div>
                        <div class="pcc-field"><label>Sort Order</label><input type="number" id="l-order"
                                min="0" value="0"></div>
                        <div class="pcc-field col-span-2">
                            <label>Reward Name</label><input type="text" id="l-reward" required maxlength="255"
                                placeholder="e.g. 10% Discount">
                        </div>

                    </div>
                    {{-- Image full width --}}
                    <div class="pcc-field col-span-2">
                        <label>Image</label>
                        <div class="img-drop" id="l-img-drop" onclick="document.getElementById('l-image').click()">
                            <input type="file" id="l-image" accept="image/jpeg,image/png,image/webp,image/gif">
                            <div id="l-img-placeholder">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5"
                                    class="h-8 w-8 mx-auto mb-2">
                                    <rect x="3" y="3" width="18" height="18" rx="2" />
                                    <circle cx="8.5" cy="8.5" r="1.5" />
                                    <polyline points="21 15 16 10 5 21" />
                                </svg>
                                <p class="text-[12px] text-slate-400 font-semibold">Click to upload</p>
                                <p class="text-[11px] text-slate-300 mt-0.5">JPG, PNG, WEBP — max 2 MB</p>
                            </div>
                            <div id="l-img-preview" class="img-preview" style="display:none;">
                                <img id="l-img-thumb" src="" alt="Preview">
                                <button type="button" class="img-remove" id="l-img-remove"
                                    onclick="event.stopPropagation();clearImage()" title="Remove">×</button>
                            </div>
                        </div>
                    </div>
                    {{-- Description full width --}}
                    <div class="pcc-field col-span-2">
                        <label>Description</label>
                        <textarea id="l-desc" placeholder="Optional details…"></textarea>
                    </div>

                    <div class="flex items-center gap-3 col-span-2">
                        <input type="checkbox" id="l-active" checked class="h-4 w-4 rounded accent-[#FFC60B]">
                        <label for="l-active" class="text-[13px] font-semibold text-slate-700">Active</label>
                    </div>
                </div>
                <div class="pcc-modal-footer">
                    <button type="button" data-close="modal-level" class="pcc-btn-secondary">Cancel</button>
                    <button type="submit" class="pcc-btn-primary">Save Level</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function() {
            const CSRF = '{{ csrf_token() }}';
            const URL_SETTINGS = '{{ route('loyalty.settings.update') }}';
            const URL_LEVELS = '{{ route('loyalty.levels.store') }}';
            const CLIENT_ROWS = @json($clientRows);
            let LEVELS = @json($levelsJson);
            let SETTINGS = @json($settingsJson);

            function esc(s) {
                return String(s ?? '').replace(/[&<>"']/g, c =>
                    ({
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
            const STATUS_LABEL = {
                active: 'Actif',
                inactive: 'Inactif',
                blocked: 'Bloqué'
            };

            function showToast(msg, type) {
                const bg = type === 'error' ? '#dc2626' : '#059669';
                const t = document.createElement('div');
                t.style.cssText =
                    `pointer-events:auto;display:flex;align-items:center;gap:10px;border-radius:14px;padding:11px 18px;font-size:13px;font-weight:700;color:#fff;box-shadow:0 8px 30px -8px rgba(0,0,0,.35);transition:all .3s;transform:translateY(12px);opacity:0;background:${bg}`;
                t.textContent = msg;
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

            // ── Tabs ──
            window.switchTab = function(tab, btn) {
                document.getElementById('tab-points-rules').style.display = tab === 'points-rules' ? '' : 'none';
                document.getElementById('tab-bonus-levels').style.display = tab === 'bonus-levels' ? '' : 'none';
                document.querySelectorAll('.pcc-tab').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                if (tab === 'bonus-levels' && levelsApi) setTimeout(() => levelsApi.sizeColumnsToFit(), 30);
                if (tab === 'points-rules' && clientsApi) setTimeout(() => clientsApi.sizeColumnsToFit(), 30);
            };

            // ── Modals ──
            function openModal(id) {
                document.getElementById(id).style.display = 'flex';
            }

            function closeModal(id) {
                document.getElementById(id).style.display = 'none';
            }
            document.querySelectorAll('[data-close]').forEach(btn =>
                btn.addEventListener('click', () => closeModal(btn.dataset.close)));
            document.querySelectorAll('.pcc-modal-backdrop').forEach(bd =>
                bd.addEventListener('click', e => {
                    if (e.target === bd) closeModal(bd.id);
                }));

            const defaultColDef = {
                sortable: true,
                resizable: true,
                filter: true
            };

            // ── Clients grid ──
            const clientColDefs = [{
                    headerName: 'Client',
                    field: 'company_name',
                    minWidth: 220,
                    flex: 1.5,
                    pinned: 'left',
                    filter: 'agTextColumnFilter',
                    cellRenderer: p => {
                        const name = esc(p.value || '');
                        const initials = (p.value || '??').substring(0, 2).toUpperCase();
                        const grad = PALETTE[hash(p.value || '') % PALETTE.length];
                        const sub = esc(p.data?.contact_name || '');
                        return `<div style="display:flex;align-items:center;gap:12px;height:100%;">
                        <span class="pcc-avatar" style="background:${grad}">${esc(initials)}</span>
                        <div style="line-height:1.3;"><div style="font-weight:700;color:#0f172a;">${name}</div>${sub?`<div style="font-size:11px;color:#94a3b8;">${sub}</div>`:''}</div>
                    </div>`;
                    },
                },
                {
                    headerName: 'Code PCC',
                    field: 'pcc_customer_code',
                    minWidth: 130,
                    filter: 'agTextColumnFilter',
                    valueFormatter: p => p.value || '—',
                    cellStyle: {
                        fontFamily: 'ui-monospace,monospace',
                        color: '#475569',
                        fontSize: '12px'
                    }
                },
                {
                    headerName: 'Email',
                    field: 'email',
                    minWidth: 200,
                    flex: 1.2,
                    filter: 'agTextColumnFilter'
                },
                {
                    headerName: 'Points Balance',
                    field: 'points_balance',
                    minWidth: 150,
                    filter: 'agNumberColumnFilter',
                    type: 'rightAligned',
                    valueFormatter: p => fmtNum(p.value ?? 0) + ' pts',
                    cellStyle: {
                        fontWeight: 800,
                        color: '#1d4ed8',
                        fontSize: '14px'
                    },
                },
                {
                    headerName: 'Total Achats HT',
                    field: 'total_sales',
                    minWidth: 160,
                    filter: 'agNumberColumnFilter',
                    type: 'rightAligned',
                    valueFormatter: p => fmtNum(p.value ?? 0) + ' MAD',
                    cellStyle: {
                        fontWeight: 700,
                        color: '#047857',
                        fontSize: '13px'
                    },
                },
                {
                    headerName: 'Current Bonus Level',
                    field: 'current_level',
                    minWidth: 180,
                    flex: 1,
                    filter: 'agTextColumnFilter',
                    cellRenderer: p => p.value ?
                        `<div style="display:flex;align-items:center;height:100%;"><span class="pcc-level-badge">${esc(p.value)}</span></div>` :
                        '<span style="color:#94a3b8;font-size:12px;">—</span>',
                },
                {
                    headerName: 'Statut',
                    field: 'status',
                    minWidth: 120,
                    filter: 'agSetColumnFilter',
                    filterParams: {
                        values: ['active', 'inactive', 'blocked'],
                        valueFormatter: p => STATUS_LABEL[p.value] || p.value
                    },
                    cellRenderer: p => {
                        const cls = p.value || 'inactive';
                        return `<span class="pcc-badge ${cls}"><span class="dot"></span>${esc(STATUS_LABEL[cls]||cls)}</span>`;
                    },
                },
                {
                    headerName: 'Membre depuis',
                    field: 'created_at',
                    minWidth: 150,
                    filter: 'agDateColumnFilter',
                    valueFormatter: p => p.value ? new Date(p.value).toLocaleDateString('fr-FR', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    }) : '—',
                },
                {
                    headerName: '',
                    minWidth: 80,
                    maxWidth: 90,
                    pinned: 'right',
                    sortable: false,
                    filter: false,
                    suppressMenu: true,
                    cellRenderer: p =>
                        `<div style="display:flex;align-items:center;height:100%;"><a href="${esc(p.data?.view_url||'#')}" class="pcc-action-btn view">Voir<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" width="12" height="12"><path d="m9 18 6-6-6-6"/></svg></a></div>`,
                },
            ];

            let clientsApi;

            function bootClientsGrid() {
                const el = document.getElementById('clients-grid');
                if (!el) return;
                clientsApi = agGrid.createGrid(el, {
                    columnDefs: clientColDefs,
                    rowData: CLIENT_ROWS,
                    defaultColDef,
                    animateRows: true,
                    pagination: true,
                    paginationPageSize: 20,
                    paginationPageSizeSelector: [10, 20, 50, 100],
                    rowSelection: {
                        mode: 'multiRow',
                        checkboxes: false,
                        headerCheckbox: false
                    },
                    cellSelection: false,
                    statusBar: {
                        statusPanels: [{
                            statusPanel: 'agTotalAndFilteredRowCountComponent',
                            align: 'left'
                        }, {
                            statusPanel: 'agAggregationComponent',
                            align: 'right'
                        }]
                    },
                });
                document.getElementById('clients-quick-filter')?.addEventListener('input', e => clientsApi
                    .setGridOption('quickFilterText', e.target.value));
                document.getElementById('btn-clients-export')?.addEventListener('click', () => clientsApi
                    .exportDataAsCsv({
                        fileName: 'loyalty-clients-' + new Date().toISOString().slice(0, 10) + '.csv',
                        columnKeys: ['company_name', 'pcc_customer_code', 'email', 'points_balance',
                            'current_level', 'status', 'created_at'
                        ],
                    }));
            }

            // ── Levels grid ──
            const levelColDefs = [{
                    headerName: 'Bonus Name',
                    field: 'name',
                    minWidth: 180,
                    flex: 1.2,
                    pinned: 'left',
                    filter: 'agTextColumnFilter',
                    cellRenderer: p => {
                        const sc = p.data?.is_active ? 'active' : 'inactive';
                        const lbl = p.data?.is_active ? 'Actif' : 'Inactif';
                        return `<div style="display:flex;align-items:center;gap:8px;height:100%;"><span style="font-weight:700;color:#0f172a;">${esc(p.value||'')}</span><span class="pcc-badge ${sc}" style="font-size:10px;padding:2px 8px;">${lbl}</span></div>`;
                    },
                },
                {
                    headerName: 'Required Points',
                    field: 'required_points',
                    minWidth: 160,
                    filter: 'agNumberColumnFilter',
                    type: 'rightAligned',
                    valueFormatter: p => fmtNum(p.value ?? 0),
                    cellStyle: {
                        fontWeight: 800,
                        color: '#1d4ed8',
                        fontSize: '15px'
                    }
                },
                {
                    headerName: 'Reward',
                    field: 'reward_name',
                    minWidth: 200,
                    flex: 1,
                    filter: 'agTextColumnFilter',
                    cellRenderer: p => {
                        const img = p.data?.image ?
                            `<img src="${esc(p.data.image)}" style="width:34px;height:34px;border-radius:10px;object-fit:cover;border:1px solid #f1f5f9;flex-shrink:0;">` :
                            `<div style="width:34px;height:34px;border-radius:10px;background:#f1f5f9;display:grid;place-items:center;flex-shrink:0;"><svg viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5" style="width:14px;height:14px;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div>`;
                        return `<div style="display:flex;align-items:center;gap:10px;height:100%;">${img}<span style="font-weight:600;font-size:13px;color:#0f172a;">${esc(p.value||'')}</span></div>`;
                    },
                },
                {
                    headerName: 'Description',
                    field: 'reward_description',
                    minWidth: 200,
                    flex: 1.5,
                    filter: 'agTextColumnFilter',
                    valueFormatter: p => p.value || '—',
                    cellStyle: {
                        color: '#64748b',
                        fontSize: '12px'
                    }
                },
                {
                    headerName: 'Statut',
                    field: 'is_active',
                    minWidth: 110,
                    filter: 'agSetColumnFilter',
                    filterParams: {
                        values: [true, false],
                        valueFormatter: p => p.value ? 'Actif' : 'Inactif'
                    },
                    cellRenderer: p => {
                        const cls = p.value ? 'active' : 'inactive';
                        return `<span class="pcc-badge ${cls}"><span class="dot"></span>${p.value?'Actif':'Inactif'}</span>`;
                    },
                },
                {
                    headerName: 'Sort',
                    field: 'sort_order',
                    minWidth: 80,
                    maxWidth: 100,
                    filter: 'agNumberColumnFilter',
                    type: 'rightAligned'
                },
                {
                    headerName: 'Actions',
                    minWidth: 130,
                    maxWidth: 150,
                    pinned: 'right',
                    sortable: false,
                    filter: false,
                    suppressMenu: true,
                    cellRenderer: p => `<div style="display:flex;align-items:center;gap:6px;height:100%;">
                    <button class="pcc-action-btn edit icon-only" data-action="edit" data-id="${p.data.id}" title="Edit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button>
                    <button class="pcc-action-btn delete icon-only" data-action="delete" data-id="${p.data.id}" title="Delete"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg></button>
                </div>`,
                },
            ];

            let levelsApi;

            function bootLevelsGrid() {
                const el = document.getElementById('levels-grid');
                if (!el) return;
                levelsApi = agGrid.createGrid(el, {
                    columnDefs: levelColDefs,
                    rowData: [...LEVELS],
                    defaultColDef,
                    animateRows: true,
                    pagination: true,
                    paginationPageSize: 10,
                    paginationPageSizeSelector: [10, 20, 50],
                    rowSelection: {
                        mode: 'multiRow',
                        checkboxes: false,
                        headerCheckbox: false
                    },
                    cellSelection: false,
                    onCellClicked: params => {
                        const btn = params.event.target.closest('button[data-action]');
                        if (!btn) return;
                        const {
                            action,
                            id
                        } = btn.dataset;
                        if (action === 'edit') openLevelModal(LEVELS.find(l => l.id == id));
                        if (action === 'delete') deleteLevel(id);
                    },
                });
                document.getElementById('levels-quick-filter')?.addEventListener('input', e => levelsApi.setGridOption(
                    'quickFilterText', e.target.value));
                document.getElementById('btn-levels-export')?.addEventListener('click', () => levelsApi
                    .exportDataAsCsv({
                        fileName: 'bonus-levels-' + new Date().toISOString().slice(0, 10) + '.csv',
                        columnKeys: ['name', 'required_points', 'reward_name', 'reward_description',
                            'is_active', 'sort_order'
                        ],
                    }));
            }

            function refreshLevelsGrid() {
                if (levelsApi) levelsApi.setGridOption('rowData', [...LEVELS]);
            }

            // ── Settings modal ──
            function updateFormula() {
                const a = parseFloat(document.getElementById('s-amount').value) || 0;
                const p = parseFloat(document.getElementById('s-points').value) || 0;
                const c = document.getElementById('s-currency').value;
                document.getElementById('formula-preview').textContent = `${a} ${c} = ${p} pt${p !== 1 ? 's' : ''}`;
            }
            ['s-amount', 's-points', 's-currency'].forEach(id => document.getElementById(id)?.addEventListener('input',
                updateFormula));
            document.getElementById('btn-open-settings').addEventListener('click', () => {
                document.getElementById('s-amount').value = SETTINGS.amount_value;
                document.getElementById('s-points').value = SETTINGS.points_value;
                document.getElementById('s-currency').value = SETTINGS.currency;
                document.getElementById('s-reset').checked = SETTINGS.annual_reset;
                updateFormula();
                openModal('modal-settings');
            });
            document.getElementById('form-settings').addEventListener('submit', async e => {
                e.preventDefault();
                const body = {
                    amount_value: parseFloat(document.getElementById('s-amount').value),
                    points_value: parseFloat(document.getElementById('s-points').value),
                    currency: document.getElementById('s-currency').value,
                    annual_reset: document.getElementById('s-reset').checked,
                };
                const r = await fetch(URL_SETTINGS, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(body)
                });
                const data = await r.json();
                if (r.ok) {
                    Object.assign(SETTINGS, body);
                    closeModal('modal-settings');
                    document.getElementById('conv-formula-display').textContent =
                        `${body.amount_value} ${body.currency} = ${body.points_value} Points`;
                    document.getElementById('conv-amount-display').textContent =
                        `${Number(body.amount_value).toFixed(2)} ${body.currency}`;
                    document.getElementById('conv-points-display').textContent =
                        `${Number(body.points_value).toFixed(2)}`;
                    showToast(data.message);
                } else showToast(data.errors ? Object.values(data.errors).flat().join(' ') : (data
                    .message || 'Error.'), 'error');
            });

            // ── Level modal ──
            function openLevelModal(level = null) {
                document.getElementById('modal-level-title').textContent = level ? 'Edit Bonus Level' :
                    'Add Bonus Level';
                document.getElementById('l-id').value = level?.id ?? '';
                document.getElementById('l-name').value = level?.name ?? '';
                document.getElementById('l-points').value = level?.required_points ?? '';
                document.getElementById('l-reward').value = level?.reward_name ?? '';
                document.getElementById('l-desc').value = level?.reward_description ?? '';
                document.getElementById('l-order').value = level?.sort_order ?? LEVELS.length + 1;
                document.getElementById('l-active').checked = level ? level.is_active : true;
                // Image
                document.getElementById('l-image').value = '';
                if (level?.image) {
                    document.getElementById('l-img-thumb').src = level.image;
                    document.getElementById('l-img-preview').style.display = 'inline-block';
                    document.getElementById('l-img-placeholder').style.display = 'none';
                } else {
                    clearImage();
                }
                openModal('modal-level');
            }
            document.getElementById('btn-open-level').addEventListener('click', () => openLevelModal());

            // Image input preview
            document.getElementById('l-image').addEventListener('change', function() {
                if (!this.files[0]) return;
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById('l-img-thumb').src = e.target.result;
                    document.getElementById('l-img-preview').style.display = 'inline-block';
                    document.getElementById('l-img-placeholder').style.display = 'none';
                };
                reader.readAsDataURL(this.files[0]);
            });
            // Drag-and-drop on dropzone
            const dropEl = document.getElementById('l-img-drop');
            ['dragover', 'dragenter'].forEach(ev => dropEl.addEventListener(ev, e => {
                e.preventDefault();
                dropEl.classList.add('drag');
            }));
            ['dragleave', 'drop'].forEach(ev => dropEl.addEventListener(ev, e => {
                e.preventDefault();
                dropEl.classList.remove('drag');
            }));
            dropEl.addEventListener('drop', e => {
                const file = e.dataTransfer?.files[0];
                if (!file || !file.type.startsWith('image/')) return;
                const dt = new DataTransfer();
                dt.items.add(file);
                document.getElementById('l-image').files = dt.files;
                document.getElementById('l-image').dispatchEvent(new Event('change'));
            });

            function clearImage() {
                document.getElementById('l-image').value = '';
                document.getElementById('l-img-thumb').src = '';
                document.getElementById('l-img-preview').style.display = 'none';
                document.getElementById('l-img-placeholder').style.display = '';
            }
            window.clearImage = clearImage;
            document.getElementById('form-level').addEventListener('submit', async e => {
                e.preventDefault();
                const id = document.getElementById('l-id').value;
                const fd = new FormData();
                if (id) fd.append('_method', 'PUT');
                fd.append('name', document.getElementById('l-name').value);
                fd.append('required_points', document.getElementById('l-points').value);
                fd.append('reward_name', document.getElementById('l-reward').value);
                fd.append('reward_description', document.getElementById('l-desc').value || '');
                fd.append('sort_order', document.getElementById('l-order').value || 0);
                fd.append('is_active', document.getElementById('l-active').checked ? '1' : '0');
                const imgFile = document.getElementById('l-image').files[0];
                if (imgFile) {
                    fd.append('image', imgFile);
                } else if (!document.getElementById('l-img-thumb').src) {
                    fd.append('remove_image', '1');
                }
                const r = await fetch(id ? `/loyalty/levels/${id}` : URL_LEVELS, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json'
                    },
                    body: fd,
                });
                const data = await r.json();
                if (r.ok) {
                    if (id) {
                        const idx = LEVELS.findIndex(l => l.id == id);
                        if (idx !== -1) LEVELS[idx] = data.level;
                    } else LEVELS.push(data.level);
                    refreshLevelsGrid();
                    closeModal('modal-level');
                    showToast(data.message);
                } else showToast(data.errors ? Object.values(data.errors).flat().join(' ') : (data
                    .message || 'Error.'), 'error');
            });

            // ── Delete level ──
            async function deleteLevel(id) {
                const level = LEVELS.find(l => l.id == id);
                const res = await Swal.fire({
                    title: 'Delete this level?',
                    html: `<strong>${esc(level?.name)}</strong> will be permanently removed.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#94a3b8',
                    customClass: {
                        popup: 'rounded-2xl'
                    },
                });
                if (!res.isConfirmed) return;
                const r = await fetch(`/loyalty/levels/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json'
                    }
                });
                const data = await r.json();
                if (r.ok) {
                    LEVELS = LEVELS.filter(l => l.id != id);
                    refreshLevelsGrid();
                    showToast(data.message);
                } else showToast(data.message || 'Error.', 'error');
            }

            // ── Boot ──
            function boot() {
                bootClientsGrid();
                bootLevelsGrid();
            }
            document.readyState === 'loading' ? document.addEventListener('DOMContentLoaded', boot) : boot();

        })();
    </script>

</x-app-layout>
