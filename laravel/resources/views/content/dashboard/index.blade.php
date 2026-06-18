<x-app-layout>
    <div class="flex flex-col gap-6">

        {{-- ═══ ROW 1: Stat cards ═══ --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

            <div class="flex items-center gap-4 rounded-2xl bg-white p-5 shadow-sm">
                <div class="grid h-12 w-12 shrink-0 place-items-center rounded-full bg-yellow-50">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-yellow-500">
                        <path d="M20 12V22H4V12"/><path d="M22 7H2v5h20V7z"/><path d="M12 22V7"/>
                        <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/>
                        <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/>
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <div class="flex items-start justify-between">
                        <p class="text-[12px] text-slate-500 font-medium">Solde Total</p>
                        <button class="text-slate-300"><svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><circle cx="5" cy="12" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="19" cy="12" r="1.5"/></svg></button>
                    </div>
                    <p class="mt-0.5 text-[22px] font-black text-slate-900 leading-tight">82.620 €</p>
                    <p class="mt-1 flex items-center gap-1 text-[11px] text-emerald-600 font-semibold">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="h-3 w-3"><path d="m18 15-6-6-6 6"/></svg>
                        +4% par rapport au mois dernier
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-4 rounded-2xl bg-white p-5 shadow-sm">
                <div class="grid h-12 w-12 shrink-0 place-items-center rounded-full bg-red-50">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-red-400">
                        <circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/>
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <div class="flex items-start justify-between">
                        <p class="text-[12px] text-slate-500 font-medium">Dépenses Totales</p>
                        <button class="text-slate-300"><svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><circle cx="5" cy="12" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="19" cy="12" r="1.5"/></svg></button>
                    </div>
                    <p class="mt-0.5 text-[22px] font-black text-slate-900 leading-tight">54.870 €</p>
                    <p class="mt-1 flex items-center gap-1 text-[11px] text-red-500 font-semibold">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="h-3 w-3"><path d="m6 9 6 6 6-6"/></svg>
                        -2% par rapport au mois dernier
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-4 rounded-2xl bg-white p-5 shadow-sm">
                <div class="grid h-12 w-12 shrink-0 place-items-center rounded-full bg-blue-50">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-blue-500">
                        <path d="M3 3v18h18"/><path d="M7 15l4-4 3 3 5-7"/>
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <div class="flex items-start justify-between">
                        <p class="text-[12px] text-slate-500 font-medium">Transactions ce mois</p>
                        <button class="text-slate-300"><svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><circle cx="5" cy="12" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="19" cy="12" r="1.5"/></svg></button>
                    </div>
                    <p class="mt-0.5 text-[22px] font-black text-slate-900 leading-tight">24</p>
                    <p class="mt-1 flex items-center gap-1 text-[11px] text-emerald-600 font-semibold">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="h-3 w-3"><path d="m18 15-6-6-6 6"/></svg>
                        +3 nouvelles transactions
                    </p>
                </div>
            </div>
        </div>

        {{-- ═══ ROW 2: Chart + Right Panel ═══ --}}
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-[1fr_300px]">

            {{-- Chart --}}
            <div class="rounded-2xl bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <p class="text-[14px] font-bold text-slate-900">Aperçu de Suivi</p>
                        <div class="mt-1.5 flex items-center gap-4 text-[11px]">
                            <span class="flex items-center gap-1.5 text-slate-500"><span class="h-2 w-2 rounded-full bg-blue-500 inline-block"></span>Revenus</span>
                            <span class="flex items-center gap-1.5 text-slate-500"><span class="h-2 w-2 rounded-full bg-red-400 inline-block"></span>Dépenses</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <select class="rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-[12px] font-semibold text-slate-700 focus:outline-none">
                            <option>Mensuel</option><option>Hebdomadaire</option><option>Annuel</option>
                        </select>
                        <button class="grid h-8 w-8 place-items-center rounded-xl border border-slate-200 text-slate-400"><svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><circle cx="5" cy="12" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="19" cy="12" r="1.5"/></svg></button>
                    </div>
                </div>
                <div class="relative w-full" style="height:220px">
                    <svg viewBox="0 0 700 200" preserveAspectRatio="none" class="absolute inset-0 w-full h-full">
                        <defs>
                            <linearGradient id="blueGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#3b82f6" stop-opacity="0.15"/>
                                <stop offset="100%" stop-color="#3b82f6" stop-opacity="0"/>
                            </linearGradient>
                        </defs>
                        <text x="8" y="170" font-size="9" fill="#94a3b8" font-family="sans-serif">0</text>
                        <text x="2" y="136" font-size="9" fill="#94a3b8" font-family="sans-serif">10K</text>
                        <text x="2" y="104" font-size="9" fill="#94a3b8" font-family="sans-serif">20K</text>
                        <text x="2" y="72" font-size="9" fill="#94a3b8" font-family="sans-serif">30K</text>
                        <text x="2" y="40" font-size="9" fill="#94a3b8" font-family="sans-serif">40K</text>
                        <text x="2" y="12" font-size="9" fill="#94a3b8" font-family="sans-serif">50K</text>
                        <line x1="38" y1="8" x2="698" y2="8" stroke="#e2e8f0" stroke-width="0.8"/>
                        <line x1="38" y1="40" x2="698" y2="40" stroke="#e2e8f0" stroke-width="0.8"/>
                        <line x1="38" y1="72" x2="698" y2="72" stroke="#e2e8f0" stroke-width="0.8"/>
                        <line x1="38" y1="104" x2="698" y2="104" stroke="#e2e8f0" stroke-width="0.8"/>
                        <line x1="38" y1="136" x2="698" y2="136" stroke="#e2e8f0" stroke-width="0.8"/>
                        <line x1="38" y1="168" x2="698" y2="168" stroke="#e2e8f0" stroke-width="0.8"/>
                        <text x="60"  y="185" text-anchor="middle" font-size="9" fill="#94a3b8" font-family="sans-serif">Jan</text>
                        <text x="135" y="185" text-anchor="middle" font-size="9" fill="#94a3b8" font-family="sans-serif">Fév</text>
                        <text x="210" y="185" text-anchor="middle" font-size="9" fill="#94a3b8" font-family="sans-serif">Mar</text>
                        <text x="285" y="185" text-anchor="middle" font-size="9" fill="#94a3b8" font-family="sans-serif">Avr</text>
                        <text x="360" y="185" text-anchor="middle" font-size="9" fill="#94a3b8" font-family="sans-serif">Mai</text>
                        <text x="435" y="185" text-anchor="middle" font-size="9" fill="#94a3b8" font-family="sans-serif">Juin</text>
                        <text x="510" y="185" text-anchor="middle" font-size="9" fill="#94a3b8" font-family="sans-serif">Juil</text>
                        <text x="585" y="185" text-anchor="middle" font-size="9" fill="#94a3b8" font-family="sans-serif">Août</text>
                        <text x="660" y="185" text-anchor="middle" font-size="9" fill="#94a3b8" font-family="sans-serif">Sep</text>
                        <polyline points="60,72 135,80 210,64 285,76 360,68 435,88 510,96 585,108 660,116" fill="none" stroke="#f87171" stroke-width="2" stroke-dasharray="5,4" opacity="0.8"/>
                        <polygon points="60,150 135,124 210,116 285,108 360,32 435,72 510,60 585,44 660,36 660,168 60,168" fill="url(#blueGrad)"/>
                        <polyline points="60,150 135,124 210,116 285,108 360,32 435,72 510,60 585,44 660,36" fill="none" stroke="#3b82f6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <rect x="320" y="12" width="80" height="22" rx="6" fill="#1e293b"/>
                        <text x="360" y="27" text-anchor="middle" font-size="9" fill="white" font-weight="bold" font-family="sans-serif">80.000,00 €</text>
                        <circle cx="360" cy="32" r="5" fill="#3b82f6" stroke="white" stroke-width="2"/>
                        <rect x="332" y="170" width="56" height="14" rx="7" fill="#1e293b"/>
                        <text x="360" y="181" text-anchor="middle" font-size="9" fill="white" font-family="sans-serif">Mai</text>
                    </svg>
                </div>
            </div>

            {{-- Right panel --}}
            <div class="flex flex-col gap-3">
                {{-- Mes Cartes header --}}
                <div class="flex items-center justify-between rounded-2xl bg-white px-5 py-3.5 shadow-sm">
                    <p class="text-[14px] font-bold text-slate-900">Mes Cartes</p>
                    <button class="flex items-center gap-1 rounded-xl bg-slate-900 px-3 py-1.5 text-[11px] font-bold text-white hover:bg-slate-700">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" class="h-3 w-3"><path d="M12 5v14M5 12h14"/></svg>
                        Ajouter une carte
                    </button>
                </div>

                {{-- Card 1 --}}
                <div class="flex items-center gap-3 rounded-2xl bg-white p-4 shadow-sm cursor-pointer hover:bg-slate-50">
                    <div class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-slate-100">
                        <svg viewBox="0 0 38 24" class="h-6 w-6"><circle cx="15" cy="12" r="10" fill="#eb001b"/><circle cx="23" cy="12" r="10" fill="#f79e1b"/><path d="M19 4a10 10 0 0 1 0 16A10 10 0 0 1 19 4z" fill="#ff5f00"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[12px] font-bold text-slate-900">28.572,00 €</p>
                        <p class="text-[10px] text-slate-400">Euro · ···· 2879</p>
                    </div>
                    <div class="flex flex-col items-end gap-1">
                        <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-[9px] font-bold text-emerald-700">Active</span>
                        <span class="text-[10px] text-slate-400">Mastercard</span>
                    </div>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 text-slate-300 shrink-0"><path d="m9 18 6-6-6-6"/></svg>
                </div>

                {{-- Card 2 --}}
                <div class="flex items-center gap-3 rounded-2xl bg-white p-4 shadow-sm cursor-pointer hover:bg-slate-50">
                    <div class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-blue-50">
                        <span class="text-[13px] font-black italic text-blue-700">VISA</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[12px] font-bold text-slate-900">12.148,00 $</p>
                        <p class="text-[10px] text-slate-400">US Dollar · ···· 2879</p>
                    </div>
                    <div class="flex flex-col items-end gap-1">
                        <span class="rounded-full bg-red-100 px-2 py-0.5 text-[9px] font-bold text-red-600">Désactivée</span>
                        <span class="text-[10px] font-bold text-blue-600">Visa</span>
                    </div>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 text-slate-300 shrink-0"><path d="m9 18 6-6-6-6"/></svg>
                </div>

                {{-- Card 3 --}}
                <div class="flex items-center gap-3 rounded-2xl bg-white p-4 shadow-sm cursor-pointer hover:bg-slate-50">
                    <div class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-blue-50">
                        <span class="text-[11px] font-black text-blue-700">AMEX</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[12px] font-bold text-slate-900">58.629,00 $</p>
                        <p class="text-[10px] text-slate-400">Dollar Canadien · ···· 2879</p>
                    </div>
                    <div class="flex flex-col items-end gap-1">
                        <span class="rounded-full bg-red-100 px-2 py-0.5 text-[9px] font-bold text-red-600">Désactivée</span>
                        <span class="text-[10px] font-bold text-blue-600">Amex</span>
                    </div>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 text-slate-300 shrink-0"><path d="m9 18 6-6-6-6"/></svg>
                </div>

                {{-- Résumé Rapide --}}
                <div class="rounded-2xl bg-white p-4 shadow-sm">
                    <p class="mb-3 text-[13px] font-bold text-slate-900">Résumé Rapide</p>
                    <div class="grid grid-cols-4 gap-2 text-center">
                        <div class="flex flex-col items-center gap-1.5 rounded-xl bg-yellow-50 p-2.5">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" class="h-5 w-5 text-yellow-500"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                            <p class="text-[16px] font-black text-slate-900 leading-none">12</p>
                            <p class="text-[9px] text-slate-500 leading-tight">Devis en cours</p>
                        </div>
                        <div class="flex flex-col items-center gap-1.5 rounded-xl bg-emerald-50 p-2.5">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" class="h-5 w-5 text-emerald-500"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h8.7a2 2 0 0 0 2-1.6L22 6H6"/></svg>
                            <p class="text-[16px] font-black text-slate-900 leading-none">7</p>
                            <p class="text-[9px] text-slate-500 leading-tight">Commandes</p>
                        </div>
                        <div class="flex flex-col items-center gap-1.5 rounded-xl bg-blue-50 p-2.5">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" class="h-5 w-5 text-blue-500"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 4v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                            <p class="text-[16px] font-black text-slate-900 leading-none">5</p>
                            <p class="text-[9px] text-slate-500 leading-tight">Livraisons</p>
                        </div>
                        <div class="flex flex-col items-center gap-1.5 rounded-xl bg-purple-50 p-2.5">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" class="h-5 w-5 text-purple-500"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            <p class="text-[16px] font-black text-slate-900 leading-none">248</p>
                            <p class="text-[9px] text-slate-500 leading-tight">Clients actifs</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══ ROW 3: Transactions Récentes ═══ --}}
        <div class="rounded-2xl bg-white shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <p class="text-[14px] font-bold text-slate-900">Transactions Récentes</p>
                <div class="flex items-center gap-2">
                    <div class="relative">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="pointer-events-none absolute left-2.5 top-1/2 -translate-y-1/2 h-3.5 w-3.5 text-slate-400"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                        <input type="search" placeholder="Rechercher..." class="h-8 rounded-xl border border-slate-200 bg-slate-50 pl-7 pr-3 text-[11px] text-slate-700 focus:outline-none focus:ring-2 focus:ring-pcc-yellow/40 w-36">
                    </div>
                    <button class="flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 h-8 text-[11px] font-semibold text-slate-600 hover:bg-slate-50">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3.5 w-3.5"><path d="M22 3H2l8 9.46V19l4 2v-8.54L22 3z"/></svg>
                        Filtrer
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/50">
                            <th class="w-10 px-4 py-3"><input type="checkbox" class="h-3.5 w-3.5 rounded accent-yellow-400"></th>
                            <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-slate-500">ID Devis</th>
                            <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-slate-500">Nom Client</th>
                            <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-slate-500">Email</th>
                            <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-slate-500">Date</th>
                            <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-slate-500">Montant</th>
                            <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-slate-500">Statut</th>
                            <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-slate-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @php
                        $transactions = [
                            ['id'=>'DE254839','name'=>'Esther Howard','initials'=>'EH','color'=>'bg-orange-400','email'=>'howard@gmail.com','date'=>'28 Déc 2025','amount'=>'\$ 582.479,00','status'=>'Succès','statusClass'=>'bg-emerald-100 text-emerald-700'],
                            ['id'=>'DE254840','name'=>'Kristin Watson','initials'=>'KW','color'=>'bg-pink-400','email'=>'watson@gmail.com','date'=>'14 Fév 2025','amount'=>'\$ 235.241,00','status'=>'En attente','statusClass'=>'bg-orange-100 text-orange-600'],
                            ['id'=>'DE254841','name'=>'Albert Flores','initials'=>'AF','color'=>'bg-blue-400','email'=>'flores@gmail.com','date'=>'02 Mar 2025','amount'=>'\$ 98.600,00','status'=>'Succès','statusClass'=>'bg-emerald-100 text-emerald-700'],
                            ['id'=>'DE254842','name'=>'Savannah Nguyen','initials'=>'SN','color'=>'bg-purple-400','email'=>'nguyen@gmail.com','date'=>'18 Mar 2025','amount'=>'\$ 312.880,00','status'=>'Annulé','statusClass'=>'bg-red-100 text-red-600'],
                            ['id'=>'DE254843','name'=>'Jerome Bell','initials'=>'JB','color'=>'bg-teal-400','email'=>'bell@gmail.com','date'=>'05 Avr 2025','amount'=>'\$ 47.200,00','status'=>'En attente','statusClass'=>'bg-orange-100 text-orange-600'],
                        ];
                        @endphp
                        @foreach($transactions as $tx)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-4 py-3"><input type="checkbox" class="h-3.5 w-3.5 rounded accent-yellow-400"></td>
                            <td class="px-4 py-3 text-[12px] font-semibold text-slate-700">{{ $tx['id'] }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2.5">
                                    <span class="grid h-7 w-7 shrink-0 place-items-center rounded-full {{ $tx['color'] }} text-[10px] font-bold text-white">{{ $tx['initials'] }}</span>
                                    <span class="text-[12px] font-semibold text-slate-800">{{ $tx['name'] }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-[12px] text-slate-500">{{ $tx['email'] }}</td>
                            <td class="px-4 py-3 text-[12px] text-slate-500">{{ $tx['date'] }}</td>
                            <td class="px-4 py-3 text-[12px] font-bold text-slate-800">{{ $tx['amount'] }}</td>
                            <td class="px-4 py-3"><span class="rounded-full px-2.5 py-1 text-[10px] font-bold {{ $tx['statusClass'] }}">{{ $tx['status'] }}</span></td>
                            <td class="px-4 py-3">
                                <button class="grid h-7 w-7 place-items-center rounded-full hover:bg-slate-100 text-slate-400">
                                    <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/></svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
