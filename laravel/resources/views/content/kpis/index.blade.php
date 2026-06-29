<x-app-layout>

    @push('styles')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
            .kpi {
                --card: #FFFFFF;
                --border: #EEF1F5;
                --ink: #0B1220;
                --muted: #6B7280;
                --faint: #9AA3AF;
                --bg-soft: #F7F8FA;
                font-family: 'Inter', system-ui, sans-serif;
                color: var(--ink);
                letter-spacing: -0.011em;
            }

            .kpi *,
            .kpi *::before,
            .kpi *::after {
                box-sizing: border-box;
            }

            .kpi-shell {
                display: flex;
                flex-direction: column;
                gap: 18px;
            }

            /* ── Card ── */
            .kpi-card {
                background: var(--card);
                border: 1px solid var(--border);
                border-radius: 18px;
                box-shadow: 0 1px 2px rgba(11, 18, 32, .03);
                transition: box-shadow .2s ease, transform .2s ease, border-color .2s;
            }

            .kpi-card-h:hover {
                transform: translateY(-2px);
                box-shadow: 0 12px 30px -16px rgba(11, 18, 32, .18);
                border-color: #E2E6EC;
            }

            /* ── Grids ── */
            .kpi-grid {
                display: grid;
                gap: 18px;
            }

            .kpi-g4 {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }

            .kpi-g2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .kpi-g-21 {
                grid-template-columns: 2fr 1fr;
            }

            .kpi-g-12 {
                grid-template-columns: 1fr 1.4fr;
            }

            @media (max-width:1180px) {
                .kpi-g4 {
                    grid-template-columns: repeat(2, 1fr);
                }

                .kpi-g-21,
                .kpi-g-12 {
                    grid-template-columns: 1fr;
                }
            }

            @media (max-width:720px) {

                .kpi-g4,
                .kpi-g2 {
                    grid-template-columns: 1fr;
                }
            }

            /* ── Stat card ── */
            .kpi-stat {
                padding: 20px;
            }

            .kpi-stat-hd {
                display: flex;
                align-items: center;
                gap: 9px;
            }

            .kpi-stat-ic {
                width: 30px;
                height: 30px;
                border-radius: 9px;
                display: grid;
                place-items: center;
                flex: none;
            }

            .kpi-stat-ic svg {
                width: 16px;
                height: 16px;
            }

            .kpi-stat-lab {
                font-size: 12.5px;
                font-weight: 600;
                color: var(--muted);
            }

            .kpi-stat-row {
                display: flex;
                align-items: baseline;
                gap: 9px;
                margin-top: 14px;
            }

            .kpi-stat-val {
                font-size: 27px;
                font-weight: 800;
                letter-spacing: -0.03em;
                line-height: 1;
            }

            .kpi-trend {
                display: inline-flex;
                align-items: center;
                gap: 2px;
                font-size: 11.5px;
                font-weight: 700;
                padding: 2px 7px;
                border-radius: 7px;
            }

            .kpi-trend svg {
                width: 11px;
                height: 11px;
            }

            .kpi-trend-up {
                background: #E9FbF1;
                color: #0E9F6E;
            }

            .kpi-trend-dn {
                background: #FEEDED;
                color: #E02424;
            }

            .kpi-stat-sub {
                font-size: 11.5px;
                color: var(--faint);
                margin-top: 9px;
                font-weight: 500;
            }

            /* ── Panel header ── */
            .kpi-ph {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 12px;
                padding: 18px 20px 0;
            }

            .kpi-ph-t {
                font-size: 14.5px;
                font-weight: 700;
                letter-spacing: -0.02em;
            }

            .kpi-ph-s {
                font-size: 11.5px;
                color: var(--faint);
                margin-top: 2px;
                font-weight: 500;
            }

            .kpi-dots {
                color: var(--faint);
                cursor: pointer;
            }

            .kpi-link {
                font-size: 12px;
                font-weight: 600;
                color: #475569;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 4px;
                transition: color .15s;
            }

            .kpi-link:hover {
                color: var(--ink);
            }

            /* ── Chart wraps ── */
            .kpi-cv {
                position: relative;
                padding: 14px 16px 18px;
            }

            .kpi-cv-h {
                height: 250px;
            }

            .kpi-cv-sm {
                height: 200px;
            }

            .kpi-cv-g {
                height: 170px;
            }

            /* ── Mini stat strip ── */
            .kpi-mini {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 12px;
                padding: 0 20px 20px;
            }

            @media (max-width:560px) {
                .kpi-mini {
                    grid-template-columns: 1fr;
                }
            }

            .kpi-mini-c {
                border: 1px solid var(--border);
                border-radius: 13px;
                padding: 13px 14px;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .kpi-mini-ic {
                width: 32px;
                height: 32px;
                border-radius: 9px;
                display: grid;
                place-items: center;
                flex: none;
            }

            .kpi-mini-ic svg {
                width: 16px;
                height: 16px;
            }

            .kpi-mini-v {
                font-size: 18px;
                font-weight: 800;
                letter-spacing: -0.02em;
                line-height: 1;
            }

            .kpi-mini-l {
                font-size: 11px;
                color: var(--faint);
                font-weight: 600;
                margin-top: 3px;
            }

            /* ── Gauge ── */
            .kpi-gauge-wrap {
                position: relative;
                padding: 8px 20px 14px;
            }

            .kpi-gauge-c {
                position: relative;
                height: 150px;
            }

            .kpi-gauge-mid {
                position: absolute;
                left: 0;
                right: 0;
                bottom: 6px;
                text-align: center;
            }

            .kpi-gauge-val {
                font-size: 32px;
                font-weight: 800;
                letter-spacing: -0.03em;
                line-height: 1;
            }

            .kpi-gauge-lab {
                font-size: 11.5px;
                color: var(--faint);
                font-weight: 600;
                margin-top: 4px;
            }

            /* ── Legend list (donut) ── */
            .kpi-leg {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 9px 16px;
                padding: 4px 20px 20px;
            }

            .kpi-leg-i {
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 12px;
            }

            .kpi-leg-d {
                width: 9px;
                height: 9px;
                border-radius: 3px;
                flex: none;
            }

            .kpi-leg-n {
                font-weight: 600;
                color: var(--muted);
                flex: 1;
            }

            .kpi-leg-v {
                font-weight: 700;
                color: var(--ink);
            }

            /* ── Ranked rows ── */
            .kpi-rank {
                display: flex;
                align-items: center;
                gap: 13px;
                padding: 11px 20px;
                transition: background .15s;
            }

            .kpi-rank:hover {
                background: #FAFBFC;
            }

            .kpi-rank-no {
                width: 24px;
                height: 24px;
                border-radius: 7px;
                display: grid;
                place-items: center;
                font-size: 11.5px;
                font-weight: 700;
                background: #F1F3F6;
                color: var(--muted);
                flex: none;
            }

            .kpi-rank-nm {
                font-size: 12.5px;
                font-weight: 600;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .kpi-rank-bar {
                height: 5px;
                border-radius: 999px;
                background: #F1F3F6;
                overflow: hidden;
                margin-top: 6px;
            }

            .kpi-rank-fl {
                height: 100%;
                border-radius: 999px;
            }

            .kpi-rank-v {
                font-size: 12.5px;
                font-weight: 700;
                flex: none;
            }

            /* ── Table ── */
            .kpi-tbl {
                width: 100%;
                border-collapse: collapse;
            }

            .kpi-tbl th {
                text-align: left;
                font-size: 10.5px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: .05em;
                color: var(--faint);
                padding: 11px 20px;
                border-bottom: 1px solid var(--border);
            }

            .kpi-tbl td {
                padding: 12px 20px;
                border-bottom: 1px solid #F4F6F9;
                font-size: 12.5px;
            }

            .kpi-tbl tr:last-child td {
                border-bottom: 0;
            }

            .kpi-tbl tbody tr {
                transition: background .15s;
            }

            .kpi-tbl tbody tr:hover {
                background: #FAFBFC;
            }

            .kpi-badge {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 3px 9px;
                border-radius: 999px;
                font-size: 11px;
                font-weight: 700;
            }

            .kpi-badge i {
                width: 6px;
                height: 6px;
                border-radius: 999px;
            }

            .kpi-empty {
                padding: 34px;
                text-align: center;
                font-size: 12px;
                color: var(--faint);
            }
        </style>
    @endpush

    @php
        $trend = function (float $d) {
            $up = $d >= 0;
            $cls = $up ? 'kpi-trend-up' : 'kpi-trend-dn';
            $arrow = $up
                ? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="m6 15 6-6 6 6"/></svg>'
                : '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="m6 9 6 6 6-6"/></svg>';
            return '<span class="kpi-trend ' . $cls . '">' . $arrow . abs($d) . '%</span>';
        };
    @endphp

    <div class="kpi">
        <div class="kpi-shell">

            {{-- ════════ HEADER ════════ --}}
            <div style="display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:14px;">
                <div>
                    <h1 style="font-size:20px;font-weight:800;letter-spacing:-0.03em;line-height:1;">Tableau de bord</h1>
                    <p style="font-size:12.5px;color:var(--muted);margin-top:5px;font-weight:500;">Performances clients,
                        ventes &amp; demandes de bonus</p>
                </div>
                <a href="{{ route('demandes.index') }}"
                    style="display:inline-flex;align-items:center;gap:6px;background:#0B1220;color:#fff;font-size:12.5px;font-weight:600;padding:9px 16px;border-radius:11px;text-decoration:none;transition:background .15s;"
                    onmouseover="this.style.background='#1F2937'" onmouseout="this.style.background='#0B1220'">
                    Voir les demandes
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                        style="width:13px;height:13px;">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            {{-- ════════ STAT CARDS ════════ --}}
            <div class="kpi-grid kpi-g4">
                {{-- Clients --}}
                <div class="kpi-card kpi-card-h kpi-stat">
                    <div class="kpi-stat-hd">
                        <span class="kpi-stat-ic" style="background:#FFF1E7;color:#F97316;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </span>
                        <span class="kpi-stat-lab">Clients inscrits</span>
                    </div>
                    <div class="kpi-stat-row">
                        <span class="kpi-stat-val">{{ number_format($totalClients, 0, ',', ' ') }}</span>
                        {!! $trend($clientsDelta) !!}
                    </div>
                    <div class="kpi-stat-sub">{{ number_format($activeClients, 0, ',', ' ') }} actifs · vs mois préc.
                    </div>
                </div>

                {{-- Sales --}}
                <div class="kpi-card kpi-card-h kpi-stat">
                    <div class="kpi-stat-hd">
                        <span class="kpi-stat-ic" style="background:#E7FBF1;color:#10B981;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="1" x2="12" y2="23" />
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                            </svg>
                        </span>
                        <span class="kpi-stat-lab">Total Sales (HT)</span>
                    </div>
                    <div class="kpi-stat-row">
                        <span class="kpi-stat-val">
                            @if ($totalSales >= 1000000)
                                {{ number_format($totalSales / 1000000, 2, ',', ' ') }}M
                                @else{{ number_format($totalSales, 0, ',', ' ') }}
                            @endif
                        </span>
                        {!! $trend($salesDelta) !!}
                    </div>
                    <div class="kpi-stat-sub">Ø {{ number_format($avgSales, 0, ',', ' ') }} MAD / client</div>
                </div>

                {{-- Points --}}
                <div class="kpi-card kpi-card-h kpi-stat">
                    <div class="kpi-stat-hd">
                        <span class="kpi-stat-ic" style="background:#FFF8E5;color:#F59E0B;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polygon
                                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                            </svg>
                        </span>
                        <span class="kpi-stat-lab">Total Points</span>
                    </div>
                    <div class="kpi-stat-row">
                        <span class="kpi-stat-val">{{ number_format($totalPoints, 0, ',', ' ') }}</span>
                    </div>
                    <div class="kpi-stat-sub">{{ number_format($pointsRedeemed, 0, ',', ' ') }} pts échangés</div>
                </div>

                {{-- Demandes --}}
                <div class="kpi-card kpi-card-h kpi-stat">
                    <div class="kpi-stat-hd">
                        <span class="kpi-stat-ic" style="background:#EEF0FF;color:#6366F1;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 12 20 22 4 22 4 12" />
                                <rect x="2" y="7" width="20" height="5" />
                                <line x1="12" y1="22" x2="12" y2="7" />
                                <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z" />
                                <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z" />
                            </svg>
                        </span>
                        <span class="kpi-stat-lab">Demandes Bonus</span>
                    </div>
                    <div class="kpi-stat-row">
                        <span class="kpi-stat-val">{{ number_format($totalDemandes, 0, ',', ' ') }}</span>
                        {!! $trend($demandesDelta) !!}
                    </div>
                    <div class="kpi-stat-sub">{{ number_format($pendingDemandes, 0, ',', ' ') }} en attente</div>
                </div>
            </div>

            {{-- ════════ SALES FEATURE + DEMANDES BAR ════════ --}}
            <div class="kpi-grid kpi-g-21">
                {{-- Big sales card --}}
                <div class="kpi-card">
                    <div class="kpi-ph">
                        <div>
                            <div class="kpi-ph-s">Chiffre d'affaires total (HT)</div>
                            <div style="display:flex;align-items:center;gap:10px;margin-top:4px;">
                                <span style="font-size:28px;font-weight:800;letter-spacing:-0.03em;">
                                    @if ($totalSales >= 1000000)
                                        {{ number_format($totalSales / 1000000, 1, ',', ' ') }}M
                                        @else{{ number_format($totalSales, 0, ',', ' ') }}
                                    @endif
                                    <span style="font-size:15px;color:var(--faint);">MAD</span>
                                </span>
                                {!! $trend($salesDelta) !!}
                            </div>
                        </div>
                        <span class="kpi-dots">
                            <svg viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;">
                                <circle cx="5" cy="12" r="1.6" />
                                <circle cx="12" cy="12" r="1.6" />
                                <circle cx="19" cy="12" r="1.6" />
                            </svg>
                        </span>
                    </div>
                    <div class="kpi-cv kpi-cv-h"><canvas id="salesChart"></canvas></div>
                    <div class="kpi-mini">
                        <div class="kpi-mini-c">
                            <span class="kpi-mini-ic" style="background:#FFF1E7;color:#F97316;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                            </span>
                            <div>
                                <div class="kpi-mini-v">{{ number_format($activeClients, 0, ',', ' ') }}</div>
                                <div class="kpi-mini-l">Clients actifs</div>
                            </div>
                        </div>
                        <div class="kpi-mini-c">
                            <span class="kpi-mini-ic" style="background:#E7FBF1;color:#10B981;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                    <polyline points="22 4 12 14.01 9 11.01" />
                                </svg>
                            </span>
                            <div>
                                <div class="kpi-mini-v">
                                    {{ number_format($approvedDemandes + $deliveredDemandes, 0, ',', ' ') }}</div>
                                <div class="kpi-mini-l">Bonus validés</div>
                            </div>
                        </div>
                        <div class="kpi-mini-c">
                            <span class="kpi-mini-ic" style="background:#FFF8E5;color:#F59E0B;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polygon
                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                                </svg>
                            </span>
                            <div>
                                <div class="kpi-mini-v">
                                    {{ number_format($pointsRedeemed >= 1000 ? $pointsRedeemed / 1000 : $pointsRedeemed, $pointsRedeemed >= 1000 ? 1 : 0, ',', ' ') }}{{ $pointsRedeemed >= 1000 ? 'k' : '' }}
                                </div>
                                <div class="kpi-mini-l">Points échangés</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Demandes bar (highlighted) --}}
                <div class="kpi-card">
                    <div class="kpi-ph">
                        <div>
                            <div class="kpi-ph-t">Demandes / mois</div>
                            <div class="kpi-ph-s">Volume des 12 derniers mois</div>
                        </div>
                        <span class="kpi-dots">
                            <svg viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;">
                                <circle cx="5" cy="12" r="1.6" />
                                <circle cx="12" cy="12" r="1.6" />
                                <circle cx="19" cy="12" r="1.6" />
                            </svg>
                        </span>
                    </div>
                    <div class="kpi-cv kpi-cv-h"><canvas id="demandesChart"></canvas></div>
                </div>
            </div>

            {{-- ════════ GROUPED BARS + APPROVAL GAUGE ════════ --}}
            <div class="kpi-grid kpi-g-21">
                {{-- Grouped: clients vs demandes --}}
                <div class="kpi-card">
                    <div class="kpi-ph">
                        <div>
                            <div class="kpi-ph-t">Activité mensuelle</div>
                            <div class="kpi-ph-s">Nouveaux clients vs demandes de bonus</div>
                        </div>
                        <div style="display:flex;align-items:center;gap:14px;">
                            <span
                                style="font-size:11.5px;font-weight:600;color:var(--muted);display:flex;align-items:center;gap:6px;"><i
                                    style="width:9px;height:9px;border-radius:3px;background:#F97316;"></i>Clients</span>
                            <span
                                style="font-size:11.5px;font-weight:600;color:var(--muted);display:flex;align-items:center;gap:6px;"><i
                                    style="width:9px;height:9px;border-radius:3px;background:#6366F1;"></i>Demandes</span>
                        </div>
                    </div>
                    <div class="kpi-cv kpi-cv-h"><canvas id="activityChart"></canvas></div>
                </div>

                {{-- Approval gauge --}}
                <div class="kpi-card">
                    <div class="kpi-ph">
                        <div>
                            <div class="kpi-ph-t">Taux d'approbation</div>
                            <div class="kpi-ph-s">Demandes traitées</div>
                        </div>
                    </div>
                    <div class="kpi-gauge-wrap">
                        <div class="kpi-gauge-c">
                            <canvas id="gaugeChart"></canvas>
                            <div class="kpi-gauge-mid">
                                <div class="kpi-gauge-val">{{ $approvalRate }}%</div>
                                <div class="kpi-gauge-lab">approuvées / livrées</div>
                            </div>
                        </div>
                    </div>
                    <div style="display:flex;justify-content:center;gap:18px;padding:0 20px 18px;">
                        <span
                            style="font-size:11.5px;font-weight:600;color:var(--muted);display:flex;align-items:center;gap:6px;"><i
                                style="width:9px;height:9px;border-radius:3px;background:#10B981;"></i>Validées
                            {{ $approvedDemandes + $deliveredDemandes }}</span>
                        <span
                            style="font-size:11.5px;font-weight:600;color:var(--muted);display:flex;align-items:center;gap:6px;"><i
                                style="width:9px;height:9px;border-radius:3px;background:#F87171;"></i>Rejetées
                            {{ $rejectedDemandes }}</span>
                    </div>
                </div>
            </div>

            {{-- ════════ DONUT LEGEND + CLIENTS LINE ════════ --}}
            <div class="kpi-grid kpi-g-12">
                {{-- Donut breakdown --}}
                <div class="kpi-card">
                    <div class="kpi-ph">
                        <div>
                            <div class="kpi-ph-t">Demandes par statut</div>
                            <div class="kpi-ph-s">Répartition globale</div>
                        </div>
                    </div>
                    <div class="kpi-cv kpi-cv-sm"><canvas id="demandeStatusChart"></canvas></div>
                    @php $td = max($totalDemandes, 1); @endphp
                    <div class="kpi-leg">
                        <div class="kpi-leg-i"><span class="kpi-leg-d" style="background:#FBBF24;"></span><span
                                class="kpi-leg-n">En attente</span><span
                                class="kpi-leg-v">{{ round(($pendingDemandes / $td) * 100) }}%</span></div>
                        <div class="kpi-leg-i"><span class="kpi-leg-d" style="background:#60A5FA;"></span><span
                                class="kpi-leg-n">Approuvées</span><span
                                class="kpi-leg-v">{{ round(($approvedDemandes / $td) * 100) }}%</span></div>
                        <div class="kpi-leg-i"><span class="kpi-leg-d" style="background:#34D399;"></span><span
                                class="kpi-leg-n">Livrées</span><span
                                class="kpi-leg-v">{{ round(($deliveredDemandes / $td) * 100) }}%</span></div>
                        <div class="kpi-leg-i"><span class="kpi-leg-d" style="background:#F87171;"></span><span
                                class="kpi-leg-n">Rejetées</span><span
                                class="kpi-leg-v">{{ round(($rejectedDemandes / $td) * 100) }}%</span></div>
                    </div>
                </div>

                {{-- New clients line --}}
                <div class="kpi-card">
                    <div class="kpi-ph">
                        <div>
                            <div class="kpi-ph-t">Nouveaux clients</div>
                            <div class="kpi-ph-s">Inscriptions mensuelles · 12 mois</div>
                        </div>
                        {!! $trend($clientsDelta) !!}
                    </div>
                    <div class="kpi-cv kpi-cv-sm" style="height:236px;"><canvas id="clientsChart"></canvas></div>
                </div>
            </div>

            {{-- ════════ TOP CLIENTS ════════ --}}
            <div class="kpi-grid kpi-g2">
                {{-- By sales --}}
                <div class="kpi-card" style="padding-bottom:8px;">
                    <div class="kpi-ph" style="padding-bottom:12px;">
                        <div>
                            <div class="kpi-ph-t">Top clients · Ventes</div>
                            <div class="kpi-ph-s">Meilleurs contributeurs au CA</div>
                        </div>
                        <a href="{{ route('clients') }}" class="kpi-link">Tous</a>
                    </div>
                    @php $maxSales = $topBySales->max('total_sales') ?: 1; @endphp
                    @forelse($topBySales as $i => $c)
                        <div class="kpi-rank">
                            <span class="kpi-rank-no">{{ $i + 1 }}</span>
                            <div style="flex:1;min-width:0;">
                                <div class="kpi-rank-nm">{{ $c->company_name }}</div>
                                <div class="kpi-rank-bar">
                                    <div class="kpi-rank-fl"
                                        style="width:{{ round(($c->total_sales / $maxSales) * 100) }}%;background:linear-gradient(90deg,#10B981,#34D399);">
                                    </div>
                                </div>
                            </div>
                            <span class="kpi-rank-v">
                                @if ($c->total_sales >= 1000000)
                                    {{ number_format($c->total_sales / 1000000, 1, ',', ' ') }}M
                                    @else{{ number_format($c->total_sales, 0, ',', ' ') }}
                                @endif
                            </span>
                        </div>
                    @empty
                        <div class="kpi-empty">Aucun client</div>
                    @endforelse
                </div>

                {{-- By points --}}
                <div class="kpi-card" style="padding-bottom:8px;">
                    <div class="kpi-ph" style="padding-bottom:12px;">
                        <div>
                            <div class="kpi-ph-t">Top clients · Points</div>
                            <div class="kpi-ph-s">Soldes de fidélité les plus élevés</div>
                        </div>
                        <a href="{{ route('clients') }}" class="kpi-link">Tous</a>
                    </div>
                    @php $maxPts = $topByPoints->max('points_balance') ?: 1; @endphp
                    @forelse($topByPoints as $i => $c)
                        <div class="kpi-rank">
                            <span class="kpi-rank-no">{{ $i + 1 }}</span>
                            <div style="flex:1;min-width:0;">
                                <div class="kpi-rank-nm">{{ $c->company_name }}</div>
                                <div class="kpi-rank-bar">
                                    <div class="kpi-rank-fl"
                                        style="width:{{ round(($c->points_balance / $maxPts) * 100) }}%;background:linear-gradient(90deg,#F59E0B,#FBBF24);">
                                    </div>
                                </div>
                            </div>
                            <span class="kpi-rank-v">{{ number_format($c->points_balance, 0, ',', ' ') }}</span>
                        </div>
                    @empty
                        <div class="kpi-empty">Aucun client</div>
                    @endforelse
                </div>
            </div>

            {{-- ════════ POPULAR BONUS + RECENT DEMANDES ════════ --}}
            <div class="kpi-grid kpi-g-12">
                {{-- Popular bonus --}}
                <div class="kpi-card" style="padding-bottom:8px;">
                    <div class="kpi-ph" style="padding-bottom:12px;">
                        <div>
                            <div class="kpi-ph-t">Bonus populaires</div>
                            <div class="kpi-ph-s">Récompenses les plus demandées</div>
                        </div>
                    </div>
                    @php $maxBonus = $topBonusLevels->max('cnt') ?: 1; @endphp
                    @forelse($topBonusLevels as $i => $row)
                        <div class="kpi-rank">
                            <span class="kpi-rank-no"
                                style="background:#EEF0FF;color:#6366F1;">{{ $i + 1 }}</span>
                            <div style="flex:1;min-width:0;">
                                <div class="kpi-rank-nm">
                                    {{ $row->bonusLevel?->reward_name ?? ($row->bonusLevel?->name ?? 'Bonus supprimé') }}
                                </div>
                                <div class="kpi-rank-bar">
                                    <div class="kpi-rank-fl"
                                        style="width:{{ round(($row->cnt / $maxBonus) * 100) }}%;background:linear-gradient(90deg,#6366F1,#818CF8);">
                                    </div>
                                </div>
                            </div>
                            <span class="kpi-rank-v" style="color:#6366F1;">{{ $row->cnt }}</span>
                        </div>
                    @empty
                        <div class="kpi-empty">Aucune demande</div>
                    @endforelse
                </div>

                {{-- Recent demandes --}}
                <div class="kpi-card" style="overflow:hidden;">
                    <div class="kpi-ph" style="padding-bottom:14px;">
                        <div>
                            <div class="kpi-ph-t">Dernières demandes</div>
                            <div class="kpi-ph-s">Activité récente</div>
                        </div>
                        <a href="{{ route('demandes.index') }}" class="kpi-link">Tout voir</a>
                    </div>
                    <table class="kpi-tbl">
                        <thead>
                            <tr>
                                <th>Réf</th>
                                <th>Client</th>
                                <th style="text-align:right;">Points</th>
                                <th style="text-align:center;">Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentDemandes as $demande)
                                @php
                                    $badge = match ($demande->status) {
                                        'pending' => ['#FFFBEB', '#D97706', '#FBBF24', 'En attente'],
                                        'approved' => ['#EFF6FF', '#2563EB', '#60A5FA', 'Approuvée'],
                                        'delivered' => ['#ECFDF5', '#059669', '#34D399', 'Livrée'],
                                        'rejected' => ['#FEF2F2', '#DC2626', '#F87171', 'Rejetée'],
                                        default => ['#F1F5F9', '#64748B', '#94A3B8', ucfirst($demande->status)],
                                    };
                                @endphp
                                <tr>
                                    <td><a href="{{ route('demandes.show', $demande) }}"
                                            style="font-weight:700;color:#334155;text-decoration:none;">{{ $demande->demande_key }}</a>
                                    </td>
                                    <td style="color:var(--muted);">{{ $demande->client?->company_name ?? '—' }}</td>
                                    <td style="text-align:right;font-weight:700;">
                                        {{ number_format($demande->points_required, 0, ',', ' ') }}</td>
                                    <td style="text-align:center;"><span class="kpi-badge"
                                            style="background:{{ $badge[0] }};color:{{ $badge[1] }};"><i
                                                style="background:{{ $badge[2] }};"></i>{{ $badge[3] }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="kpi-empty">Aucune demande récente</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        <script>
            (function() {
                const emerald = '#10B981',
                    orange = '#F97316',
                    indigo = '#6366F1';
                const gridColor = 'rgba(11,18,32,0.05)',
                    tickColor = '#9AA3AF';
                const tickFont = {
                    family: 'Inter, sans-serif',
                    size: 11,
                    weight: '500'
                };

                Chart.defaults.font.family = 'Inter, sans-serif';
                Chart.defaults.color = tickColor;

                const tip = {
                    backgroundColor: '#0B1220',
                    titleColor: '#fff',
                    bodyColor: '#E2E8F0',
                    padding: 11,
                    cornerRadius: 10,
                    displayColors: false,
                    usePointStyle: true,
                    titleFont: {
                        size: 11,
                        weight: '600'
                    },
                    bodyFont: {
                        size: 12.5,
                        weight: '700'
                    },
                };
                const tipLegend = {
                    ...tip,
                    displayColors: true,
                    usePointStyle: true
                };

                const baseScales = {
                    x: {
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        },
                        ticks: {
                            color: tickColor,
                            font: tickFont
                        }
                    },
                    y: {
                        grid: {
                            color: gridColor
                        },
                        border: {
                            display: false
                        },
                        beginAtZero: true,
                        ticks: {
                            color: tickColor,
                            font: tickFont,
                            padding: 8,
                            maxTicksLimit: 5
                        }
                    },
                };

                const labels = @json($monthLabels);
                const grad = (el, hex, h) => {
                    const g = el.getContext('2d').createLinearGradient(0, 0, 0, h || 250);
                    g.addColorStop(0, hex + '38');
                    g.addColorStop(1, hex + '00');
                    return g;
                };

                // ── Sales (area) ──
                const sEl = document.getElementById('salesChart');
                new Chart(sEl, {
                    type: 'line',
                    data: {
                        labels,
                        datasets: [{
                            data: @json($salesPerMonth),
                            borderColor: emerald,
                            backgroundColor: grad(sEl, emerald),
                            fill: true,
                            tension: 0.4,
                            borderWidth: 2.5,
                            pointRadius: 0,
                            pointHoverRadius: 6,
                            pointBackgroundColor: emerald,
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                ...tip,
                                callbacks: {
                                    title: c => c[0].label,
                                    label: c => new Intl.NumberFormat('fr-MA').format(c.parsed.y) + ' MAD'
                                }
                            }
                        },
                        scales: {
                            ...baseScales,
                            y: {
                                ...baseScales.y,
                                ticks: {
                                    ...baseScales.y.ticks,
                                    callback: v => v >= 1e6 ? (v / 1e6).toFixed(1) + 'M' : v >= 1e3 ? (v / 1e3)
                                        .toFixed(0) + 'k' : v
                                }
                            }
                        }
                    },
                });

                // ── Demandes per month (highlighted bar) ──
                const dData = @json($demandesPerMonth);
                const maxIdx = dData.indexOf(Math.max(...dData));
                new Chart(document.getElementById('demandesChart'), {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                            data: dData,
                            borderRadius: 7,
                            borderSkipped: false,
                            barPercentage: 0.62,
                            categoryPercentage: 0.72,
                            backgroundColor: dData.map((_, i) => i === maxIdx ? indigo : '#E7E9F2'),
                            hoverBackgroundColor: dData.map((_, i) => i === maxIdx ? indigo : '#C7CBDD')
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                ...tip,
                                callbacks: {
                                    title: c => c[0].label,
                                    label: c => c.parsed.y + ' demande(s)'
                                }
                            }
                        },
                        scales: {
                            ...baseScales,
                            y: {
                                ...baseScales.y,
                                ticks: {
                                    ...baseScales.y.ticks,
                                    precision: 0
                                }
                            }
                        }
                    },
                });

                // ── Activity grouped bars ──
                new Chart(document.getElementById('activityChart'), {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                                label: 'Clients',
                                data: @json($clientsPerMonth),
                                backgroundColor: orange,
                                borderRadius: 5,
                                borderSkipped: false,
                                barPercentage: 0.7,
                                categoryPercentage: 0.6
                            },
                            {
                                label: 'Demandes',
                                data: dData,
                                backgroundColor: indigo,
                                borderRadius: 5,
                                borderSkipped: false,
                                barPercentage: 0.7,
                                categoryPercentage: 0.6
                            },
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: tipLegend
                        },
                        scales: {
                            ...baseScales,
                            y: {
                                ...baseScales.y,
                                ticks: {
                                    ...baseScales.y.ticks,
                                    precision: 0
                                }
                            }
                        }
                    },
                });

                // ── Clients line ──
                const cEl = document.getElementById('clientsChart');
                new Chart(cEl, {
                    type: 'line',
                    data: {
                        labels,
                        datasets: [{
                            data: @json($clientsPerMonth),
                            borderColor: orange,
                            backgroundColor: grad(cEl, orange, 236),
                            fill: true,
                            tension: 0.4,
                            borderWidth: 2.5,
                            pointRadius: 0,
                            pointHoverRadius: 6,
                            pointBackgroundColor: orange,
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                ...tip,
                                callbacks: {
                                    title: c => c[0].label,
                                    label: c => c.parsed.y + ' client(s)'
                                }
                            }
                        },
                        scales: {
                            ...baseScales,
                            y: {
                                ...baseScales.y,
                                ticks: {
                                    ...baseScales.y.ticks,
                                    precision: 0
                                }
                            }
                        }
                    },
                });

                // ── Demande status donut ──
                new Chart(document.getElementById('demandeStatusChart'), {
                    type: 'doughnut',
                    data: {
                        labels: ['En attente', 'Approuvées', 'Livrées', 'Rejetées'],
                        datasets: [{
                            data: [{{ $pendingDemandes }}, {{ $approvedDemandes }},
                                {{ $deliveredDemandes }}, {{ $rejectedDemandes }}
                            ],
                            backgroundColor: ['#FBBF24', '#60A5FA', '#34D399', '#F87171'],
                            borderWidth: 0,
                            hoverOffset: 8,
                            spacing: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                ...tip,
                                callbacks: {
                                    label: c => ' ' + c.label + ' : ' + c.parsed
                                }
                            }
                        }
                    },
                });

                // ── Approval gauge (semi-circle) ──
                const rate = {{ $approvalRate }};
                new Chart(document.getElementById('gaugeChart'), {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [rate, 100 - rate],
                            backgroundColor: ['#10B981', '#EEF1F5'],
                            borderWidth: 0,
                            circumference: 180,
                            rotation: 270
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '78%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: false
                            }
                        }
                    },
                });
            })();
        </script>
    @endpush

</x-app-layout>
