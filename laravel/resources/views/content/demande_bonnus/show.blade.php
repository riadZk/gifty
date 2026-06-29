<x-app-layout>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* ── Entrance animations ── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(14px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(.95)
            }

            to {
                opacity: 1;
                transform: scale(1)
            }
        }

        @keyframes pulseRing {
            0% {
                transform: scale(.88);
                opacity: .7;
            }

            70% {
                transform: scale(1.2);
                opacity: 0;
            }

            100% {
                transform: scale(.88);
                opacity: 0;
            }
        }

        @keyframes spin {
            to {
                transform: rotate(360deg)
            }
        }

        .au {
            animation: fadeUp .4s ease both;
        }

        .si {
            animation: scaleIn .38s ease both;
        }

        .d1 {
            animation-delay: .05s
        }

        .d2 {
            animation-delay: .10s
        }

        .d3 {
            animation-delay: .16s
        }

        .d4 {
            animation-delay: .22s
        }

        /* ── Card shell ── */
        .sc {
            background: #fff;
            border: 1px solid #e8edf4;
            border-radius: 20px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, .04), 0 8px 32px -16px rgba(15, 23, 42, .10);
            overflow: hidden;
        }

        .sc-hd {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 20px;
            border-bottom: 1px solid #f1f5f9;
        }

        .sc-ico {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
        }

        .sc-title {
            font-size: 12.5px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -.01em;
        }

        /* ── Status accent bar ── */
        .sab {
            border-radius: 20px;
            padding: 16px 22px;
            border-left: 5px solid var(--ac);
            background: var(--bg);
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, .04), 0 4px 16px -8px rgba(15, 23, 42, .07);
        }

        /* ── Timeline ── */
        .tl {
            display: flex;
            gap: 12px;
        }

        .tl-col {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .tl-dot {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }

        .tl-dot.done {
            background: #10b981;
            box-shadow: 0 0 0 4px #d1fae5;
        }

        .tl-dot.active {
            background: #fff;
            border: 2px solid #f59e0b;
            box-shadow: 0 0 0 4px #fef3c7;
        }

        .tl-dot.active::before {
            content: '';
            position: absolute;
            inset: -7px;
            border-radius: 50%;
            background: rgba(245, 158, 11, .18);
            animation: pulseRing 1.5s ease-out infinite;
        }

        .tl-dot.idle {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
        }

        .tl-line {
            width: 2px;
            flex: 1;
            margin: 4px 0;
            border-radius: 2px;
            min-height: 18px;
        }

        .tl-line.done {
            background: linear-gradient(180deg, #10b981, #34d399);
        }

        .tl-line.empty {
            background: #e2e8f0;
        }

        /* ── Action buttons ── */
        .abtn {
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: center;
            gap: 8px;
            height: 46px;
            border-radius: 14px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: all .18s ease;
            position: relative;
            overflow: hidden;
        }

        .abtn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, .14);
            opacity: 0;
            transition: opacity .15s;
        }

        .abtn:hover::after {
            opacity: 1;
        }

        .abtn:active {
            transform: scale(.97);
        }

        .abtn.approve {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
            box-shadow: 0 4px 14px -4px rgba(16, 185, 129, .45);
        }

        .abtn.reject {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .abtn.reject:hover {
            background: #fee2e2;
        }

        .abtn.deliver {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff;
            box-shadow: 0 4px 14px -4px rgba(59, 130, 246, .45);
        }

        .abtn.neutral {
            background: #f8fafc;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .abtn.neutral:hover {
            background: #f1f5f9;
        }

        .abtn.loading {
            opacity: .65;
            pointer-events: none;
        }

        .spin-ico {
            display: inline-block;
            width: 15px;
            height: 15px;
            border: 2px solid rgba(255, 255, 255, .4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .6s linear infinite;
        }

        /* ── Stat pill ── */
        .sp {
            border-radius: 14px;
            padding: 13px;
            text-align: center;
            background: #f8fafc;
            border: 1px solid #f1f5f9;
        }
    </style>

    @php
        $sCfg = [
            'pending' => [
                'En attente',
                'text-amber-700',
                'bg-amber-50',
                'border-amber-200',
                'bg-amber-400',
                '#f59e0b',
                'bg-amber-100',
                '--ac:#f59e0b;--bg:#fffbeb;',
            ],
            'approved' => [
                'Approuvée',
                'text-emerald-700',
                'bg-emerald-50',
                'border-emerald-200',
                'bg-emerald-400',
                '#10b981',
                'bg-emerald-100',
                '--ac:#10b981;--bg:#f0fdf4;',
            ],
            'rejected' => [
                'Rejetée',
                'text-red-700',
                'bg-red-50',
                'border-red-200',
                'bg-red-400',
                '#ef4444',
                'bg-red-100',
                '--ac:#ef4444;--bg:#fef2f2;',
            ],
            'delivered' => [
                'Livrée',
                'text-blue-700',
                'bg-blue-50',
                'border-blue-200',
                'bg-blue-400',
                '#3b82f6',
                'bg-blue-100',
                '--ac:#3b82f6;--bg:#eff6ff;',
            ],
        ];
        [$sLabel, $sTxt, $sBg, $sBorder, $sDot, $sHex, $sLightBg, $sCss] = $sCfg[$bonusRequest->status] ?? [
            '—',
            'text-slate-500',
            'bg-slate-50',
            'border-slate-200',
            'bg-slate-400',
            '#94a3b8',
            'bg-slate-100',
            '--ac:#94a3b8;--bg:#f8fafc;',
        ];

        $client = $bonusRequest->client;
        $bonus = $bonusRequest->bonusLevel;
        $dbId = $bonusRequest->demande_key ?? 'DB-' . str_pad($bonusRequest->id, 5, '0', STR_PAD_LEFT);

        $pBefore = (float) $client->points_balance;
        $pReq = (float) $bonusRequest->points_required;
        $pAfter = max(0, $pBefore - $pReq);
        $pct = $pBefore > 0 ? min(100, round(($pAfter / $pBefore) * 100)) : 0;
        $r = 36;
        $c = 2 * M_PI * $r;
        $dash = round(($pct / 100) * $c, 2);
        $gap = round($c - $dash, 2);
    @endphp

    <div class="flex flex-col gap-5">

        {{-- Header --}}
        <div class="au flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <a href="{{ route('demandes.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-[12.5px] font-semibold text-slate-600 shadow-sm hover:bg-slate-50 transition-colors">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3.5 w-3.5">
                        <path d="M19 12H5M12 5l-7 7 7 7" />
                    </svg>
                    Retour
                </a>
                <div>
                    <nav class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-400">
                        <span>Demandes Bonus</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3 w-3">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                        <span class="text-slate-600">{{ $dbId }}</span>
                    </nav>
                    <h1 class="text-[22px] font-black tracking-tight text-slate-900 leading-tight">Détail de la demande
                        bonus</h1>
                    <p class="text-[12.5px] text-slate-400">Consultez toutes les informations relatives à cette demande
                    </p>
                </div>
            </div>

        </div>

        {{-- Status banner --}}
        <div class="sab au d1" style="{{ $sCss }}">
            <div class="flex items-center gap-4">
                <div class="grid h-11 w-11 shrink-0 place-items-center rounded-2xl {{ $sLightBg }}">
                    @if ($bonusRequest->isPending())
                        <svg viewBox="0 0 24 24" fill="none" stroke="{{ $sHex }}" stroke-width="1.9"
                            class="h-5 w-5">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 6v6l4 2" />
                        </svg>
                    @elseif($bonusRequest->isApproved())
                        <svg viewBox="0 0 24 24" fill="none" stroke="{{ $sHex }}" stroke-width="1.9"
                            class="h-5 w-5">
                            <path d="m5 12 5 5L20 7" />
                        </svg>
                    @elseif($bonusRequest->isRejected())
                        <svg viewBox="0 0 24 24" fill="none" stroke="{{ $sHex }}" stroke-width="1.9"
                            class="h-5 w-5">
                            <path d="M18 6 6 18M6 6l12 12" />
                        </svg>
                    @else
                        <svg viewBox="0 0 24 24" fill="none" stroke="{{ $sHex }}" stroke-width="1.9"
                            class="h-5 w-5">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    @endif
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-[12.5px] font-semibold text-slate-500">Statut actuel :</span>
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full border {{ $sBorder }} bg-white px-3 py-1 text-[12px] font-bold {{ $sTxt }}">
                            <span class="h-1.5 w-1.5 rounded-full {{ $sDot }}"></span>{{ $sLabel }}
                        </span>
                    </div>
                    <p class="mt-0.5 text-[12px] text-slate-500">Soumise le
                        {{ $bonusRequest->requested_at?->format('d/m/Y à H:i') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2 rounded-xl border border-white/70 bg-white/60 px-4 py-2 shadow-sm">
                <span class="text-[11.5px] font-semibold text-slate-500">ID :</span>
                <span class="font-black text-slate-800 tracking-wide">{{ $dbId }}</span>
                <button id="copy-id"
                    onclick="navigator.clipboard.writeText('{{ $dbId }}');document.getElementById('copy-id').innerHTML='<svg viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'#10b981\' stroke-width=\'2.5\' class=\'h-3.5 w-3.5\'><path d=\'m5 12 5 5L20 7\'/></svg>'"
                    class="ml-1 text-slate-400 hover:text-slate-600 transition-colors">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3.5 w-3.5">
                        <rect x="9" y="9" width="13" height="13" rx="2" />
                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Main grid --}}
        <div class="grid grid-cols-1 gap-5 xl:grid-cols-3">

            {{-- LEFT (2/3) --}}
            <div class="flex flex-col gap-5 xl:col-span-2">

                {{-- Row 1: Client + Résumé --}}
                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                    {{-- Client card --}}
                    <div class="sc au d1">
                        <div class="rounded-t-[20px] bg-gradient-to-br from-blue-500 to-blue-700 px-5 pt-5 pb-9">
                            <div class="flex items-start justify-between">
                                <div
                                    class="grid h-12 w-12 place-items-center rounded-2xl bg-white/20 text-[16px] font-black text-white backdrop-blur-sm">
                                    {{ strtoupper(substr($client->company_name, 0, 2)) }}
                                </div>
                                <a href="{{ route('clients.show', $client->id) }}"
                                    class="rounded-lg bg-white/20 p-1.5 text-white hover:bg-white/30 transition-colors">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        class="h-4 w-4">
                                        <path d="M5 12h14M12 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                            <div class="mt-3">
                                <div class="text-[15px] font-black text-white">{{ $client->company_name }}</div>
                                @php
                                    $csm = ['active' => ['Client actif', 'bg-emerald-400/30 text-emerald-100'], 'blocked' => ['Bloqué', 'bg-red-400/30 text-red-100']];
                                    [$csl, $csc] = $csm[$client->status] ?? ['—', 'bg-white/20 text-white/80'];
                                @endphp
                                <span
                                    class="mt-1 inline-flex rounded-full px-2.5 py-0.5 text-[11px] font-bold {{ $csc }}">{{ $csl }}</span>
                            </div>
                        </div>
                        <div
                            class="-mt-5 mx-4 mb-4 rounded-2xl border border-slate-100 bg-white px-4 py-3 shadow-sm flex flex-col gap-2.5">
                            @if ($client->pcc_customer_code)
                                <div class="flex items-center gap-2 text-[12.5px]">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8"
                                        class="h-4 w-4 shrink-0">
                                        <rect x="2" y="5" width="20" height="14" rx="2" />
                                        <path d="M2 10h20" />
                                    </svg>
                                    <span class="text-slate-400">Code PCC</span>
                                    <span
                                        class="ml-auto font-bold text-slate-800">{{ $client->pcc_customer_code }}</span>
                                </div>
                            @endif
                            <div class="flex items-center gap-2 text-[12.5px]">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8"
                                    class="h-4 w-4 shrink-0">
                                    <path
                                        d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                    <polyline points="22,6 12,13 2,6" />
                                </svg>
                                <span class="text-slate-400">Email</span>
                                <span
                                    class="ml-auto font-semibold text-slate-700 truncate max-w-[150px]">{{ $client->email }}</span>
                            </div>
                            @if ($client->phone)
                                <div class="flex items-center gap-2 text-[12.5px]">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8"
                                        class="h-4 w-4 shrink-0">
                                        <path
                                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.77a16 16 0 0 0 6.29 6.29l.95-.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
                                    </svg>
                                    <span class="text-slate-400">Téléphone</span>
                                    <span class="ml-auto font-semibold text-slate-700">{{ $client->phone }}</span>
                                </div>
                            @endif
                            <div class="flex items-center gap-2 text-[12.5px]">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8"
                                    class="h-4 w-4 shrink-0">
                                    <rect x="3" y="4" width="18" height="18" rx="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg>
                                <span class="text-slate-400">Membre depuis</span>
                                <span
                                    class="ml-auto font-semibold text-slate-700">{{ $client->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Résumé --}}
                    <div class="sc au d2">
                        <div class="sc-hd">
                            <div class="sc-ico bg-violet-50"><svg viewBox="0 0 24 24" fill="none"
                                    stroke="#7c3aed" stroke-width="1.8" class="h-4 w-4">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                </svg></div>
                            <span class="sc-title">Résumé de la demande</span>
                        </div>
                        <div class="p-5 flex flex-col gap-3.5">
                            <div class="flex items-start justify-between gap-3">
                                <span class="text-[11.5px] font-semibold text-slate-400 mt-0.5">Date</span>
                                <span
                                    class="text-[12.5px] font-bold text-slate-800 text-right">{{ $bonusRequest->requested_at?->format('d/m/Y - H:i') }}</span>
                            </div>
                            <div class="h-px bg-slate-50"></div>
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-[11.5px] font-semibold text-slate-400">Demandé par</span>
                                <span
                                    class="text-[12.5px] font-bold text-slate-800">{{ $client->company_name }}</span>
                            </div>
                            <div class="h-px bg-slate-50"></div>
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-[11.5px] font-semibold text-slate-400">Canal</span>
                                <span
                                    class="inline-flex rounded-full bg-violet-50 px-3 py-0.5 text-[11.5px] font-bold text-violet-700">Portail
                                    client</span>
                            </div>
                            @if ($bonusRequest->notes)
                                <div class="h-px bg-slate-50"></div>
                                <div>
                                    <p class="mb-1.5 text-[11.5px] font-semibold text-slate-400">Notes du client</p>
                                    <div
                                        class="rounded-xl border border-slate-100 bg-slate-50 px-3 py-2 text-[12.5px] text-slate-600 leading-relaxed">
                                        {{ $bonusRequest->notes }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Bonus card --}}
                <div class="sc au d2">
                    <div class="sc-hd">
                        <div class="sc-ico bg-violet-50"><svg viewBox="0 0 24 24" fill="none" stroke="#7c3aed"
                                stroke-width="1.8" class="h-4 w-4">
                                <polyline points="20 12 20 22 4 22 4 12" />
                                <rect x="2" y="7" width="20" height="5" />
                                <line x1="12" y1="22" x2="12" y2="7" />
                                <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z" />
                                <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z" />
                            </svg></div>
                        <span class="sc-title">Bonus demandé</span>
                    </div>
                    <div class="p-5 flex items-start gap-4">
                        <div class="shrink-0 overflow-hidden rounded-2xl border border-slate-100 shadow-sm"
                            style="width:72px;height:72px;min-width:72px;">
                            @if ($bonus->image)
                                <img src="{{ $bonus->image }}" alt="{{ $bonus->reward_name }}"
                                    style="width:72px;height:72px;object-fit:cover;display:block;">
                            @else
                                <div class="flex items-center justify-center bg-slate-50"
                                    style="width:72px;height:72px;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8"
                                        class="h-8 w-8">
                                        <polyline points="20 12 20 22 4 22 4 12" />
                                        <rect x="2" y="7" width="20" height="5" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-[16px] font-black text-slate-900">{{ $bonus->name }}</span>
                                @if ($bonus->is_active)
                                    <span
                                        class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-[11px] font-bold text-emerald-700">Bonus
                                        actif</span>
                                @endif
                            </div>
                            <p class="text-[13px] font-semibold text-slate-500">{{ $bonus->reward_name }}</p>
                            @if ($bonus->reward_description)
                                <p class="mt-0.5 text-[12px] text-slate-400 leading-relaxed">
                                    {{ $bonus->reward_description }}</p>
                            @endif
                            <div class="mt-4 grid grid-cols-3 gap-3">
                                <div class="sp">
                                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">
                                        Points requis</div>
                                    <div class="text-[17px] font-black text-amber-500">
                                        {{ number_format($bonusRequest->points_required, 0, ',', ' ') }} pts</div>
                                </div>
                                <div class="sp">
                                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">
                                        Quantité</div>
                                    <div class="text-[17px] font-black text-slate-800">1</div>
                                </div>
                                <div class="sp">
                                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">
                                        Valeur estimée</div>
                                    <div class="text-[17px] font-black text-slate-800">—</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Points situation --}}
                <div class="sc au d3">
                    <div class="sc-hd">
                        <div class="sc-ico bg-blue-50"><svg viewBox="0 0 24 24" fill="none" stroke="#3b82f6"
                                stroke-width="1.8" class="h-4 w-4">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 6v6l4 2" />
                            </svg></div>
                        <span class="sc-title">Situation des points du client</span>
                    </div>
                    <div class="p-5">
                        <div class="flex items-start gap-4">
                            <div class="grid flex-1 grid-cols-2 gap-3 md:grid-cols-3">
                                <div
                                    class="rounded-2xl border border-blue-100 bg-gradient-to-br from-blue-50 to-blue-100/50 p-3">
                                    <div class="grid h-7 w-7 place-items-center rounded-lg bg-blue-100 mb-2"><svg
                                            viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="1.8"
                                            class="h-3.5 w-3.5">
                                            <circle cx="12" cy="12" r="10" />
                                            <path d="M12 6v6l4 2" />
                                        </svg></div>
                                    <div class="text-[15px] font-black text-blue-900">
                                        {{ number_format($client->points_balance, 2, ',', ' ') }} pts</div>
                                    <div class="text-[10.5px] font-bold text-blue-500">Solde actuel</div>
                                    <div class="text-[10px] text-blue-400">Avant cette demande</div>
                                </div>
                                <div
                                    class="rounded-2xl border border-amber-100 bg-gradient-to-br from-amber-50 to-amber-100/50 p-3">
                                    <div class="grid h-7 w-7 place-items-center rounded-lg bg-amber-100 mb-2"><svg
                                            viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="1.8"
                                            class="h-3.5 w-3.5">
                                            <polygon
                                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                                        </svg></div>
                                    <div class="text-[15px] font-black text-amber-800">
                                        {{ number_format($pReq, 2, ',', ' ') }} pts</div>
                                    <div class="text-[10.5px] font-bold text-amber-500">Points requis</div>
                                    <div class="text-[10px] text-amber-400">Pour ce bonus</div>
                                </div>
                                <div
                                    class="rounded-2xl border border-emerald-100 bg-gradient-to-br from-emerald-50 to-emerald-100/50 p-3">
                                    <div class="grid h-7 w-7 place-items-center rounded-lg bg-emerald-100 mb-2"><svg
                                            viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="1.8"
                                            class="h-3.5 w-3.5">
                                            <path d="m5 12 5 5L20 7" />
                                        </svg></div>
                                    <div class="text-[15px] font-black text-emerald-800">
                                        {{ number_format($pAfter, 2, ',', ' ') }} pts</div>
                                    <div class="text-[10.5px] font-bold text-emerald-500">Solde après échange</div>
                                    <div class="text-[10px] text-emerald-400">Si approuvée</div>
                                </div>
                            </div>
                            <div class="hidden md:block shrink-0">
                                <svg width="88" height="88" viewBox="0 0 96 96">
                                    <circle cx="48" cy="48" r="{{ $r }}" fill="none"
                                        stroke="#e2e8f0" stroke-width="9" />
                                    <circle cx="48" cy="48" r="{{ $r }}" fill="none"
                                        stroke="#3b82f6" stroke-width="9" stroke-linecap="round"
                                        stroke-dasharray="{{ $dash }} {{ $gap }}"
                                        transform="rotate(-90 48 48)" />
                                    <text x="48" y="44" text-anchor="middle" font-size="15" font-weight="900"
                                        fill="#1e40af" font-family="Manrope,sans-serif">{{ $pct }}%</text>
                                    <text x="48" y="58" text-anchor="middle" font-size="8.5" fill="#94a3b8"
                                        font-family="Manrope,sans-serif">Restants</text>
                                </svg>
                            </div>
                        </div>
                        @if ($bonusRequest->isPending() && $client->points_balance < $bonusRequest->points_required)
                            <div
                                class="mt-4 flex items-center gap-2.5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-[12.5px] font-semibold text-red-700">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    class="h-4 w-4 shrink-0">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M12 8v4m0 4h.01" />
                                </svg>
                                Solde insuffisant — il manque
                                {{ number_format($pReq - $client->points_balance, 0, ',', ' ') }} pts
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- RIGHT (1/3) --}}
            <div class="flex flex-col gap-5">

                {{-- Timeline --}}
                <div class="sc si d2">
                    <div class="sc-hd">
                        <div class="sc-ico bg-slate-50"><svg viewBox="0 0 24 24" fill="none" stroke="#64748b"
                                stroke-width="1.8" class="h-4 w-4">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                            </svg></div>
                        <span class="sc-title">Suivi de la demande</span>
                    </div>
                    <div class="p-5">
                        @php
                            $steps = [
                                [
                                    'label' => 'Demande créée',
                                    'sub' => $bonusRequest->requested_at?->format('d/m/Y - H:i'),
                                    'done' => true,
                                    'active' => false,
                                ],
                                [
                                    'label' => 'En attendant validation',
                                    'sub' => "Par l'administrateur",
                                    'done' => !$bonusRequest->isPending(),
                                    'active' => $bonusRequest->isPending(),
                                ],
                                [
                                    'label' => 'Approuvée',
                                    'sub' => $bonusRequest->approved_at?->format('d/m/Y - H:i') ?? '—',
                                    'done' => $bonusRequest->isApproved() || $bonusRequest->isDelivered(),
                                    'active' => false,
                                ],
                                [
                                    'label' => 'Préparée pour livraison',
                                    'sub' => '—',
                                    'done' => $bonusRequest->isDelivered(),
                                    'active' => false,
                                ],
                                [
                                    'label' => 'Livrée au client',
                                    'sub' => '—',
                                    'done' => $bonusRequest->isDelivered(),
                                    'active' => false,
                                ],
                            ];
                        @endphp
                        <div class="flex flex-col">
                            @foreach ($steps as $step)
                                <div class="tl">
                                    <div class="tl-col">
                                        <div
                                            class="tl-dot {{ $step['done'] ? 'done' : ($step['active'] ? 'active' : 'idle') }}">
                                            @if ($step['done'])
                                                <svg viewBox="0 0 24 24" fill="none" stroke="white"
                                                    stroke-width="2.5" class="h-4 w-4">
                                                    <path d="m5 12 5 5L20 7" />
                                                </svg>
                                            @elseif($step['active'])
                                                <span class="h-2.5 w-2.5 rounded-full bg-amber-400"></span>
                                            @else
                                                <span class="h-2.5 w-2.5 rounded-full bg-slate-300"></span>
                                            @endif
                                        </div>
                                        @if (!$loop->last)
                                            <div class="tl-line {{ $step['done'] ? 'done' : 'empty' }}"></div>
                                        @endif
                                    </div>
                                    <div class="flex-1 pt-1">
                                        <p
                                            class="text-[13px] font-bold {{ $step['done'] ? 'text-slate-800' : ($step['active'] ? 'text-amber-700' : 'text-slate-400') }}">
                                            {{ $step['label'] }}</p>
                                        @if ($step['active'])
                                            <div
                                                class="mt-1.5 mb-3 rounded-lg border border-amber-200 bg-amber-50 px-3 py-1.5">
                                                <p class="text-[11.5px] font-semibold text-amber-600">
                                                    {{ $step['sub'] }}</p>
                                            </div>
                                        @else
                                            <p
                                                class="mt-0.5 pb-3 text-[11.5px] {{ $step['done'] ? 'text-slate-400' : 'text-slate-300' }}">
                                                {{ $step['sub'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="sc si d3">
                    <div class="sc-hd">
                        <div class="sc-ico bg-emerald-50"><svg viewBox="0 0 24 24" fill="none" stroke="#10b981"
                                stroke-width="1.8" class="h-4 w-4">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            </svg></div>
                        <span class="sc-title">Actions administrateur</span>
                    </div>
                    <div class="p-5 flex flex-col gap-3">
                        @if ($bonusRequest->isPending())
                            <button id="btn-approve" class="abtn approve"
                                data-url="{{ route('demandes.approve', $bonusRequest->id) }}"
                                data-pts="{{ number_format($bonusRequest->points_required, 0, ',', ' ') }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                    class="h-4 w-4">
                                    <path d="m5 12 5 5L20 7" />
                                </svg>
                                Approuver la demande
                            </button>
                            <button id="btn-reject" class="abtn reject"
                                data-url="{{ route('demandes.reject', $bonusRequest->id) }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                    class="h-4 w-4">
                                    <path d="M18 6 6 18M6 6l12 12" />
                                </svg>
                                Refuser la demande
                            </button>
                            <button class="abtn neutral">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                    class="h-4 w-4">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M12 8v4m0 4h.01" />
                                </svg>
                                Demander plus d'informations
                            </button>
                        @elseif($bonusRequest->isApproved())
                            <p class="text-center text-[12px] text-slate-500">Le bonus a été approuvé. Marquez-le comme
                                livré une fois remis au client.</p>
                            <button id="btn-deliver" class="abtn deliver"
                                data-url="{{ route('demandes.deliver', $bonusRequest->id) }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    class="h-4 w-4">
                                    <path d="M5 12h14M12 5l7 7-7 7" />
                                </svg>
                                Marquer comme livré
                            </button>
                        @elseif($bonusRequest->isRejected())
                            <div class="flex flex-col items-center gap-2 py-3 text-center">
                                <div class="grid h-12 w-12 place-items-center rounded-full bg-red-50"><svg
                                        viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2"
                                        class="h-5 w-5">
                                        <path d="M18 6 6 18M6 6l12 12" />
                                    </svg></div>
                                <p class="text-[13px] font-bold text-slate-700">Demande rejetée</p>
                                <p class="text-[12px] text-slate-400">
                                    {{ $bonusRequest->rejected_at?->format('d/m/Y à H:i') }}</p>
                            </div>
                        @elseif($bonusRequest->isDelivered())
                            <div class="flex flex-col items-center gap-2 py-3 text-center">
                                <div class="grid h-12 w-12 place-items-center rounded-full bg-blue-50"><svg
                                        viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"
                                        class="h-5 w-5">
                                        <path d="m5 12 5 5L20 7" />
                                    </svg></div>
                                <p class="text-[13px] font-bold text-slate-700">Bonus livré</p>
                                <p class="text-[12px] text-slate-400">Cette demande est terminée.</p>
                            </div>
                        @endif

                        <div class="mt-1">
                            <label class="mb-1.5 block text-[12px] font-semibold text-slate-500">Commentaires
                                (optionnel)</label>
                            <div class="relative">
                                <textarea id="comment-box" rows="3" maxlength="255" placeholder="Ajouter un commentaire..."
                                    oninput="document.getElementById('char-count').textContent=this.value.length+'/255'"
                                    class="w-full resize-none rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-[12.5px] text-slate-700 focus:border-slate-300 focus:bg-white focus:outline-none focus:ring-4 focus:ring-slate-100 transition-all"></textarea>
                                <span id="char-count"
                                    class="absolute bottom-2.5 right-3 text-[10.5px] text-slate-400">0/255</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Transaction --}}
                @if ($bonusRequest->transaction)
                    @php $tx=$bonusRequest->transaction; @endphp
                    <div class="sc si d4">
                        <div class="sc-hd">
                            <div class="sc-ico bg-slate-50"><svg viewBox="0 0 24 24" fill="none" stroke="#64748b"
                                    stroke-width="1.8" class="h-4 w-4">
                                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                </svg></div>
                            <span class="sc-title">Transaction de Points</span>
                        </div>
                        <div class="p-5 flex flex-col gap-2">
                            <div class="flex items-center justify-between rounded-xl bg-slate-50 px-4 py-3">
                                <span class="text-[12px] font-semibold text-slate-500">Avant</span>
                                <span
                                    class="text-[14px] font-black text-slate-800">{{ number_format($tx->points_before, 0, ',', ' ') }}
                                    pts</span>
                            </div>
                            <div class="flex items-center justify-between rounded-xl bg-red-50 px-4 py-3">
                                <span class="text-[12px] font-semibold text-red-400">Déduits</span>
                                <span class="text-[14px] font-black text-red-600">−
                                    {{ number_format($tx->points_used, 0, ',', ' ') }} pts</span>
                            </div>
                            <div class="h-px bg-slate-100"></div>
                            <div class="flex items-center justify-between rounded-xl bg-emerald-50 px-4 py-3">
                                <span class="text-[12px] font-semibold text-emerald-500">Après</span>
                                <span
                                    class="text-[14px] font-black text-emerald-700">{{ number_format($tx->points_after, 0, ',', ' ') }}
                                    pts</span>
                            </div>
                            <p class="pt-1 text-center text-[11px] text-slate-400">
                                {{ \Carbon\Carbon::parse($tx->created_at)->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        (function() {
            const CSRF = document.querySelector('meta[name="csrf-token"]').content;

            const MySwal = Swal.mixin({
                customClass: {
                    popup: '!rounded-2xl !shadow-2xl',
                    confirmButton: '!rounded-xl !px-5 !py-2.5 !text-[13px] !font-bold',
                    cancelButton: '!rounded-xl !px-5 !py-2.5 !text-[13px] !font-semibold',
                },
                buttonsStyling: true,
            });

            function setLoading(btn, on) {
                if (on) {
                    btn._html = btn.innerHTML;
                    btn.innerHTML = '<span class="spin-ico"></span> Traitement…';
                    btn.classList.add('loading');
                } else {
                    btn.innerHTML = btn._html;
                    btn.classList.remove('loading');
                }
            }

            function getComment() {
                return document.getElementById('comment-box')?.value?.trim() ?? '';
            }

            async function doAction(url, body = {}) {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(body),
                });
                return res;
            }

            // APPROVE
            document.getElementById('btn-approve')?.addEventListener('click', async function() {
                const url = this.dataset.url,
                    pts = this.dataset.pts,
                    btn = this;
                const {
                    isConfirmed
                } = await MySwal.fire({
                    icon: 'question',
                    title: 'Approuver la demande ?',
                    html: `<p style="color:#64748b;font-size:13px;">Cela déduira <strong style="color:#f59e0b">${pts} pts</strong> du solde du client.</p>`,
                    showCancelButton: true,
                    confirmButtonText: '✓ Approuver',
                    confirmButtonColor: '#10b981',
                    cancelButtonText: 'Annuler',
                    cancelButtonColor: '#94a3b8',
                    reverseButtons: true,
                });
                if (!isConfirmed) return;
                setLoading(btn, true);
                const res = await doAction(url, {
                    notes: getComment()
                });
                if (res.ok) {
                    await MySwal.fire({
                        icon: 'success',
                        title: 'Approuvée !',
                        text: 'Les points ont été déduits.',
                        timer: 1800,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                    location.reload();
                } else {
                    const d = await res.json().catch(() => ({}));
                    setLoading(btn, false);
                    MySwal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: d.message ?? 'Une erreur est survenue.',
                        confirmButtonColor: '#ef4444'
                    });
                }
            });

            // REJECT
            document.getElementById('btn-reject')?.addEventListener('click', async function() {
                const url = this.dataset.url,
                    btn = this;
                const comment = getComment();
                const {
                    isConfirmed,
                    value: reason
                } = await MySwal.fire({
                    icon: 'warning',
                    title: 'Refuser la demande ?',
                    html: `<p style="color:#64748b;font-size:13px;margin-bottom:10px;">Vous pouvez ajouter un motif de refus.</p>
                  <textarea id="swal-reason" style="width:100%;border:1px solid #e2e8f0;border-radius:12px;background:#f8fafc;padding:10px 12px;font-size:13px;color:#334155;resize:none;outline:none;" rows="2" placeholder="Motif du refus (optionnel)…">${comment}</textarea>`,
                    showCancelButton: true,
                    confirmButtonText: '✗ Refuser',
                    confirmButtonColor: '#ef4444',
                    cancelButtonText: 'Annuler',
                    cancelButtonColor: '#94a3b8',
                    reverseButtons: true,
                    preConfirm: () => document.getElementById('swal-reason')?.value ?? '',
                });
                if (!isConfirmed) return;
                setLoading(btn, true);
                const res = await doAction(url, {
                    notes: reason || comment
                });
                if (res.ok) {
                    await MySwal.fire({
                        icon: 'warning',
                        title: 'Demande refusée',
                        text: 'La demande a été marquée comme rejetée.',
                        timer: 1800,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                    location.reload();
                } else {
                    const d = await res.json().catch(() => ({}));
                    setLoading(btn, false);
                    MySwal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: d.message ?? 'Erreur.',
                        confirmButtonColor: '#ef4444'
                    });
                }
            });

            // DELIVER
            document.getElementById('btn-deliver')?.addEventListener('click', async function() {
                const url = this.dataset.url,
                    btn = this;
                const {
                    isConfirmed
                } = await MySwal.fire({
                    icon: 'info',
                    title: 'Confirmer la livraison ?',
                    text: 'Le bonus a bien été remis au client ?',
                    showCancelButton: true,
                    confirmButtonText: '→ Confirmer',
                    confirmButtonColor: '#3b82f6',
                    cancelButtonText: 'Annuler',
                    cancelButtonColor: '#94a3b8',
                    reverseButtons: true,
                });
                if (!isConfirmed) return;
                setLoading(btn, true);
                const res = await doAction(url, {
                    notes: getComment()
                });
                if (res.ok) {
                    await MySwal.fire({
                        icon: 'success',
                        title: 'Bonus livré !',
                        text: 'La demande est maintenant terminée.',
                        timer: 1800,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                    location.reload();
                } else {
                    const d = await res.json().catch(() => ({}));
                    setLoading(btn, false);
                    MySwal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: d.message ?? 'Erreur.',
                        confirmButtonColor: '#ef4444'
                    });
                }
            });
        })();
    </script>

</x-app-layout>
