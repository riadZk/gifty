<x-app-layout>

    <div class="flex flex-col gap-5">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('clients.show', $client->id) }}"
                class="flex items-center gap-1.5 text-[12.5px] font-semibold text-slate-500 hover:text-slate-800 transition-colors">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3.5 w-3.5">
                    <path d="M19 12H5M12 5l-7 7 7 7" />
                </svg>
                {{ $client->company_name }}
            </a>
            <span class="text-slate-300">/</span>
            <span class="text-[12.5px] font-semibold text-slate-800">{{ __('demandes.create_breadcrumb') }}</span>
        </div>

        {{-- Flash --}}
        @if (session('error'))
            <div
                class="flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-[13px] font-semibold text-red-700">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 shrink-0">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 8v4m0 4h.01" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 gap-5 xl:grid-cols-3">

            {{-- ════ LEFT: Form ════ --}}
            <div class="xl:col-span-2">
                <form method="POST" action="{{ route('demandes.store') }}">
                    @csrf
                    <input type="hidden" name="client_id" value="{{ $client->id }}">

                    <div class="flex flex-col gap-5">

                        {{-- Client recap --}}
                        <div class="flex items-center gap-4 rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                            <span
                                class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-amber-50 text-[15px] font-black text-amber-600">
                                {{ strtoupper(substr($client->company_name, 0, 2)) }}
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-[14px] font-bold text-slate-900">{{ $client->company_name }}</p>
                                <p class="text-[12px] text-slate-500">{{ $client->email }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">
                                    {{ __('demandes.create_points_label') }}
                                </p>
                                <p class="text-[18px] font-black text-slate-900">
                                    {{ number_format($client->points_balance, 0, ',', ' ') }}
                                    <span class="text-[12px] font-semibold text-slate-400">pts</span>
                                </p>
                            </div>
                        </div>

                        {{-- Choose bonus level --}}
                        <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
                            <div class="border-b border-slate-100 px-5 py-4">
                                <h2 class="text-[13px] font-bold text-slate-800">
                                    {{ __('demandes.create_choose_title') }}</h2>
                                <p class="mt-0.5 text-[12px] text-slate-400">{{ __('demandes.create_choose_sub') }}</p>
                            </div>
                            <div class="p-5">
                                @if ($bonusLevels->isEmpty())
                                    <p class="py-6 text-center text-[13px] text-slate-400">
                                        {{ __('demandes.create_no_bonus') }}
                                    </p>
                                @else
                                    <div class="flex flex-col gap-3" x-data="{ selected: null }">
                                        @foreach ($bonusLevels as $bonus)
                                            @php
                                                $canAfford = $client->points_balance >= $bonus->required_points;
                                            @endphp
                                            <label
                                                class="relative flex cursor-pointer items-start gap-4 rounded-xl border-2 p-4 transition-colors
                                                {{ $canAfford ? 'hover:border-amber-300 hover:bg-amber-50/40' : 'opacity-60 cursor-not-allowed' }}"
                                                :class="selected == '{{ $bonus->id }}' ? 'border-amber-400 bg-amber-50' :
                                                    'border-slate-200 bg-white'">
                                                <input type="radio" name="bonus_level_id" value="{{ $bonus->id }}"
                                                    {{ !$canAfford ? 'disabled' : '' }}
                                                    x-on:change="selected = '{{ $bonus->id }}'"
                                                    class="mt-1 h-4 w-4 shrink-0 accent-amber-400">

                                                <div
                                                    class="grid h-12 w-12 shrink-0 place-items-center overflow-hidden rounded-xl bg-slate-100">
                                                    @if ($bonus->image)
                                                        <img src="{{ $bonus->image }}" alt="{{ $bonus->reward_name }}"
                                                            class="h-12 w-12 object-cover">
                                                    @else
                                                        <svg viewBox="0 0 24 24" fill="none" stroke="#94a3b8"
                                                            stroke-width="1.8" class="h-5 w-5">
                                                            <polyline points="20 12 20 22 4 22 4 12" />
                                                            <rect x="2" y="7" width="20" height="5" />
                                                            <line x1="12" y1="22" x2="12"
                                                                y2="7" />
                                                        </svg>
                                                    @endif
                                                </div>

                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center gap-2">
                                                        <p class="text-[13.5px] font-bold text-slate-900">
                                                            {{ $bonus->reward_name }}</p>
                                                        @if (!$canAfford)
                                                            <span
                                                                class="rounded-full bg-red-50 px-2 py-0.5 text-[10.5px] font-bold text-red-500">
                                                                {{ __('demandes.create_badge_insufficient') }}
                                                            </span>
                                                        @else
                                                            <span
                                                                class="rounded-full bg-emerald-50 px-2 py-0.5 text-[10.5px] font-bold text-emerald-600">
                                                                {{ __('demandes.create_badge_available') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    @if ($bonus->reward_description)
                                                        <p class="mt-0.5 text-[12px] text-slate-500">
                                                            {{ $bonus->reward_description }}</p>
                                                    @endif
                                                    <div class="mt-2 flex items-center gap-4 text-[12px]">
                                                        <span class="font-bold text-amber-600">
                                                            {{ number_format($bonus->required_points, 0, ',', ' ') }}
                                                            {{ __('demandes.create_pts_required') }}
                                                        </span>
                                                        @if ($canAfford)
                                                            <span class="text-slate-400">
                                                                {{ __('demandes.create_pts_remaining') }}
                                                                {{ number_format($client->points_balance - $bonus->required_points, 0, ',', ' ') }}
                                                                pts
                                                            </span>
                                                        @else
                                                            <span class="text-red-400">
                                                                {{ __('demandes.create_pts_missing') }}
                                                                {{ number_format($bonus->required_points - $client->points_balance, 0, ',', ' ') }}
                                                                pts
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('bonus_level_id')
                                        <p class="mt-2 text-[12px] text-red-500">{{ $message }}</p>
                                    @enderror
                                @endif
                            </div>
                        </div>

                        {{-- Notes --}}
                        <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
                            <div class="border-b border-slate-100 px-5 py-4">
                                <h2 class="text-[13px] font-bold text-slate-800">
                                    {{ __('demandes.create_notes_title') }} <span
                                        class="text-slate-400 font-normal">{{ __('demandes.create_notes_optional') }}</span>
                                </h2>
                            </div>
                            <div class="p-5">
                                <textarea name="notes" rows="3" placeholder="{{ __('demandes.create_notes_placeholder') }}"
                                    class="w-full resize-none rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-[13px] text-slate-700 focus:border-amber-400 focus:outline-none focus:ring-0">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('clients.show', $client->id) }}"
                                class="inline-flex h-10 items-center gap-2 rounded-xl border border-slate-200 bg-white px-5 text-[13px] font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
                                {{ __('demandes.create_btn_cancel') }}
                            </a>
                            <button type="submit"
                                class="inline-flex h-10 items-center gap-2 rounded-xl bg-slate-900 px-6 text-[13px] font-bold text-white hover:bg-slate-700 transition-colors">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    class="h-4 w-4">
                                    <polyline points="20 12 20 22 4 22 4 12" />
                                    <rect x="2" y="7" width="20" height="5" />
                                    <line x1="12" y1="22" x2="12" y2="7" />
                                </svg>
                                {{ __('demandes.create_btn_submit') }}
                            </button>
                        </div>

                    </div>
                </form>
            </div>

            {{-- ════ RIGHT: Info sidebar ════ --}}
            <div class="flex flex-col gap-4">

                {{-- How it works --}}
                <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                    <h3 class="mb-4 text-[13px] font-bold text-slate-800">{{ __('demandes.create_how_title') }}</h3>
                    <ol class="flex flex-col gap-4">
                        @foreach ([[__('demandes.create_step1_title'), __('demandes.create_step1_desc'), 'bg-amber-50 text-amber-600'], [__('demandes.create_step2_title'), __('demandes.create_step2_desc'), 'bg-slate-100 text-slate-600'], [__('demandes.create_step3_title'), __('demandes.create_step3_desc'), 'bg-blue-50 text-blue-600'], [__('demandes.create_step4_title'), __('demandes.create_step4_desc'), 'bg-red-50 text-red-500'], [__('demandes.create_step5_title'), __('demandes.create_step5_desc'), 'bg-emerald-50 text-emerald-600']] as $i => [$title, $desc, $cls])
                            <li class="flex items-start gap-3">
                                <span
                                    class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full text-[11px] font-black {{ $cls }}">
                                    {{ $i + 1 }}
                                </span>
                                <div>
                                    <p class="text-[12.5px] font-bold text-slate-800">{{ $title }}</p>
                                    <p class="mt-0.5 text-[11.5px] text-slate-500">{{ $desc }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </div>

                {{-- Existing pending requests for this client --}}
                @php
                    $pendingRequests = \App\Models\BonusRequest::with('bonusLevel')
                        ->where('client_id', $client->id)
                        ->where('status', 'pending')
                        ->latest()
                        ->take(3)
                        ->get();
                @endphp
                @if ($pendingRequests->isNotEmpty())
                    <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5">
                        <h3 class="mb-3 text-[12.5px] font-bold text-amber-800">
                            {{ str_replace(':count', $pendingRequests->count(), __('demandes.create_pending_count')) }}
                        </h3>
                        <div class="flex flex-col gap-2">
                            @foreach ($pendingRequests as $pr)
                                <a href="{{ route('demandes.show', $pr->id) }}"
                                    class="flex items-center justify-between rounded-xl bg-white px-3 py-2.5 text-[12px] hover:bg-amber-100/50 transition-colors">
                                    <span
                                        class="font-semibold text-slate-700">{{ $pr->bonusLevel->reward_name }}</span>
                                    <span
                                        class="font-bold text-amber-600">{{ number_format($pr->points_required, 0, ',', ' ') }}
                                        pts</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </div>

</x-app-layout>
