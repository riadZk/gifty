<x-app-layout>

    <div class="mx-auto max-w-[110rem] flex gap-6">

        {{-- Sidebar --}}
        @include('content.config._sidebar')

        {{-- Main --}}
        <div class="min-w-0 flex-1 flex flex-col gap-5">

            {{-- Header --}}
            <div>
                <nav class="flex items-center gap-1.5 text-[11.5px] font-medium text-slate-400">
                    <span>{{ __('config.breadcrumb') }}</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3 w-3">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                    <span class="text-slate-600">{{ __('config.points_page_title') }}</span>
                </nav>
                <h1 class="mt-1 text-[22px] font-black tracking-tight text-slate-900">
                    {{ __('config.points_page_title') }}</h1>
            </div>

            {{-- Flash --}}
            @if (session('success'))
                <div
                    class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-[13px] font-semibold text-emerald-700">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        class="h-4 w-4 shrink-0">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Current values summary --}}
            <div class="grid gap-4 sm:grid-cols-3">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                        {{ __('config.points_card_currency') }}</p>
                    <p class="mt-1 text-[22px] font-black text-slate-900">{{ $settings->currency }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                        {{ __('config.points_card_per_amount') }}</p>
                    <p class="mt-1 text-[22px] font-black text-slate-900">
                        {{ number_format((float) $settings->points_value, 2, ',', ' ') }}
                        <span class="text-[12px] text-slate-400">pts /
                            {{ number_format((float) $settings->amount_value, 2, ',', ' ') }}
                            {{ $settings->currency }}</span>
                    </p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                        {{ __('config.points_card_annual') }}</p>
                    <p
                        class="mt-1 text-[22px] font-black {{ $settings->annual_reset ? 'text-emerald-600' : 'text-slate-400' }}">
                        {{ $settings->annual_reset ? __('config.points_annual_on') : __('config.points_annual_off') }}
                    </p>
                </div>
            </div>

            {{-- Edit form --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="mb-5 text-[14px] font-bold text-slate-800">{{ __('config.points_edit_title') }}</h2>
                <form id="points-form" class="space-y-5">
                    @csrf
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label
                                class="mb-1.5 block text-[12px] font-semibold text-slate-600">{{ __('config.points_field_currency') }}</label>
                            <input type="text" name="currency" value="{{ $settings->currency }}" maxlength="10"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-[13px] font-semibold text-slate-900 outline-none focus:border-amber-400 focus:ring-2 focus:ring-amber-100 transition">
                        </div>
                        <div>
                            <label
                                class="mb-1.5 block text-[12px] font-semibold text-slate-600">{{ __('config.points_field_amount') }}</label>
                            <input type="number" name="amount_value" value="{{ $settings->amount_value }}"
                                min="0.01" step="0.01"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-[13px] font-semibold text-slate-900 outline-none focus:border-amber-400 focus:ring-2 focus:ring-amber-100 transition">
                        </div>
                        <div>
                            <label
                                class="mb-1.5 block text-[12px] font-semibold text-slate-600">{{ __('config.points_field_points') }}</label>
                            <input type="number" name="points_value" value="{{ $settings->points_value }}"
                                min="0.01" step="0.01"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-[13px] font-semibold text-slate-900 outline-none focus:border-amber-400 focus:ring-2 focus:ring-amber-100 transition">
                        </div>
                        <div class="flex items-end pb-0.5">
                            <label class="flex cursor-pointer items-center gap-3">
                                <input type="hidden" name="annual_reset" value="0">
                                <input type="checkbox" name="annual_reset" value="1"
                                    {{ $settings->annual_reset ? 'checked' : '' }}
                                    class="h-4 w-4 rounded border-slate-300 text-amber-400 focus:ring-amber-300">
                                <span
                                    class="text-[13px] font-semibold text-slate-700">{{ __('config.points_field_annual') }}</span>
                            </label>
                        </div>
                    </div>
                    <p class="text-[12px] text-slate-400">
                        {{ __('config.points_formula_pre') }}
                        <strong>{{ number_format((float) $settings->amount_value, 2, ',', ' ') }}
                            {{ $settings->currency }}</strong>
                        {{ __('config.points_formula_mid') }}
                        <strong>{{ number_format((float) $settings->points_value, 2, ',', ' ') }}
                            {{ __('config.points_formula_end') }}</strong>
                    </p>
                    <div class="flex items-center justify-end gap-3">
                        <span id="pts-msg" class="hidden text-[12.5px] font-semibold text-emerald-600"></span>
                        <button type="submit"
                            class="inline-flex h-9 items-center gap-2 rounded-xl bg-amber-400 px-5 text-[12.5px] font-bold text-slate-900 shadow-sm transition hover:bg-amber-500">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                class="h-4 w-4">
                                <path d="m5 12 5 5L20 7" />
                            </svg>
                            {{ __('config.points_btn_save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('points-form').addEventListener('submit', async e => {
            e.preventDefault();
            const fd = new FormData(e.target);
            const res = await fetch('{{ route('loyalty.settings.update') }}', {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': fd.get('_token'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(Object.fromEntries(fd)),
            });
            const data = await res.json();
            const msg = document.getElementById('pts-msg');
            msg.textContent = data.message ?? @json(__('config.points_saved'));
            msg.classList.remove('hidden', 'text-red-500', 'text-emerald-600');
            msg.classList.add(res.ok ? 'text-emerald-600' : 'text-red-500');
            setTimeout(() => {
                msg.classList.add('hidden');
            }, 3000);
        });
    </script>

</x-app-layout>
