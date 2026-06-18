<x-app-layout>

    @php
    $initials = strtoupper(substr($client->company_name, 0, 2));
    $statusCfg = [
    'active' => ['label' => 'Actif', 'cls' => 'bg-emerald-100 text-emerald-700 ring-emerald-200', 'dot' =>
    'bg-emerald-500'],
    'inactive' => ['label' => 'Inactif', 'cls' => 'bg-amber-100 text-amber-700 ring-amber-200', 'dot' =>
    'bg-amber-400'],
    'blocked' => ['label' => 'Bloqué', 'cls' => 'bg-red-100 text-red-600 ring-red-200', 'dot' => 'bg-red-500'],
    ];
    $sc = $statusCfg[$client->status] ?? $statusCfg['inactive'];

    $palette = ['#0e9f6e','#3f83f8','#f05252','#8b5cf6','#0891b2','#f59e0b','#ec4899','#10b981'];
    $hash = 0;
    foreach (str_split($client->company_name) as $ch) { $hash = (($hash << 5) - $hash) + ord($ch); }
        $avatarColor=$palette[abs($hash) % count($palette)]; @endphp <style>
        .tab-btn { border-bottom: 2px solid transparent; color: #64748b; font-size: 13px; font-weight: 600; padding:
        12px 2px; transition: all .15s; cursor: pointer; background: none; border-top: none; border-left: none;
        border-right: none; white-space: nowrap; }
        .tab-btn.active { border-bottom-color: #0f172a; color: #0f172a; }
        .tab-btn:hover:not(.active) { color: #334155; }
        .tab-pane { display: none; }
        .tab-pane.active { display: block; }
        .info-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px; }
        </style>

        <div class="flex flex-col gap-4">

            {{-- ── Breadcrumb + Header ── --}}
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <nav class="flex items-center gap-1.5 text-[11.5px] font-medium text-slate-400">
                        <a href="{{ route('admin.clients.index') }}" class="hover:text-slate-600 transition">Clients</a>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3 w-3">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                        <span class="text-slate-600">Détails du client</span>
                    </nav>
                    <h1 class="mt-1 text-[22px] font-black tracking-tight text-slate-900">Détails du client</h1>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.clients.index') }}"
                        class="inline-flex h-9 items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-4 text-[12.5px] font-semibold text-slate-600 shadow-sm transition hover:bg-slate-50">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                        Retour à la liste
                    </a>
                </div>
            </div>

            {{-- Flash --}}
            @if(session('success'))
            <div
                class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-[13px] font-semibold text-emerald-700">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 shrink-0">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
                {{ session('success') }}
            </div>
            @endif

            {{-- ── Profile card ── --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-wrap divide-y divide-slate-100 lg:flex-nowrap lg:divide-x lg:divide-y-0">

                    {{-- Zone 1 : Identity --}}
                    <div class="flex items-start gap-4 p-6 lg:w-[280px] shrink-0">
                        <span
                            class="inline-flex h-[60px] w-[60px] shrink-0 items-center justify-center rounded-2xl text-[20px] font-black text-white"
                            style="background:{{ $avatarColor }};">{{ $initials }}</span>
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-[16px] font-black text-slate-900 leading-tight">{{
                                    $client->company_name }}</span>
                                <span data-status-badge
                                    class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-[11px] font-bold ring-1 {{ $sc['cls'] }}">
                                    <span data-status-dot class="h-1.5 w-1.5 rounded-full {{ $sc['dot'] }}"></span>
                                    <span data-status-label>{{ $sc['label'] }}</span>
                                </span>
                            </div>
                            <p class="mt-0.5 text-[12px] font-medium text-slate-400">Entreprise</p>
                            <div class="mt-3 space-y-1.5 text-[12.5px] text-slate-600">
                                <div class="flex items-center gap-2">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                        class="h-3.5 w-3.5 shrink-0 text-slate-400">
                                        <path
                                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
                                    </svg>
                                    {{ $client->phone }}
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                        class="h-3.5 w-3.5 shrink-0 text-slate-400">
                                        <path
                                            d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                        <polyline points="22,6 12,13 2,6" />
                                    </svg>
                                    <span class="truncate">{{ $client->email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Zone 2 : Key details --}}
                    <div class="flex-1 p-6">
                        <dl class="grid grid-cols-2 gap-x-8 gap-y-4 text-[13px]">
                            <div>
                                <dt class="text-[10.5px] font-semibold uppercase tracking-wider text-slate-400">Code PCC
                                </dt>
                                <dd class="mt-1 flex items-center gap-2 font-mono font-semibold text-slate-800">
                                    {{ $client->pcc_customer_code ?? '—' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-[10.5px] font-semibold uppercase tracking-wider text-slate-400">Contact
                                </dt>
                                <dd class="mt-1 font-semibold text-slate-800">{{ $client->contact_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-[10.5px] font-semibold uppercase tracking-wider text-slate-400">Membre
                                    depuis</dt>
                                <dd class="mt-1 flex items-center gap-1.5 font-semibold text-slate-800">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                        class="h-3.5 w-3.5 text-slate-400">
                                        <rect x="3" y="4" width="18" height="18" rx="2" />
                                        <line x1="16" y1="2" x2="16" y2="6" />
                                        <line x1="8" y1="2" x2="8" y2="6" />
                                        <line x1="3" y1="10" x2="21" y2="10" />
                                    </svg>
                                    {{ $client->created_at?->format('d M Y') ?? '—' }}
                                </dd>
                            </div>
                            @if($client->accepted_at)
                            <div>
                                <dt class="text-[10.5px] font-semibold uppercase tracking-wider text-slate-400">Activé
                                    le</dt>
                                <dd class="mt-1 flex items-center gap-1.5 font-semibold text-slate-800">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                        class="h-3.5 w-3.5 text-slate-400">
                                        <circle cx="12" cy="12" r="10" />
                                        <polyline points="12 6 12 12 16 14" />
                                    </svg>
                                    {{ $client->accepted_at->format('d M Y') }}
                                    @if($client->acceptedBy) — {{ $client->acceptedBy->name }}@endif
                                </dd>
                            </div>
                            @endif
                        </dl>
                    </div>

                    {{-- Zone 3 : Points --}}
                    <div
                        class="flex flex-col items-center justify-center gap-1 border-t border-slate-100 bg-[#FFC60B]/5 px-8 py-6 text-center shrink-0 lg:border-t-0">
                        <p class="text-[10.5px] font-bold uppercase tracking-widest text-slate-500">Solde de points</p>
                        <p class="mt-1 text-[40px] font-black leading-none text-slate-900">
                            {{ number_format($client->points_balance, 0, ',', ' ') }}
                            <span class="text-[18px] font-semibold text-slate-500">pts</span>
                        </p>
                        @if($client->points_balance > 0)
                        <p class="mt-1 text-[12px] font-semibold text-slate-500">
                            ≈ {{ number_format($client->points_balance * 10, 0, ',', ' ') }} FCFA
                        </p>
                        @endif
                        <svg viewBox="0 0 24 24" fill="none" stroke="#FFC60B" stroke-width="1.5"
                            class="mt-1 h-7 w-7 opacity-50">
                            <polygon
                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                    </div>

                    {{-- Zone 4 : Quick actions --}}
                    <div
                        class="flex flex-col gap-0.5 border-t border-slate-100 px-6 py-6 shrink-0 min-w-[200px] lg:border-t-0">
                        <p class="mb-3 text-[10.5px] font-bold uppercase tracking-widest text-slate-400">Actions rapides
                        </p>
                        <div id="action-buttons" data-status="{{ $client->status }}"
                            data-activate-url="{{ route('admin.clients.activate', $client) }}"
                            data-block-url="{{ route('admin.clients.block', $client) }}"
                            data-unblock-url="{{ route('admin.clients.unblock', $client) }}"
                            data-csrf="{{ csrf_token() }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Tabs ── --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                <div class="flex gap-6 border-b border-slate-100 px-6 overflow-x-auto" id="client-tabs">
                    <button class="tab-btn active" data-tab="apercu">
                        <span class="flex items-center gap-1.5">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                class="h-3.5 w-3.5">
                                <rect x="3" y="3" width="7" height="7" />
                                <rect x="14" y="3" width="7" height="7" />
                                <rect x="14" y="14" width="7" height="7" />
                                <rect x="3" y="14" width="7" height="7" />
                            </svg>
                            Aperçu
                        </span>
                    </button>
                    <button class="tab-btn" data-tab="informations">
                        <span class="flex items-center gap-1.5">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                class="h-3.5 w-3.5">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                            Informations
                        </span>
                    </button>
                    <button class="tab-btn" data-tab="points">
                        <span class="flex items-center gap-1.5">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                class="h-3.5 w-3.5">
                                <polygon
                                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                            </svg>
                            Points
                        </span>
                    </button>
                </div>

                {{-- Tab: Aperçu --}}
                <div id="tab-apercu" class="tab-pane active p-6">
                    <div class="grid gap-5 lg:grid-cols-3">

                        {{-- Left (2/3) --}}
                        <div class="lg:col-span-2 flex flex-col gap-5">

                            {{-- Points summary --}}
                            <div class="info-card">
                                <h3 class="mb-4 text-[13px] font-bold text-slate-700">Résumé des points</h3>
                                <div class="grid grid-cols-2 gap-3">
                                    @php
                                    $chips = [
                                    ['icon' => '
                                    <polygon
                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                                    ', 'color' => '#3b82f6', 'bg' => '#eff6ff', 'label' => 'Solde actuel', 'val' =>
                                    number_format($client->points_balance, 0, ',', ' ') . ' pts'],
                                    ['icon' => '
                                    <polyline points="20 12 20 22 4 22 4 12" />
                                    <rect x="2" y="7" width="20" height="5" />
                                    <line x1="12" y1="22" x2="12" y2="7" />
                                    <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z" />
                                    <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z" />', 'color' => '#d97706',
                                    'bg' => '#fffbeb', 'label' => 'Valeur estimée', 'val' =>
                                    number_format($client->points_balance * 10, 0, ',', ' ') . ' FCFA'],
                                    ];
                                    @endphp
                                    @foreach($chips as $chip)
                                    <div
                                        class="flex items-center gap-3 rounded-xl border border-slate-100 bg-slate-50/60 p-4">
                                        <span
                                            class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-100"
                                            style="background:{{ $chip['bg'] }}">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="{{ $chip['color'] }}"
                                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                                class="h-5 w-5">{!! $chip['icon'] !!}</svg>
                                        </span>
                                        <div>
                                            <p
                                                class="text-[10.5px] font-semibold uppercase tracking-wider text-slate-400">
                                                {{ $chip['label'] }}</p>
                                            <p class="mt-0.5 text-[15px] font-black text-slate-900">{{ $chip['val'] }}
                                            </p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Last activities --}}
                            <div class="info-card">
                                <h3 class="mb-4 text-[13px] font-bold text-slate-700">Dernières activités</h3>
                                <div
                                    class="rounded-xl border border-dashed border-slate-200 bg-slate-50 px-5 py-10 text-center">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        class="mx-auto h-10 w-10 text-slate-300">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                        <polyline points="14 2 14 8 20 8" />
                                        <line x1="16" y1="13" x2="8" y2="13" />
                                        <line x1="16" y1="17" x2="8" y2="17" />
                                    </svg>
                                    <p class="mt-3 text-[13px] font-semibold text-slate-400">Aucune activité enregistrée
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Right (1/3) --}}
                        <div class="flex flex-col gap-5">

                            {{-- Informations clés --}}
                            <div class="info-card">
                                <h3 class="mb-4 text-[13px] font-bold text-slate-700">Informations clés</h3>
                                <dl class="space-y-3">
                                    @php
                                    $keyInfo = [
                                    ['
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
                                    ', 'Téléphone', $client->phone],
                                    ['
                                    <path
                                        d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                    <polyline points="22,6 12,13 2,6" />', 'Email', $client->email],
                                    ['
                                    <rect x="3" y="4" width="18" height="18" rx="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />', 'Inscription',
                                    $client->created_at?->format('d M Y') ?? '—'],
                                    ['
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="2" y1="12" x2="22" y2="12" />
                                    <path
                                        d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                                    ', 'Code PCC', $client->pcc_customer_code ?? '—'],
                                    ['
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />', 'Contact', $client->contact_name],
                                    ];
                                    @endphp
                                    @foreach($keyInfo as [$ico, $lbl, $val])
                                    <div class="flex items-center justify-between gap-3 text-[12.5px]">
                                        <div class="flex items-center gap-2.5 text-slate-500 shrink-0">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                                class="h-4 w-4 shrink-0 text-slate-400">{!! $ico !!}</svg>
                                            {{ $lbl }}
                                        </div>
                                        <span class="font-semibold text-slate-800 text-right truncate max-w-[140px]">{{
                                            $val }}</span>
                                    </div>
                                    @endforeach
                                </dl>
                            </div>

                            {{-- Activation info --}}
                            @if($client->accepted_at)
                            <div class="info-card border-[#FFC60B]/30 bg-[#FFC60B]/5">
                                <h3 class="text-[13px] font-bold text-slate-700">Activation</h3>
                                <p class="mt-2 text-[12.5px] leading-relaxed text-slate-600">
                                    Le <strong>{{ $client->accepted_at->format('d M Y à H:i') }}</strong>
                                    @if($client->acceptedBy)<br>par <strong>{{ $client->acceptedBy->name
                                        }}</strong>@endif
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Tab: Informations --}}
                <div id="tab-informations" class="tab-pane p-6">
                    <div class="max-w-2xl">
                        <dl class="grid grid-cols-2 gap-x-8 gap-y-5 text-[13px]">
                            @foreach([
                            ['Email', $client->email],
                            ['Téléphone', $client->phone],
                            ['Contact', $client->contact_name],
                            ['Code PCC', $client->pcc_customer_code ?? '—'],
                            ['Statut', $sc['label']],
                            ['Inscription', $client->created_at?->format('d M Y') ?? '—'],
                            ] as [$lbl, $val])
                            <div class="flex flex-col gap-1 border-b border-slate-100 pb-4">
                                <dt class="text-[10.5px] font-bold uppercase tracking-wider text-slate-400">{{ $lbl }}
                                </dt>
                                <dd class="font-semibold text-slate-800">{{ $val }}</dd>
                            </div>
                            @endforeach
                        </dl>
                    </div>
                </div>

                {{-- Tab: Points --}}
                <div id="tab-points" class="tab-pane p-6">
                    <div class="grid grid-cols-2 gap-4 max-w-sm">
                        <div class="rounded-xl border border-slate-200 bg-white p-5 text-center shadow-sm">
                            <p class="text-[10.5px] font-bold uppercase tracking-wider text-slate-400">Solde actuel</p>
                            <p class="mt-2 text-[32px] font-black leading-none text-slate-900">{{
                                number_format($client->points_balance, 0, ',', ' ') }}</p>
                            <p class="mt-1 text-[11px] text-slate-400">points</p>
                        </div>
                        <div class="rounded-xl border border-[#FFC60B]/40 bg-[#FFC60B]/8 p-5 text-center shadow-sm">
                            <p class="text-[10.5px] font-bold uppercase tracking-wider text-slate-500">Valeur estimée
                            </p>
                            <p class="mt-2 text-[32px] font-black leading-none text-slate-900">{{
                                number_format($client->points_balance * 10, 0, ',', ' ') }}</p>
                            <p class="mt-1 text-[11px] text-slate-500">FCFA</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Toast --}}
        <div id="pcc-toast"
            class="pointer-events-none fixed top-6 left-1/2 z-50 flex flex-col items-center gap-3 -translate-x-1/2">
        </div>

        <script>
            /* ── Tabs ── */
        document.getElementById('client-tabs')?.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById('tab-' + btn.dataset.tab)?.classList.add('active');
            });
        });

        /* ── Toast ── */
        function showToast(msg, type) {
            const bg   = type === 'error' ? 'background:#dc2626' : 'background:#059669';
            const icon = type === 'error'
                ? '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>'
                : '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>';
            const t = document.createElement('div');
            t.style.cssText = `pointer-events:auto;display:flex;align-items:center;gap:10px;border-radius:16px;padding:10px 20px;font-size:13px;font-weight:600;color:#fff;box-shadow:0 8px 30px -8px rgba(0,0,0,.35);transition:all .3s ease;transform:translateY(-12px);opacity:0;${bg}`;
            t.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" width="16" height="16" style="flex-shrink:0">${icon}</svg><span>${msg}</span>`;
            document.getElementById('pcc-toast').appendChild(t);
            requestAnimationFrame(() => requestAnimationFrame(() => { t.style.transform = 'translateY(0)'; t.style.opacity = '1'; }));
            setTimeout(() => { t.style.transform = 'translateY(-12px)'; t.style.opacity = '0'; setTimeout(() => t.remove(), 300); }, 3500);
        }

        /* ── Status config ── */
        const STATUS_CFG = {
            active:   { label: 'Actif',   badgeCls: 'bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200', dotCls: 'bg-emerald-500' },
            inactive: { label: 'Inactif', badgeCls: 'bg-amber-100 text-amber-700 ring-1 ring-amber-200',       dotCls: 'bg-amber-400'   },
            blocked:  { label: 'Bloqué',  badgeCls: 'bg-red-100 text-red-600 ring-1 ring-red-200',             dotCls: 'bg-red-500'     },
        };

        /* ── Render action buttons ── */
        function renderButtons(status) {
            const el   = document.getElementById('action-buttons');
            const urls = { activate: el.dataset.activateUrl, block: el.dataset.blockUrl, unblock: el.dataset.unblockUrl };
            const base = 'flex w-full items-center gap-2 rounded-xl px-3 py-2.5 text-[12.5px] font-semibold transition';
            const iOk  = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>';
            const iBan = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>';
            let html = '';
            if (status === 'inactive') {
                html += `<button type="button" class="${base} bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200" data-action="activate" data-url="${urls.activate}">${iOk} Activer le client</button>`;
            } else if (status === 'blocked') {
                html += `<button type="button" class="${base} bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200" data-action="unblock" data-url="${urls.unblock}">${iOk} Débloquer le client</button>`;
            }
            if (status !== 'blocked') {
                html += `<button type="button" class="${base} mt-1 text-red-600 hover:bg-red-50 border border-transparent hover:border-red-200" data-action="block" data-url="${urls.block}">${iBan} Bloquer le client</button>`;
            }
            el.innerHTML = html;
            el.querySelectorAll('button[data-action]').forEach(btn => btn.addEventListener('click', handleAction));
        }

        /* ── Update badge ── */
        function updateBadge(status) {
            const cfg = STATUS_CFG[status];
            if (!cfg) return;
            document.querySelectorAll('[data-status-badge]').forEach(badge => {
                badge.className = `inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-[11px] font-bold ${cfg.badgeCls}`;
                const dot = badge.querySelector('[data-status-dot]');
                if (dot) dot.className = `h-1.5 w-1.5 rounded-full ${cfg.dotCls}`;
                const label = badge.querySelector('[data-status-label]');
                if (label) label.textContent = cfg.label;
            });
        }

        /* ── AJAX handler ── */
        function handleAction(e) {
            const btn  = e.currentTarget;
            const url  = btn.dataset.url;
            const csrf = document.getElementById('action-buttons').dataset.csrf;
            btn.disabled = true; btn.style.opacity = '0.6';
            fetch(url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'Content-Type': 'application/json' },
            })
            .then(r => r.json())
            .then(data => {
                if (data.status) {
                    document.getElementById('action-buttons').dataset.status = data.status;
                    renderButtons(data.status);
                    updateBadge(data.status);
                    showToast(data.message ?? 'Statut mis à jour.', 'success');
                } else {
                    showToast(data.message ?? 'Erreur.', 'error');
                    btn.disabled = false; btn.style.opacity = '';
                }
            })
            .catch(() => { showToast('Erreur de connexion.', 'error'); btn.disabled = false; btn.style.opacity = ''; });
        }

        /* ── Init ── */
        (function () { const el = document.getElementById('action-buttons'); if (el) renderButtons(el.dataset.status); })();
        </script>
</x-app-layout>