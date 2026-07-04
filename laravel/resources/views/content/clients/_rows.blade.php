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
        $sc = ['active' => 'active', 'blocked' => 'blocked', 'inactive' => 'inactive'][$client->status] ?? 'inactive';
        $sl =
            [
                'active' => __('clients.status_active'),
                'blocked' => __('clients.status_blocked'),
                'inactive' => __('clients.status_inactive'),
            ][$client->status] ?? '—';
        $statusStyles = [
            'active' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'blocked' => 'bg-red-50 text-red-700 border-red-200',
            'inactive' => 'bg-amber-50 text-amber-700 border-amber-200',
        ];
        $dotStyles = [
            'active' => 'bg-emerald-500',
            'blocked' => 'bg-red-500',
            'inactive' => 'bg-amber-500',
        ];
    @endphp
    <tr class="list-row group border-b border-slate-100 transition-colors last:border-0 hover:bg-slate-50/60"
        data-name="{{ strtolower($client->company_name) }}" data-phone="{{ $client->phone }}"
        data-email="{{ strtolower($client->email) }}" data-code="{{ strtolower($client->pcc_customer_code) }}"
        data-status="{{ $client->status }}">

        {{-- Client name + avatar --}}
        <td class="px-5 py-4">
            <a href="{{ route('clients.show', $client) }}" class="flex items-center gap-3.5">
                @php $pictureUrl = $client->getFirstMediaUrl('picture'); @endphp
                @if ($pictureUrl)
                    <img src="{{ $pictureUrl }}" alt="{{ $client->company_name }}"
                        class="h-10 w-10 shrink-0 rounded-[13px] object-cover shadow-sm"
                        style="background:{{ $grad }}">
                @else
                    <div class="h-10 w-10 shrink-0 rounded-[13px] grid place-items-center text-[13px] font-black text-white shadow-sm"
                        style="background:{{ $grad }}">
                        {{ $initials }}
                    </div>
                @endif
                <div class="min-w-0">
                    <p
                        class="text-[13px] font-black text-slate-900 truncate group-hover:text-blue-600 transition-colors">
                        {{ $client->company_name }}
                    </p>
                    @if ($client->contact_name)
                        <p class="text-[11px] font-semibold text-slate-400 truncate mt-0.5">{{ $client->contact_name }}
                        </p>
                    @endif
                </div>
            </a>
        </td>

        {{-- Phone --}}
        <td class="px-4 py-4">
            @if ($client->phone)
                <div class="flex items-center gap-2">
                    <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-slate-100">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="1.8" class="h-3.5 w-3.5">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.77a16 16 0 0 0 6.29 6.29l.95-.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
                        </svg>
                    </div>
                    <span class="text-[12.5px] font-semibold text-slate-600">{{ $client->phone }}</span>
                </div>
            @else
                <span class="text-[12px] text-slate-300 font-medium">—</span>
            @endif
        </td>

        {{-- Email --}}
        <td class="px-4 py-4 max-w-[200px]">
            <div class="flex items-center gap-2">
                <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-slate-100">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="1.8" class="h-3.5 w-3.5">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                        <polyline points="22,6 12,13 2,6" />
                    </svg>
                </div>
                <span class="text-[12px] font-semibold text-slate-500 truncate">{{ $client->email }}</span>
            </div>
        </td>

        {{-- PCC Code --}}
        <td class="px-4 py-4">
            @if ($client->pcc_customer_code)
                <span
                    class="inline-flex items-center rounded-lg bg-slate-100 px-2.5 py-1 font-mono text-[11.5px] font-bold text-slate-600">
                    {{ $client->pcc_customer_code }}
                </span>
            @else
                <span class="text-[12px] text-slate-300 font-medium">—</span>
            @endif
        </td>

        {{-- Sales + Points --}}
        <td class="px-4 py-4 text-right">
            <p class="text-[12.5px] font-black text-slate-900">
                {{ number_format((float) ($client->total_sales ?? 0), 0, ',', ' ') }}
                <span class="text-[11px] font-semibold text-slate-400">MAD</span>
            </p>
            <p class="mt-0.5 text-[11px] font-bold text-amber-500">
                {{ number_format((int) $client->points_balance, 0, ',', ' ') }} pts
            </p>
        </td>

        {{-- Status --}}
        <td class="px-4 py-4">
            <span
                class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-1 text-[11px] font-bold {{ $statusStyles[$sc] }}">
                <span class="h-1.5 w-1.5 rounded-full {{ $dotStyles[$sc] }}"></span>
                {{ $sl }}
            </span>
        </td>

        {{-- Actions --}}
        <td class="px-5 py-4">
            <div class="flex items-center justify-end gap-2">
                <a href="{{ route('clients.show', $client) }}" class="card-action view">
                    {{ __('clients.action_view') }}
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="h-3 w-3">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                </a>
                @if ($client->status === 'inactive')
                    <button class="card-action act-btn activate client-action" data-action="activate"
                        data-url="{{ route('clients.activate', $client) }}" data-name="{{ $client->company_name }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                            class="h-3 w-3">
                            <path d="m5 12 5 5L20 7" />
                        </svg>
                        {{ __('clients.action_activate') }}
                    </button>
                @elseif ($client->status === 'blocked')
                    <button class="card-action act-btn unblock client-action" data-action="unblock"
                        data-url="{{ route('clients.unblock', $client) }}" data-name="{{ $client->company_name }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                            class="h-3 w-3">
                            <rect x="3" y="11" width="18" height="11" rx="2" />
                            <path d="M7 11V7a5 5 0 0 1 9.9-1" />
                        </svg>
                        {{ __('clients.action_unblock') }}
                    </button>
                @else
                    <button class="card-action act-btn block client-action" data-action="block"
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
        </td>
    </tr>
@endforeach
