<x-app-layout>

@php
    /* ── Status config ── */
    $initials = strtoupper(substr($client->company_name, 0, 2));
    $statusCfg = [
        'active'   => ['label' => 'Actif',   'cls' => 'bg-emerald-100 text-emerald-700 ring-emerald-200', 'dot' => 'bg-emerald-500'],
        'inactive' => ['label' => 'Inactif', 'cls' => 'bg-amber-100  text-amber-700  ring-amber-200',     'dot' => 'bg-amber-400'],
        'blocked'  => ['label' => 'Bloqué',  'cls' => 'bg-red-100    text-red-600    ring-red-200',       'dot' => 'bg-red-500'],
    ];
    $sc = $statusCfg[$client->status] ?? $statusCfg['inactive'];

    /* ── Avatar color ── */
    $palette = ['#0e9f6e','#3f83f8','#f05252','#8b5cf6','#0891b2','#f59e0b','#ec4899','#10b981'];
    $hash = 0;
    foreach (str_split($client->company_name) as $ch) { $hash = (($hash << 5) - $hash) + ord($ch); }
    $avatarColor = $palette[abs($hash) % count($palette)];

    /* ── Fake / demo data ── */
    $fake = [
        'pcc_code'         => $client->pcc_customer_code ?? 'SBQIHVSUQS72',
        'commercial'       => 'Amani KOUADIO',
        'member_since'     => $client->created_at?->format('d M Y') ?? '12 Mai 2025',
        'last_activity'    => '12 Mai 2025',
        'last_act_label'   => 'Achat effectué',
        'points_balance'   => $client->points_balance ?? 1250,
        'points_total_in'  => 2500,
        'points_total_out' => 1250,
        'points_expiring'  => 150,
        'points_exp_date'  => '12 Juin 2025',
        'client_type'      => 'Entreprise',
        'sector'           => 'BTP / Construction',
        'rccm'             => 'CI-ABJ-2020-B-12345',
        'cnps'             => '9876543 A',
        'tax_regime'       => 'Régime réel',
        'address'          => "Cocody Riviera 3, Abidjan\nCôte d'Ivoire",
        'phone'            => $client->phone ?? '212 660 079 722',
        'email'            => $client->email ?? 'bebeqevy@mailinator.com',
        'note'             => 'Client stratégique. Très bon historique de paiement. Prioritaire pour les promotions.',
        'note_author'      => 'Amani KOUADIO',
        'note_date'        => '12 Mai 2025',
        'activities'       => [
            ['date' => '12 Mai 2025, 10:23', 'type' => 'Achat',       'tc' => 'emerald', 'desc' => 'Achat de la facture FA-2025-0587',               'pts' => '+250 pts', 'pc' => 'emerald', 'user' => 'Amani KOUADIO'],
            ['date' => '25 Avr 2025, 14:15', 'type' => 'Utilisation', 'tc' => 'red',     'desc' => "Utilisation des points – Bon d'achat BA-2025-0012", 'pts' => '-300 pts', 'pc' => 'red',     'user' => 'Amani KOUADIO'],
            ['date' => '18 Avr 2025, 09:42', 'type' => 'Achat',       'tc' => 'emerald', 'desc' => 'Achat de la facture FA-2025-0451',               'pts' => '+150 pts', 'pc' => 'emerald', 'user' => 'Amani KOUADIO'],
            ['date' => '10 Avr 2025, 11:00', 'type' => 'Achat',       'tc' => 'emerald', 'desc' => 'Achat de la facture FA-2025-0389',               'pts' => '+200 pts', 'pc' => 'emerald', 'user' => 'Amani KOUADIO'],
            ['date' => '02 Avr 2025, 08:30', 'type' => 'Utilisation', 'tc' => 'red',     'desc' => "Bon d'achat BA-2025-0008",                       'pts' => '-100 pts', 'pc' => 'red',     'user' => 'Amani KOUADIO'],
            ['date' => '28 Mar 2025, 16:45', 'type' => 'Achat',       'tc' => 'emerald', 'desc' => 'Achat de la facture FA-2025-0310',               'pts' => '+350 pts', 'pc' => 'emerald', 'user' => 'Amani KOUADIO'],
        ],
        'chart_labels' => ["Juin'24","Juil'24","Août'24","Sept'24","Oct'24","Nov'24","Déc'24","Janv'25","Fév'25","Mars'25","Avr'25","Mai'25"],
        'chart_data'   => [820, 1050, 1190, 1320, 1480, 1610, 1870, 2100, 2350, 2580, 2750, 2420],
    ];
