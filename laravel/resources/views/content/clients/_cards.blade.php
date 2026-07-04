@php
    if (!function_exists('clientGrad')) {
        function clientGrad($name)
        {
            $palette = [
                'linear-gradient(135deg,#fb923c,#f97316)',
                'linear-gradient(135deg,#38bdf8,#3b82f6)',
                'linear-gradient(135deg,#34d399,#059669)',
                'linear-gradient(135deg,#a78bfa,#8b5cf6)',
                'linear-gradient(135deg,#2dd4bf,#06b6d4)',
                'linear-gradient(135deg,#f472b6,#ec4899)',
                'linear-gradient(135deg,#fbbf24,#eab308)',
                'linear-gradient(135deg,#fb7185,#ef4444)',
                'linear-gradient(135deg,#4ade80,#22c55e)',
                'linear-gradient(135deg,#818cf8,#6366f1)',
            ];
            $h = 0;
            for ($i = 0; $i < strlen($name); $i++) {
                $h = ($h << 5) - $h + ord($name[$i]);
                $h &= $h;
            }
            return $palette[abs($h) % count($palette)];
        }
    }
@endphp

@foreach ($clients as $client)
    @php
        $grad = clientGrad($client->company_name);
        $initials = strtoupper(substr($client->company_name, 0, 2));
        $statusClass = $client->status;
        $statusLabel =
            [
                'active' => __('clients.status_active'),
                'blocked' => __('clients.status_blocked'),
                'inactive' => __('clients.status_inactive'),
            ][$client->status] ?? '—';
        $pts = number_format((int) $client->points_balance, 0, ',', ' ');
        $delay = ($loop->index % 16) * 0.03;
    @endphp
    <div class="client-card" data-name="{{ strtolower($client->company_name) }}" data-phone="{{ $client->phone }}"
        data-email="{{ strtolower($client->email) }}" data-code="{{ strtolower($client->pcc_customer_code) }}"
        data-status="{{ $client->status }}" style="animation-delay:{{ $delay }}s">

        {{-- Card body --}}
        <a href="{{ route('clients.show', $client) }}" class="block p-4">
            {{-- Top row: avatar + name + status (top-right) --}}
            <div class="flex items-start gap-3 mb-3">
                @php $pictureUrl = $client->getFirstMediaUrl('picture'); @endphp
                @if ($pictureUrl)
                    <img src="{{ $pictureUrl }}" alt="{{ $client->company_name }}" class="card-avatar object-cover"
                        style="background:{{ $grad }}">
                @else
                    <div class="card-avatar" style="background:{{ $grad }}">{{ $initials }}</div>
                @endif
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-1">
                        <p class="font-black text-slate-900 text-[13px] leading-tight truncate">
                            {{ $client->company_name }}</p>
                        <span class="status-badge {{ $statusClass }} shrink-0">
                            <span class="dot"></span>{{ strtoupper($statusLabel) }}
                        </span>
                    </div>
                    @if ($client->contact_name)
                        <p class="mt-0.5 text-[11.5px] font-semibold text-slate-500 truncate">
                            {{ $client->contact_name }}</p>
                    @endif
                    <div class="mt-1.5 flex items-center gap-1">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8"
                            class="h-3 w-3 shrink-0">
                            <line x1="12" y1="1" x2="12" y2="23" />
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                        </svg>
                        <span
                            class="text-[11px] font-bold text-slate-600">{{ number_format((float) ($client->total_sales ?? 0), 0, ',', ' ') }}
                            MAD</span>
                    </div>
                </div>
            </div>

            {{-- Info rows --}}
            <div class="flex flex-col">
                @if ($client->phone)
                    <div class="card-info-row">
                        <div class="ico">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="1.8"
                                class="h-3.5 w-3.5">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.77a16 16 0 0 0 6.29 6.29l.95-.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
                            </svg>
                        </div>
                        <span>{{ $client->phone }}</span>
                    </div>
                @endif
                <div class="card-info-row">
                    <div class="ico">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="1.8" class="h-3.5 w-3.5">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                    </div>
                    <span>{{ $client->email }}</span>
                </div>
                <div class="card-info-row">
                    <div class="ico">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="1.8" class="h-3.5 w-3.5">
                            <polygon
                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                    </div>
                    <span class="font-bold text-amber-600">{{ $pts }} pts</span>
                </div>
            </div>
        </a>

        {{-- Card footer --}}
        <div class="card-footer">
            @if ($client->pcc_customer_code)
                <div class="flex items-center gap-1.5 flex-1 min-w-0">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8"
                        class="h-3 w-3 shrink-0">
                        <rect x="2" y="5" width="20" height="14" rx="2" />
                        <path d="M2 10h20" />
                    </svg>
                    <span class="pcc-code">{{ $client->pcc_customer_code }}</span>
                </div>
            @else
                <span class="pcc-code text-slate-300">{{ __('clients.no_pcc_code') }}</span>
            @endif
            <a href="{{ route('clients.show', $client) }}" class="card-action view">
                {{ __('clients.action_view') }}
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="h-3 w-3">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </a>
            @if ($client->status === 'inactive')
                <button class="card-action act-btn activate client-action" title="Activer" data-action="activate"
                    data-url="{{ route('clients.activate', $client) }}" data-name="{{ $client->company_name }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" class="h-3 w-3">
                        <path d="m5 12 5 5L20 7" />
                    </svg>
                    {{ __('clients.action_activate') }}
                </button>
            @elseif($client->status === 'blocked')
                <button class="card-action act-btn unblock client-action" title="Débloquer" data-action="unblock"
                    data-url="{{ route('clients.unblock', $client) }}" data-name="{{ $client->company_name }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" class="h-3 w-3">
                        <rect x="3" y="11" width="18" height="11" rx="2" />
                        <path d="M7 11V7a5 5 0 0 1 9.9-1" />
                    </svg>
                    {{ __('clients.action_unblock') }}
                </button>
            @else
                <button class="card-action act-btn block client-action" title="Bloquer" data-action="block"
                    data-url="{{ route('clients.block', $client) }}" data-name="{{ $client->company_name }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                        class="h-3 w-3">
                        <rect x="3" y="11" width="18" height="11" rx="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    {{ __('clients.action_block') }}
                </button>
            @endif
        </div>
    </div>
@endforeach
