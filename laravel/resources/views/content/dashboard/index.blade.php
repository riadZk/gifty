<x-app-layout>

    @push('styles')
        <style>
            .dash-chart-wrap {
                position: relative;
                height: 200px;
            }
        </style>
    @endpush

    <div class="flex flex-col gap-5">

        {{-- ══════════════════════════════════════════
             ROW 1 — 4 Stat cards with sparklines
        ══════════════════════════════════════════ --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Clients inscrits --}}
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <div class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-orange-50">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-orange-400">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </div>
                    <span
                        class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[10.5px] font-bold text-emerald-600">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                            class="h-3 w-3">
                            <path d="m18 15-6-6-6 6" />
                        </svg>
                        +12%
                    </span>
                </div>
                <p class="mt-4 text-[11px] font-semibold uppercase tracking-wide text-slate-400">Clients inscrits</p>
                <div class="mt-1 flex items-end justify-between gap-3">
                    <p class="text-[24px] font-black leading-none text-slate-900">
                        {{ number_format($totalClients, 0, ',', ' ') }}</p>
                    <div class="h-9 w-24"><canvas id="spkClients"></canvas></div>
                </div>
            </div>

            {{-- Demandes bonus --}}
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <div class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-blue-50">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-blue-500">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="9" y1="15" x2="15" y2="15" />
                        </svg>
                    </div>
                    <span
                        class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-0.5 text-[10.5px] font-bold text-amber-600">
                        {{ $pendingDemandes }} en attente
                    </span>
                </div>
                <p class="mt-4 text-[11px] font-semibold uppercase tracking-wide text-slate-400">Demandes bonus</p>
                <div class="mt-1 flex items-end justify-between gap-3">
                    <p class="text-[24px] font-black leading-none text-slate-900">
                        {{ number_format($totalDemandes, 0, ',', ' ') }}</p>
                    <div class="h-9 w-24"><canvas id="spkDemandes"></canvas></div>
                </div>
            </div>

            {{-- Points clients --}}
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <div class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-amber-50">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-amber-400">
                            <polygon
                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                    </div>
                    <span
                        class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[10.5px] font-bold text-emerald-600">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                            class="h-3 w-3">
                            <path d="m18 15-6-6-6 6" />
                        </svg>
                        +11%
                    </span>
                </div>
                <p class="mt-4 text-[11px] font-semibold uppercase tracking-wide text-slate-400">Points clients</p>
                <div class="mt-1 flex items-end justify-between gap-3">
                    <p class="text-[24px] font-black leading-none text-slate-900">
                        {{ number_format($totalPoints, 0, ',', ' ') }}</p>
                    <div class="h-9 w-24"><canvas id="spkPoints"></canvas></div>
                </div>
            </div>

            {{-- Total Sales (HT) --}}
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <div class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-emerald-50">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-emerald-500">
                            <circle cx="9" cy="21" r="1" />
                            <circle cx="20" cy="21" r="1" />
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                        </svg>
                    </div>
                    <span
                        class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[10.5px] font-bold text-emerald-600">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                            class="h-3 w-3">
                            <path d="m18 15-6-6-6 6" />
                        </svg>
                        +8%
                    </span>
                </div>
                <p class="mt-4 text-[11px] font-semibold uppercase tracking-wide text-slate-400">Total Sales (HT)</p>
                <div class="mt-1 flex items-end justify-between gap-3">
                    <p class="text-[22px] font-black leading-none text-slate-900">
                        {{ $totalSales >= 1000000
                            ? number_format($totalSales / 1000000, 2, ',', ' ') . 'M'
                            : number_format($totalSales, 0, ',', ' ') }}
                        <span class="text-[12px] font-bold text-slate-400">MAD</span>
                    </p>
                    <div class="h-9 w-24"><canvas id="spkSales"></canvas></div>
                </div>
            </div>

        </div>

        {{-- ══════════════════════════════════════════
             ROW 1b — Demandes status strip
        ══════════════════════════════════════════ --}}
        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
            <div class="flex items-center gap-3 rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
                <span class="grid h-10 w-10 place-items-center rounded-xl bg-amber-50 text-amber-500">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="h-5 w-5">
                        <circle cx="12" cy="12" r="9" />
                        <path d="M12 7v5l3 2" />
                    </svg>
                </span>
                <div>
                    <p class="text-[20px] font-black leading-none text-slate-900">{{ $pendingDemandes }}</p>
                    <p class="mt-1 text-[11px] font-semibold text-slate-400">En attente</p>
                </div>
            </div>
            <div class="flex items-center gap-3 rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
                <span class="grid h-10 w-10 place-items-center rounded-xl bg-blue-50 text-blue-500">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
                        class="h-5 w-5">
                        <path d="M9 11l3 3L22 4" />
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                    </svg>
                </span>
                <div>
                    <p class="text-[20px] font-black leading-none text-slate-900">{{ $approvedDemandes }}</p>
                    <p class="mt-1 text-[11px] font-semibold text-slate-400">Approuvées</p>
                </div>
            </div>
            <div class="flex items-center gap-3 rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
                <span class="grid h-10 w-10 place-items-center rounded-xl bg-emerald-50 text-emerald-500">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
                        class="h-5 w-5">
                        <rect x="1" y="3" width="15" height="13" />
                        <path d="M16 8h4l3 3v5h-7V8z" />
                        <circle cx="5.5" cy="18.5" r="2.5" />
                        <circle cx="18.5" cy="18.5" r="2.5" />
                    </svg>
                </span>
                <div>
                    <p class="text-[20px] font-black leading-none text-slate-900">{{ $deliveredDemandes }}</p>
                    <p class="mt-1 text-[11px] font-semibold text-slate-400">Livrées</p>
                </div>
            </div>
            <div class="flex items-center gap-3 rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
                <span class="grid h-10 w-10 place-items-center rounded-xl bg-red-50 text-red-500">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
                        class="h-5 w-5">
                        <circle cx="12" cy="12" r="9" />
                        <path d="M15 9l-6 6M9 9l6 6" />
                    </svg>
                </span>
                <div>
                    <p class="text-[20px] font-black leading-none text-slate-900">{{ $rejectedDemandes }}</p>
                    <p class="mt-1 text-[11px] font-semibold text-slate-400">Rejetées</p>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
             ROW 2 — Charts (left) + Sidebar (right)
        ══════════════════════════════════════════ --}}
        <div class="grid grid-cols-1 gap-5 xl:grid-cols-3">

            {{-- ── Charts column (2/3) ── --}}
            <div class="flex flex-col gap-5 xl:col-span-2">

                {{-- Sales line chart --}}
                <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-[14px] font-bold text-slate-800">Évolution des ventes (HT)</h3>
                        <select
                            class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-[12px] font-semibold text-slate-600 focus:border-yellow-400 focus:outline-none">
                            <option>Mensuel</option>
                            <option>Hebdomadaire</option>
                            <option>Annuel</option>
                        </select>
                    </div>
                    <div class="dash-chart-wrap">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                {{-- Top clients par points --}}
                <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-[14px] font-bold text-slate-800">Top clients par points</h3>
                        <a href="{{ route('clients') }}"
                            class="text-[12px] font-semibold text-blue-500 transition-colors hover:text-blue-700">Voir
                            tout</a>
                    </div>
                    @php $maxPts = max(1, optional($topClients->first())->points_balance ?? 1); @endphp
                    <div class="flex flex-col gap-3.5">
                        @forelse($topClients as $i => $client)
                            <div class="flex items-center gap-3">
                                <span
                                    class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-amber-50 text-[11px] font-black text-amber-600">
                                    {{ strtoupper(substr($client->company_name, 0, 2)) }}
                                </span>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="truncate text-[12.5px] font-semibold text-slate-800">
                                            {{ $client->company_name }}</p>
                                        <p class="shrink-0 text-[12px] font-bold text-slate-700">
                                            {{ number_format($client->points_balance, 0, ',', ' ') }} pts</p>
                                    </div>
                                    <div class="mt-1.5 h-2 w-full overflow-hidden rounded-full bg-slate-100">
                                        <div class="h-full rounded-full bg-yellow-400"
                                            style="width: {{ max(4, round(($client->points_balance / $maxPts) * 100)) }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="py-4 text-center text-[12px] text-slate-400">Aucun client</p>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- ── Right sidebar (1/3) ── --}}
            <div class="flex flex-col gap-5">

                {{-- Demandes par statut (donut) --}}
                <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                    <div class="mb-2 flex items-center justify-between">
                        <h3 class="text-[14px] font-bold text-slate-800">Demandes par statut</h3>
                        <a href="{{ route('demandes.index') }}"
                            class="text-[12px] font-semibold text-blue-500 transition-colors hover:text-blue-700">Voir
                            tout</a>
                    </div>
                    <div class="relative mx-auto h-44 w-44">
                        <canvas id="demandesChart"></canvas>
                        <div class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center">
                            <span
                                class="text-[22px] font-black leading-none text-slate-900">{{ $totalDemandes }}</span>
                            <span
                                class="text-[10.5px] font-semibold uppercase tracking-wide text-slate-400">Demandes</span>
                        </div>
                    </div>
                    <div class="mt-4 grid grid-cols-2 gap-2 text-[11.5px]">
                        <span class="flex items-center gap-1.5 font-semibold text-slate-600"><span
                                class="h-2.5 w-2.5 rounded-full bg-amber-400"></span>En attente <span
                                class="ml-auto text-slate-400">{{ $pendingDemandes }}</span></span>
                        <span class="flex items-center gap-1.5 font-semibold text-slate-600"><span
                                class="h-2.5 w-2.5 rounded-full bg-blue-500"></span>Approuvées <span
                                class="ml-auto text-slate-400">{{ $approvedDemandes }}</span></span>
                        <span class="flex items-center gap-1.5 font-semibold text-slate-600"><span
                                class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>Livrées <span
                                class="ml-auto text-slate-400">{{ $deliveredDemandes }}</span></span>
                        <span class="flex items-center gap-1.5 font-semibold text-slate-600"><span
                                class="h-2.5 w-2.5 rounded-full bg-red-400"></span>Rejetées <span
                                class="ml-auto text-slate-400">{{ $rejectedDemandes }}</span></span>
                    </div>
                </div>

                {{-- Notifications récentes --}}
                <div class="flex-1 rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-[14px] font-bold text-slate-800">Notifications récentes</h3>
                        <a href="{{ route('notifications.all') }}"
                            class="text-[12px] font-semibold text-blue-500 hover:text-blue-700 transition-colors">Voir
                            tout</a>
                    </div>
                    <div class="flex flex-col gap-3.5">
                        @forelse($recentNotifications as $notif)
                            @php $data = $notif->data; @endphp
                            <div class="flex items-start gap-3">
                                <div
                                    class="mt-0.5 grid h-8 w-8 shrink-0 place-items-center rounded-full bg-amber-50 text-amber-500">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        class="h-4 w-4">
                                        <path d="M18 8a6 6 0 1 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9" />
                                        <path d="M13.7 21a2 2 0 0 1-3.4 0" />
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-[12.5px] font-semibold leading-snug text-slate-800">
                                        {{ $data['message'] ?? 'Notification' }}</p>
                                    <p class="mt-0.5 text-[11px] text-slate-400">
                                        {{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</p>
                                </div>
                                @unless ($notif->read_at)
                                    <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-amber-400"></span>
                                @endunless
                            </div>
                        @empty
                            <div class="flex flex-col items-center gap-2 py-6">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.4"
                                    class="h-8 w-8">
                                    <path d="M18 8a6 6 0 1 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9" />
                                    <path d="M13.7 21a2 2 0 0 1-3.4 0" />
                                </svg>
                                <p class="text-[12px] text-slate-400">Aucune notification récente</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Bonus à livrer --}}
                <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                    <div class="mb-3 flex items-center justify-between">
                        <h3 class="text-[14px] font-bold text-slate-800">Bonus à livrer</h3>
                        <a href="{{ route('loyalty.index') }}"
                            class="text-[12px] font-semibold text-blue-500 hover:text-blue-700 transition-colors">Voir
                            tout</a>
                    </div>
                    <div class="flex flex-col divide-y divide-slate-100">
                        @forelse($bonusLevels as $bonus)
                            <div class="flex items-center gap-3 py-2.5">
                                <div
                                    class="grid h-9 w-9 shrink-0 place-items-center overflow-hidden rounded-xl bg-slate-100">
                                    @if ($bonus->image)
                                        <img src="{{ $bonus->image }}" alt="{{ $bonus->reward_name }}"
                                            class="h-9 w-9 object-cover">
                                    @else
                                        <svg viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8"
                                            class="h-4 w-4">
                                            <polyline points="20 12 20 22 4 22 4 12" />
                                            <rect x="2" y="7" width="20" height="5" />
                                            <line x1="12" y1="22" x2="12" y2="7" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-[12.5px] font-semibold text-slate-800">
                                        {{ $bonus->reward_name }}</p>
                                    <p class="text-[11px] text-slate-400">
                                        {{ number_format($bonus->required_points, 0, ',', ' ') }} pts</p>
                                </div>
                                <span
                                    class="shrink-0 rounded-full px-2 py-0.5 text-[10.5px] font-bold bg-amber-50 text-amber-600">
                                    En attente
                                </span>
                            </div>
                        @empty
                            <p class="py-4 text-center text-[12px] text-slate-400">Aucun bonus configuré</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

        {{-- ══════════════════════════════════════════
             ROW 3 — Recent demandes table
        ══════════════════════════════════════════ --}}
        <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                <h3 class="text-[14px] font-bold text-slate-800">Dernières demandes de bonus</h3>
                <a href="{{ route('demandes.index') }}"
                    class="text-[12px] font-semibold text-blue-500 transition-colors hover:text-blue-700">Voir tout</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/60">
                            <th
                                class="px-6 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Référence</th>
                            <th
                                class="px-6 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Client</th>
                            <th
                                class="px-6 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Bonus</th>
                            <th
                                class="px-6 py-3 text-right text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Points</th>
                            <th
                                class="px-6 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Date</th>
                            <th
                                class="px-6 py-3 text-center text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentDemandes as $demande)
                            <tr class="transition-colors hover:bg-slate-50/50">
                                <td class="px-6 py-3.5 text-[12.5px] font-bold text-slate-700">
                                    {{ $demande->demande_key }}</td>
                                <td class="px-6 py-3.5 text-[12.5px] font-semibold text-slate-800">
                                    {{ $demande->client->company_name ?? '—' }}
                                </td>
                                <td class="px-6 py-3.5 text-[12.5px] text-slate-500">
                                    {{ $demande->bonusLevel->reward_name ?? '—' }}
                                </td>
                                <td class="px-6 py-3.5 text-right text-[13px] font-semibold text-slate-800">
                                    {{ number_format($demande->points_required, 0, ',', ' ') }} pts
                                </td>
                                <td class="px-6 py-3.5 text-[12.5px] text-slate-500">
                                    {{ $demande->requested_at ? $demande->requested_at->format('d/m/Y') : '—' }}
                                </td>
                                <td class="px-6 py-3.5 text-center">
                                    <span @class([
                                        'inline-flex rounded-full px-2.5 py-0.5 text-[11px] font-bold',
                                        'bg-amber-50 text-amber-600' => $demande->status === 'pending',
                                        'bg-blue-50 text-blue-600' => $demande->status === 'approved',
                                        'bg-emerald-50 text-emerald-600' => $demande->status === 'delivered',
                                        'bg-red-50 text-red-500' => $demande->status === 'rejected',
                                    ])>
                                        {{ ucfirst($demande->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-[12px] text-slate-400">
                                    Aucune demande enregistrée
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
             ROW 4 — Recent clients table
        ══════════════════════════════════════════ --}}
        <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                <h3 class="text-[14px] font-bold text-slate-800">Derniers clients inscrits</h3>
                <a href="{{ route('clients') }}"
                    class="text-[12px] font-semibold text-blue-500 hover:text-blue-700 transition-colors">Voir tout</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/60">
                            <th
                                class="px-6 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Client</th>
                            <th
                                class="px-6 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Email</th>
                            <th
                                class="px-6 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Date d'inscription</th>
                            <th
                                class="px-6 py-3 text-right text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Total Sales (HT)</th>
                            <th
                                class="px-6 py-3 text-right text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Points</th>
                            <th
                                class="px-6 py-3 text-center text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentClients as $client)
                            <tr class="transition-colors hover:bg-slate-50/50">
                                <td class="px-6 py-3.5">
                                    <div class="flex items-center gap-2.5">
                                        <span
                                            class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-amber-50 text-[11px] font-black text-amber-600">
                                            {{ strtoupper(substr($client->company_name, 0, 2)) }}
                                        </span>
                                        <span
                                            class="text-[13px] font-semibold text-slate-800">{{ $client->company_name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-3.5 text-[12.5px] text-slate-500">{{ $client->email }}</td>
                                <td class="px-6 py-3.5 text-[12.5px] text-slate-500">
                                    {{ $client->accepted_at ? $client->accepted_at->format('d/m/Y') : '—' }}
                                </td>
                                <td class="px-6 py-3.5 text-right text-[13px] font-semibold text-slate-800">
                                    {{ number_format($client->total_sales, 0, ',', ' ') }} MAD
                                </td>
                                <td class="px-6 py-3.5 text-right text-[13px] font-semibold text-slate-800">
                                    {{ number_format($client->points_balance, 0, ',', ' ') }} pts
                                </td>
                                <td class="px-6 py-3.5 text-center">
                                    <span @class([
                                        'inline-flex rounded-full px-2.5 py-0.5 text-[11px] font-bold',
                                        'bg-emerald-50 text-emerald-600' => $client->status === 'active',
                                        'bg-red-50 text-red-500' => $client->status === 'blocked',
                                        'bg-slate-100 text-slate-500' => !in_array($client->status, [
                                            'active',
                                            'blocked',
                                        ]),
                                    ])>
                                        {{ ucfirst($client->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-[12px] text-slate-400">
                                    Aucun client enregistré
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($recentClients->count() > 0)
                <div class="border-t border-slate-100 px-6 py-3 text-[12px] text-slate-400">
                    Affichage de 1 à {{ $recentClients->count() }} sur {{ $totalClients }} résultats
                </div>
            @endif
        </div>

    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        <script>
            (function() {
                const labels = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'];
                const yellow = '#FFC60B';
                const yellowBg = 'rgba(255,198,11,0.10)';

                const gridColor = 'rgba(0,0,0,0.05)';
                const tickColor = '#94a3b8';
                const tickFont = {
                    family: 'Manrope, sans-serif',
                    size: 11
                };

                const baseScales = {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: tickColor,
                            font: tickFont
                        }
                    },
                    y: {
                        grid: {
                            color: gridColor,
                            drawBorder: false
                        },
                        ticks: {
                            color: tickColor,
                            font: tickFont
                        }
                    },
                };

                // ── Sales line chart ──────────────────────────────────────────
                new Chart(document.getElementById('salesChart'), {
                    type: 'line',
                    data: {
                        labels,
                        datasets: [{
                            data: [5000000, 8000000, 10000000, 13000000, 18000000, 25000000],
                            borderColor: yellow,
                            backgroundColor: yellowBg,
                            fill: true,
                            tension: 0.45,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBackgroundColor: yellow,
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            borderWidth: 2.5,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: ctx => ' ' + new Intl.NumberFormat('fr-MA').format(ctx.parsed.y) +
                                        ' MAD',
                                },
                            },
                        },
                        scales: {
                            ...baseScales,
                            y: {
                                ...baseScales.y,
                                ticks: {
                                    ...baseScales.y.ticks,
                                    callback: v => v >= 1e6 ? (v / 1e6) + 'M' : v,
                                },
                            },
                        },
                    },
                });

                // ── Sparklines (stat cards) ───────────────────────────────────
                const sparkBase = (color, fill) => ({
                    type: 'line',
                    data: {
                        labels: ['', '', '', '', '', '', ''],
                        datasets: [{
                            data: [],
                            borderColor: color,
                            backgroundColor: fill,
                            fill: true,
                            tension: 0.45,
                            borderWidth: 2,
                            pointRadius: 0,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: false
                            }
                        },
                        scales: {
                            x: {
                                display: false
                            },
                            y: {
                                display: false
                            }
                        },
                        elements: {
                            line: {
                                borderCapStyle: 'round'
                            }
                        },
                    },
                });

                const sparks = {
                    spkClients: {
                        color: '#fb923c',
                        fill: 'rgba(251,146,60,0.12)',
                        data: [8, 11, 9, 14, 13, 18, 21]
                    },
                    spkDemandes: {
                        color: '#3b82f6',
                        fill: 'rgba(59,130,246,0.12)',
                        data: [3, 5, 4, 7, 6, 9, 11]
                    },
                    spkPoints: {
                        color: '#FFC60B',
                        fill: 'rgba(255,198,11,0.14)',
                        data: [6, 9, 13, 11, 18, 22, 26]
                    },
                    spkSales: {
                        color: '#10b981',
                        fill: 'rgba(16,185,129,0.12)',
                        data: [5, 8, 7, 12, 14, 19, 23]
                    },
                };

                Object.entries(sparks).forEach(([id, cfg]) => {
                    const el = document.getElementById(id);
                    if (!el) return;
                    const conf = sparkBase(cfg.color, cfg.fill);
                    conf.data.datasets[0].data = cfg.data;
                    new Chart(el, conf);
                });

                // ── Demandes par statut (donut) ───────────────────────────────
                const demandesEl = document.getElementById('demandesChart');
                if (demandesEl) {
                    const dData = [
                        {{ (int) $pendingDemandes }},
                        {{ (int) $approvedDemandes }},
                        {{ (int) $deliveredDemandes }},
                        {{ (int) $rejectedDemandes }},
                    ];
                    const dTotal = dData.reduce((a, b) => a + b, 0);
                    new Chart(demandesEl, {
                        type: 'doughnut',
                        data: {
                            labels: ['En attente', 'Approuvées', 'Livrées', 'Rejetées'],
                            datasets: [{
                                data: dTotal === 0 ? [1, 1, 1, 1] : dData,
                                backgroundColor: ['#fbbf24', '#3b82f6', '#10b981', '#f87171'],
                                borderWidth: 0,
                                hoverOffset: 4,
                            }],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '72%',
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    enabled: dTotal !== 0
                                },
                            },
                        },
                    });
                }
            })();
        </script>
    @endpush

</x-app-layout>