@endphp

{{-- ══ Styles ══ --}}
<style>
    .tab-btn { border-bottom: 2px solid transparent; color: #64748b; font-size: 13px; font-weight: 600; padding: 14px 2px; transition: all .15s; cursor: pointer; background: none; border-top: none; border-left: none; border-right: none; white-space: nowrap; }
    .tab-btn.active { border-bottom-color: #0f172a; color: #0f172a; }
    .tab-btn:hover:not(.active) { color: #334155; }
    .tab-pane { display: none; }
    .tab-pane.active { display: block; }
    .info-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px; }
</style>

<div class="flex flex-col gap-4">

    {{-- ══ Breadcrumb + Header ══ --}}
    <div class="flex flex-wrap items-start justify-between gap-3">
        <div>
            <nav class="flex items-center gap-1.5 text-[11.5px] font-medium text-slate-400">
                <a href="{{ route('clients') }}" class="hover:text-slate-600 transition">Clients</a>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3 w-3"><path d="m9 18 6-6-6-6"/></svg>
                <span class="text-slate-600">Détails du client</span>
            </nav>
            <h1 class="mt-1 text-[22px] font-black tracking-tight text-slate-900">Détails du client</h1>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('clients') }}"
               class="inline-flex h-9 items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-4 text-[12.5px] font-semibold text-slate-600 shadow-sm transition hover:bg-slate-50">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><path d="m15 18-6-6 6-6"/></svg>
                Retour à la liste
            </a>
            <a href="#"
               class="inline-flex h-9 items-center gap-1.5 rounded-xl bg-slate-900 px-4 text-[12.5px] font-semibold text-white shadow-sm transition hover:bg-slate-700">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Modifier le client
            </a>
            <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 shadow-sm hover:bg-slate-50 transition">
                <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/></svg>
            </button>
        </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-[13px] font-semibold text-emerald-700">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 shrink-0"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- ══ Profile card ══ --}}
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
        <div class="flex flex-wrap divide-y divide-slate-100 lg:flex-nowrap lg:divide-x lg:divide-y-0">

            {{-- Zone 1 : Identity --}}
            <div class="flex items-start gap-4 p-6 lg:w-[260px] shrink-0">
                <span class="inline-flex h-[56px] w-[56px] shrink-0 items-center justify-center rounded-2xl text-[18px] font-black text-white"
                      style="background:{{ $avatarColor }};">{{ $initials }}</span>
                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-[16px] font-black text-slate-900 leading-tight">{{ $client->company_name }}</span>
                        <span data-status-badge class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-[11px] font-bold ring-1 {{ $sc['cls'] }}">
                            <span data-status-dot class="h-1.5 w-1.5 rounded-full {{ $sc['dot'] }}"></span>
                            <span data-status-label>{{ $sc['label'] }}</span>
                        </span>
                    </div>
                    <p class="mt-0.5 text-[12px] font-medium text-slate-400">{{ $fake['client_type'] }}</p>
                    <div class="mt-3 space-y-1.5 text-[12.5px] text-slate-600">
                        <div class="flex items-center gap-2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-3.5 w-3.5 shrink-0 text-slate-400"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            {{ $fake['phone'] }}
                        </div>
                        <div class="flex items-center gap-2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-3.5 w-3.5 shrink-0 text-slate-400"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            <span class="truncate">{{ $fake['email'] }}</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-3.5 w-3.5 shrink-0 text-slate-400 mt-0.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span>{{ $fake['address'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Zone 2 : Key details --}}
            <div class="flex-1 p-6">
                <dl class="grid grid-cols-2 gap-x-8 gap-y-4 text-[13px]">
                    <div>
                        <dt class="text-[10.5px] font-semibold uppercase tracking-wider text-slate-400">Code PCC</dt>
                        <dd class="mt-1 flex items-center gap-2 font-mono font-semibold text-slate-800">
                            {{ $fake['pcc_code'] }}
                            <button onclick="navigator.clipboard.writeText('{{ $fake['pcc_code'] }}')" title="Copier" class="text-slate-400 hover:text-slate-600 transition">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-3.5 w-3.5"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                            </button>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-[10.5px] font-semibold uppercase tracking-wider text-slate-400">Commercial référent</dt>
                        <dd class="mt-1 flex items-center gap-1.5 font-semibold text-slate-800">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-3.5 w-3.5 text-slate-400"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            {{ $fake['commercial'] }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-[10.5px] font-semibold uppercase tracking-wider text-slate-400">Membre depuis</dt>
                        <dd class="mt-1 flex items-center gap-1.5 font-semibold text-slate-800">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-3.5 w-3.5 text-slate-400"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            {{ $fake['member_since'] }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-[10.5px] font-semibold uppercase tracking-wider text-slate-400">Dernière activité</dt>
                        <dd class="mt-1 flex items-center gap-1.5 font-semibold text-slate-800">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-3.5 w-3.5 text-slate-400"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            {{ $fake['last_activity'] }}
                            <span class="text-[11px] font-normal text-slate-400">{{ $fake['last_act_label'] }}</span>
                        </dd>
                    </div>
                </dl>
            </div>

            {{-- Zone 3 : Points --}}
            <div class="flex flex-col items-center justify-center gap-1 border-t border-slate-100 bg-emerald-50/40 px-8 py-6 text-center shrink-0 lg:border-t-0">
                <p class="text-[10.5px] font-bold uppercase tracking-widest text-slate-500">Solde de points</p>
                <p class="mt-1 text-[40px] font-black leading-none text-slate-900">
                    {{ number_format($fake['points_balance'], 0, ',', ' ') }}
                    <span class="text-[18px] font-semibold text-slate-500">pts</span>
                </p>
                <p class="mt-1.5 text-[11px] font-semibold text-slate-400">Valeur estimée</p>
                <p class="text-[13px] font-bold text-slate-700">{{ number_format($fake['points_balance'] * 100, 0, ',', ' ') }} FCFA</p>
                <svg viewBox="0 0 24 24" fill="none" stroke="#FFC60B" stroke-width="1.5" class="mt-2 h-7 w-7 opacity-60">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                </svg>
            </div>

            {{-- Zone 4 : Quick actions --}}
            <div class="flex flex-col gap-0.5 border-t border-slate-100 px-6 py-6 shrink-0 min-w-[200px] lg:border-t-0">
                <p class="mb-3 text-[10.5px] font-bold uppercase tracking-widest text-slate-400">Actions rapides</p>
                <a href="#" class="flex items-center gap-2 rounded-xl px-3 py-2.5 text-[12.5px] font-semibold text-emerald-700 hover:bg-emerald-50 border border-transparent hover:border-emerald-200 transition">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                    Attribuer des points
                </a>
                <a href="#" class="flex items-center gap-2 rounded-xl px-3 py-2.5 text-[12.5px] font-semibold text-slate-600 hover:bg-slate-50 border border-transparent hover:border-slate-200 transition">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><circle cx="12" cy="12" r="10"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                    Retirer des points
                </a>
                <a href="#" class="flex items-center gap-2 rounded-xl px-3 py-2.5 text-[12.5px] font-semibold text-slate-600 hover:bg-slate-50 border border-transparent hover:border-slate-200 transition">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.5"/></svg>
                    Historique des points
                </a>
                <div id="action-buttons"
                     data-status="{{ $client->status }}"
                     data-activate-url="{{ route('clients.activate', $client) }}"
                     data-block-url="{{ route('clients.block', $client) }}"
                     data-unblock-url="{{ route('clients.unblock', $client) }}"
                     data-csrf="{{ csrf_token() }}">
                </div>
            </div>
        </div>
    </div>

    {{-- ══ Tabs ══ --}}
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
        <div class="flex gap-6 border-b border-slate-100 px-6 overflow-x-auto" id="client-tabs">
            @foreach([
                ['apercu',        '<rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>',      'Aperçu'],
                ['informations',  '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>',                                                         'Informations'],
                ['activites',     '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',                                                                                                                       'Activité & Achats'],
                ['points',        '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>',                                                        'Points'],
                ['transactions',  '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>',                                                                     'Transactions'],
                ['livraisons',    '<rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>',  'Livraisons'],
                ['documents',     '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>',                                                               'Documents'],
            ] as [$id, $icon, $label])
            <button class="tab-btn {{ $id === 'apercu' ? 'active' : '' }}" data-tab="{{ $id }}">
                <span class="flex items-center gap-1.5">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-3.5 w-3.5">{!! $icon !!}</svg>
                    {{ $label }}
                </span>
            </button>
            @endforeach
        </div>

        {{-- ─── Tab: Aperçu ─── --}}
        <div id="tab-apercu" class="tab-pane active p-6">
            <div class="grid gap-5 lg:grid-cols-3">

                {{-- Left 2/3 --}}
                <div class="lg:col-span-2 flex flex-col gap-5">

                    {{-- Points summary chips --}}
                    <div class="info-card">
                        <h3 class="mb-4 text-[13px] font-bold text-slate-700">Résumé des points</h3>
                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                            @php
                            $chips = [
                                ['bg'=>'#eff6ff','stroke'=>'#3b82f6','path'=>'<path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14 2 9.27l6.91-1.01L12 2z"/>',
                                 'label'=>'Total gagnés', 'value'=>number_format($fake['points_total_in'],0,',',' ').' pts', 'sub'=>"Depuis l'inscription"],
                                ['bg'=>'#f0fdf4','stroke'=>'#22c55e','path'=>'<polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/>',
                                 'label'=>'Total utilisés','value'=>number_format($fake['points_total_out'],0,',',' ').' pts','sub'=>"Depuis l'inscription"],
                                ['bg'=>'#eef2ff','stroke'=>'#6366f1','path'=>'<polyline points="1 4 1 10 7 10"/><polyline points="23 20 23 14 17 14"/><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"/>',
                                 'label'=>'Solde actuel', 'value'=>number_format($fake['points_balance'],0,',',' ').' pts',  'sub'=>'+ '.number_format($fake['points_balance']*100,0,',',' ').' FCFA'],
                                ['bg'=>'#fff7ed','stroke'=>'#f97316','path'=>'<polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/>',
                                 'label'=>'Points expirant','value'=>number_format($fake['points_expiring'],0,',',' ').' pts','sub'=>'Expire le '.$fake['points_exp_date']],
                            ];
                            @endphp
                            @foreach($chips as $chip)
                            <div class="flex items-start gap-3 rounded-xl border border-slate-100 bg-slate-50/60 p-4">
                                <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-100" style="background:{{ $chip['bg'] }}">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="{{ $chip['stroke'] }}" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">{!! $chip['path'] !!}</svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-[10.5px] font-semibold uppercase tracking-wider text-slate-400">{{ $chip['label'] }}</p>
                                    <p class="mt-0.5 text-[14px] font-black text-slate-900 leading-tight">{{ $chip['value'] }}</p>
                                    <p class="mt-0.5 text-[10.5px] text-slate-400">{{ $chip['sub'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- ApexCharts --}}
                    <div class="info-card">
                        <div class="mb-4 flex items-center justify-between gap-3">
                            <h3 class="text-[13px] font-bold text-slate-700">Évolution des points</h3>
                            <select id="chart-range" class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-[12px] font-semibold text-slate-600 focus:outline-none cursor-pointer">
                                <option value="12">12 derniers mois</option>
                                <option value="6">6 derniers mois</option>
                                <option value="3">3 derniers mois</option>
                            </select>
                        </div>
                        <div id="points-chart" style="min-height:220px;"></div>
                    </div>

                    {{-- Activities table --}}
                    <div class="info-card">
                        <h3 class="mb-4 text-[13px] font-bold text-slate-700">Dernières activités</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-[12.5px]">
                                <thead>
                                    <tr class="border-b border-slate-100">
                                        <th class="pb-3 text-left text-[10.5px] font-bold uppercase tracking-wider text-slate-400">Date</th>
                                        <th class="pb-3 text-left text-[10.5px] font-bold uppercase tracking-wider text-slate-400">Type</th>
                                        <th class="pb-3 text-left text-[10.5px] font-bold uppercase tracking-wider text-slate-400">Description</th>
                                        <th class="pb-3 text-right text-[10.5px] font-bold uppercase tracking-wider text-slate-400">Points</th>
                                        <th class="pb-3 pl-4 text-left text-[10.5px] font-bold uppercase tracking-wider text-slate-400">Utilisateur</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @foreach(array_slice($fake['activities'], 0, 3) as $act)
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="py-3 text-slate-500 whitespace-nowrap">{{ $act['date'] }}</td>
                                        <td class="py-3">
                                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[11px] font-bold {{ $act['tc']==='emerald' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-600' }}">{{ $act['type'] }}</span>
                                        </td>
                                        <td class="py-3 text-slate-700">{{ $act['desc'] }}</td>
                                        <td class="py-3 text-right font-bold whitespace-nowrap {{ $act['pc']==='emerald' ? 'text-emerald-600' : 'text-red-500' }}">{{ $act['pts'] }}</td>
                                        <td class="py-3 pl-4 text-slate-600">{{ $act['user'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 flex justify-center">
                            <button type="button" onclick="document.querySelector('[data-tab=activites]').click()"
                                    class="rounded-xl border border-slate-200 bg-slate-50 px-5 py-2 text-[12.5px] font-semibold text-slate-600 hover:bg-slate-100 transition">
                                Voir toutes les activités
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Right 1/3 --}}
                <div class="flex flex-col gap-5">

                    {{-- Informations clés --}}
                    <div class="info-card">
                        <h3 class="mb-4 text-[13px] font-bold text-slate-700">Informations clés</h3>
                        <dl class="space-y-3.5">
                            @php
                            $keyInfo = [
                                ['<path d="M20 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>','Type de client',    $fake['client_type']],
                                ['<path d="M22 12h-4l-3 9L9 3l-3 9H2"/>',                                                                                                         "Secteur d'activité",$fake['sector']],
                                ['<rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>',               'Numéro RCCM',       $fake['rccm']],
                                ['<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',                                                          'N° CNPS',           $fake['cnps']],
                                ['<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>',                                   'Régime fiscal',     $fake['tax_regime']],
                                ['<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>',                                                    'Adresse',           $fake['address']],
                            ];
                            @endphp
                            @foreach($keyInfo as [$ico, $lbl, $val])
                            <div class="flex items-start justify-between gap-3 text-[12.5px]">
                                <div class="flex items-center gap-2 text-slate-500 shrink-0 pt-0.5">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 shrink-0 text-slate-400">{!! $ico !!}</svg>
                                    <span class="whitespace-nowrap">{{ $lbl }}</span>
                                </div>
                                <span class="font-semibold text-slate-800 text-right text-[12px]">{{ $val }}</span>
                            </div>
                            @endforeach
                        </dl>
                    </div>

                    {{-- Notes --}}
                    <div class="info-card">
                        <div class="mb-3 flex items-center justify-between">
                            <h3 class="text-[13px] font-bold text-slate-700">Notes</h3>
                            <button class="text-slate-400 hover:text-slate-600 transition">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                        </div>
                        <div class="rounded-xl bg-amber-50 border border-amber-100 px-4 py-3">
                            <p class="text-[12.5px] leading-relaxed text-slate-700">{{ $fake['note'] }}</p>
                            <div class="mt-3 flex items-center justify-between border-t border-amber-100 pt-2.5">
                                <span class="text-[11px] font-semibold text-slate-500">Ajoutée par <strong>{{ $fake['note_author'] }}</strong></span>
                                <span class="text-[11px] text-slate-400">{{ $fake['note_date'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ─── Tab: Informations ─── --}}
        <div id="tab-informations" class="tab-pane p-6">
            <div class="max-w-2xl">
                <dl class="grid grid-cols-2 gap-x-8 gap-y-5 text-[13px]">
                    @foreach([
                        ['Email',          $fake['email']],
                        ['Téléphone',      $fake['phone']],
                        ['Contact',        $client->contact_name ?? '—'],
                        ['Code PCC',       $fake['pcc_code']],
                        ['Statut',         $sc['label']],
                        ['Inscription',    $fake['member_since']],
                        ['Type de client', $fake['client_type']],
                        ['Secteur',        $fake['sector']],
                        ['RCCM',           $fake['rccm']],
                        ['CNPS',           $fake['cnps']],
                        ['Régime fiscal',  $fake['tax_regime']],
                        ['Adresse',        $fake['address']],
                    ] as [$lbl, $val])
                    <div class="flex flex-col gap-1 border-b border-slate-100 pb-4">
                        <dt class="text-[10.5px] font-bold uppercase tracking-wider text-slate-400">{{ $lbl }}</dt>
                        <dd class="font-semibold text-slate-800">{{ $val }}</dd>
                    </div>
                    @endforeach
                </dl>
            </div>
        </div>

        {{-- ─── Tab: Activité & Achats ─── --}}
        <div id="tab-activites" class="tab-pane p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-[12.5px]">
                    <thead>
                        <tr class="border-b border-slate-100">
                            <th class="pb-3 text-left text-[10.5px] font-bold uppercase tracking-wider text-slate-400">Date</th>
                            <th class="pb-3 text-left text-[10.5px] font-bold uppercase tracking-wider text-slate-400">Type</th>
                            <th class="pb-3 text-left text-[10.5px] font-bold uppercase tracking-wider text-slate-400">Description</th>
                            <th class="pb-3 text-right text-[10.5px] font-bold uppercase tracking-wider text-slate-400">Points</th>
                            <th class="pb-3 pl-4 text-left text-[10.5px] font-bold uppercase tracking-wider text-slate-400">Utilisateur</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($fake['activities'] as $act)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3 text-slate-500 whitespace-nowrap">{{ $act['date'] }}</td>
                            <td class="py-3">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[11px] font-bold {{ $act['tc']==='emerald' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-600' }}">{{ $act['type'] }}</span>
                            </td>
                            <td class="py-3 text-slate-700">{{ $act['desc'] }}</td>
                            <td class="py-3 text-right font-bold whitespace-nowrap {{ $act['pc']==='emerald' ? 'text-emerald-600' : 'text-red-500' }}">{{ $act['pts'] }}</td>
                            <td class="py-3 pl-4 text-slate-600">{{ $act['user'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ─── Tab: Points ─── --}}
        <div id="tab-points" class="tab-pane p-6">
            <div class="grid grid-cols-2 gap-4 max-w-lg">
                @foreach([
                    ['Solde actuel',   number_format($fake['points_balance'],   0,',',' '), 'pts',  'border-slate-200 bg-white'],
                    ['Total gagnés',   number_format($fake['points_total_in'],  0,',',' '), 'pts',  'border-emerald-200 bg-emerald-50'],
                    ['Total utilisés', number_format($fake['points_total_out'], 0,',',' '), 'pts',  'border-red-200 bg-red-50'],
                    ['Valeur estimée', number_format($fake['points_balance']*100,0,',',' '), 'FCFA', 'border-amber-200 bg-amber-50'],
                ] as [$label, $val, $unit, $cls])
                <div class="rounded-xl border {{ $cls }} p-5 text-center shadow-sm">
                    <p class="text-[10.5px] font-bold uppercase tracking-wider text-slate-400">{{ $label }}</p>
                    <p class="mt-2 text-[28px] font-black leading-none text-slate-900">{{ $val }}</p>
                    <p class="mt-1 text-[11px] text-slate-400">{{ $unit }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ─── Tab: Transactions ─── --}}
        <div id="tab-transactions" class="tab-pane p-6">
            <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50 px-5 py-14 text-center">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mx-auto h-10 w-10 text-slate-300"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                <p class="mt-3 text-[13px] font-semibold text-slate-400">Aucune transaction enregistrée</p>
            </div>
        </div>

        {{-- ─── Tab: Livraisons ─── --}}
        <div id="tab-livraisons" class="tab-pane p-6">
            <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50 px-5 py-14 text-center">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mx-auto h-10 w-10 text-slate-300"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                <p class="mt-3 text-[13px] font-semibold text-slate-400">Aucune livraison enregistrée</p>
            </div>
        </div>

        {{-- ─── Tab: Documents ─── --}}
        <div id="tab-documents" class="tab-pane p-6">
            <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50 px-5 py-14 text-center">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mx-auto h-10 w-10 text-slate-300"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <p class="mt-3 text-[13px] font-semibold text-slate-400">Aucun document disponible</p>
            </div>
        </div>
    </div>
</div>

{{-- Toast --}}
<div id="pcc-toast" class="pointer-events-none fixed top-6 left-1/2 z-50 flex flex-col items-center gap-3 -translate-x-1/2"></div>

{{-- ApexCharts CDN --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.49.0/dist/apexcharts.min.js"></script>

<script>
/* ── Chart data from server ── */
const ALL_LABELS = @json($fake['chart_labels']);
const ALL_DATA   = @json($fake['chart_data']);
let chartInst    = null;

function buildChartOptions(months) {
    const labels = ALL_LABELS.slice(-months);
    const data   = ALL_DATA.slice(-months);
    return {
        series: [{ name: 'Points', data }],
        chart: { type: 'area', height: 220, toolbar: { show: false }, animations: { enabled: true, speed: 400 } },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2.5, colors: ['#d97706'] },
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.35, opacityTo: 0.02, stops: [0, 95] }, colors: ['#FFC60B'] },
        xaxis: { categories: labels, labels: { style: { fontSize: '11px', fontFamily: 'Manrope, sans-serif', colors: '#94a3b8' } }, axisBorder: { show: false }, axisTicks: { show: false } },
        yaxis: { labels: { style: { fontSize: '11px', fontFamily: 'Manrope, sans-serif', colors: '#94a3b8' }, formatter: v => v >= 1000 ? (v/1000).toFixed(1)+'K' : v } },
        grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
        tooltip: { y: { formatter: v => v.toLocaleString('fr-FR') + ' pts' }, style: { fontSize: '12px', fontFamily: 'Manrope, sans-serif' } },
        markers: { size: 3, colors: ['#d97706'], strokeColors: '#fff', strokeWidth: 2, hover: { size: 5 } },
        colors: ['#FFC60B'],
    };
}

document.addEventListener('DOMContentLoaded', () => {
    const el = document.querySelector('#points-chart');
    if (el) { chartInst = new ApexCharts(el, buildChartOptions(12)); chartInst.render(); }
    document.getElementById('chart-range')?.addEventListener('change', function () {
        if (chartInst) chartInst.updateOptions(buildChartOptions(parseInt(this.value)), true, true);
    });
});

/* ── Tabs ── */
document.getElementById('client-tabs')?.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('tab-' + btn.dataset.tab)?.classList.add('active');
        if (btn.dataset.tab === 'apercu' && chartInst) setTimeout(() => chartInst.render(), 50);
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
    active:   { label:'Actif',   badgeCls:'bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200', dotCls:'bg-emerald-500' },
    inactive: { label:'Inactif', badgeCls:'bg-amber-100 text-amber-700 ring-1 ring-amber-200',       dotCls:'bg-amber-400'   },
    blocked:  { label:'Bloqué',  badgeCls:'bg-red-100 text-red-600 ring-1 ring-red-200',             dotCls:'bg-red-500'     },
};

function renderButtons(status) {
    const el = document.getElementById('action-buttons');
    if (!el) return;
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
    el.querySelectorAll('button[data-action]').forEach(b => b.addEventListener('click', handleAction));
}

function updateBadge(status) {
    const cfg = STATUS_CFG[status];
    if (!cfg) return;
    document.querySelectorAll('[data-status-badge]').forEach(badge => {
        badge.className = `inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-[11px] font-bold ${cfg.badgeCls}`;
        const dot = badge.querySelector('[data-status-dot]'); if (dot) dot.className = `h-1.5 w-1.5 rounded-full ${cfg.dotCls}`;
        const lbl = badge.querySelector('[data-status-label]'); if (lbl) lbl.textContent = cfg.label;
    });
}

function handleAction(e) {
    const btn  = e.currentTarget;
    const csrf = document.getElementById('action-buttons').dataset.csrf;
    btn.disabled = true; btn.style.opacity = '0.6';
    fetch(btn.dataset.url, { method:'POST', headers:{'X-CSRF-TOKEN':csrf,'Accept':'application/json','Content-Type':'application/json'} })
    .then(r => r.json())
    .then(data => {
        if (data.status) {
            document.getElementById('action-buttons').dataset.status = data.status;
            renderButtons(data.status); updateBadge(data.status);
            showToast(data.message ?? 'Statut mis à jour.', 'success');
        } else { showToast(data.message ?? 'Erreur.', 'error'); btn.disabled = false; btn.style.opacity = ''; }
    })
    .catch(() => { showToast('Erreur de connexion.', 'error'); btn.disabled = false; btn.style.opacity = ''; });
}

(function () { const el = document.getElementById('action-buttons'); if (el) renderButtons(el.dataset.status); })();
</script>

</x-app-layout>
