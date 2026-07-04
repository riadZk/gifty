<x-app-layout>

    <div class="mx-auto max-w-[110rem] flex gap-6">

        {{-- Sidebar --}}
        @include('content.config._sidebar')

        {{-- Main --}}
        <div class="min-w-0 flex-1 flex flex-col gap-5">

            {{-- Breadcrumb + title --}}
            <div style="margin-inline: 10px;">
                <nav class="flex items-center gap-1.5 text-[11.5px] font-medium text-slate-400">
                    <span>{{ __('config.breadcrumb') }}</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3 w-3">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                    <span class="text-slate-600">{{ __('config.canaux_breadcrumb') }}</span>
                </nav>
                <h1 class="mt-1 text-[22px] font-black tracking-tight text-slate-900">
                    {{ __('config.canaux_page_title') }}</h1>
                <p class="mt-0.5 text-[13px] text-slate-500">{{ __('config.canaux_page_subtitle') }}</p>
            </div>

            @if (session('success'))
                <div
                    class="flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-[13px] font-semibold text-green-700">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        class="h-4 w-4 shrink-0 text-green-500">
                        <path d="m5 12 5 5L20 7" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div
                    class="flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-[13px] font-semibold text-red-700">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        class="h-4 w-4 shrink-0 text-red-500">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- ══════════════════════════════════════
             SMTP
        ══════════════════════════════════════ --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center gap-3 border-b border-slate-100 px-6 py-4">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-500">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round" class="h-4.5 w-4.5">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                    </span>
                    <div style="margin-inline: 10px;">
                        <p class="text-[14px] font-bold text-slate-800">{{ __('config.smtp_title') }}</p>
                        <p class="text-[12px] text-slate-400">{{ __('config.smtp_subtitle') }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('config.canaux.smtp.save') }}" class="divide-y divide-slate-50">
                    @csrf

                    <div class="grid grid-cols-1 gap-x-6 gap-y-4 px-6 py-5 sm:grid-cols-2">

                        {{-- Host --}}
                        <div style="margin-inline: 10px;">
                            <label
                                class="mb-1.5 block text-[12px] font-semibold text-slate-600">{{ __('config.smtp_host') }}</label>
                            <input type="text" name="mail_host" value="{{ old('mail_host', $smtp['host']) }}"
                                placeholder="smtp.example.com"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-[13px] font-medium text-slate-800 outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-100">
                            @error('mail_host')
                                <p class="mt-1 text-[11px] text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Port --}}
                        <div style="margin-inline: 10px;">
                            <label
                                class="mb-1.5 block text-[12px] font-semibold text-slate-600">{{ __('config.smtp_port') }}</label>
                            <input type="number" name="mail_port" value="{{ old('mail_port', $smtp['port']) }}"
                                placeholder="587"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-[13px] font-medium text-slate-800 outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-100">
                            @error('mail_port')
                                <p class="mt-1 text-[11px] text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Encryption --}}
                        <div style="margin-inline: 10px;">
                            <label
                                class="mb-1.5 block text-[12px] font-semibold text-slate-600">{{ __('config.smtp_encryption') }}</label>
                            <select name="mail_encryption"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-[13px] font-medium text-slate-800 outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-100">
                                @foreach (['tls' => 'TLS', 'ssl' => 'SSL', '' => __('config.smtp_none')] as $val => $label)
                                    <option value="{{ $val }}"
                                        {{ old('mail_encryption', $smtp['encryption']) === $val ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Username --}}
                        <div style="margin-inline: 10px;">
                            <label
                                class="mb-1.5 block text-[12px] font-semibold text-slate-600">{{ __('config.smtp_username') }}</label>
                            <input type="text" name="mail_username"
                                value="{{ old('mail_username', $smtp['username']) }}" placeholder="user@example.com"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-[13px] font-medium text-slate-800 outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-100">
                            @error('mail_username')
                                <p class="mt-1 text-[11px] text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div style="margin-inline: 10px;">
                            <label
                                class="mb-1.5 block text-[12px] font-semibold text-slate-600">{{ __('config.smtp_password') }}</label>
                            <div class="relative">
                                <input type="password" name="mail_password" id="smtpPassword"
                                    placeholder="{{ __('config.smtp_password_ph') }}" autocomplete="new-password"
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 pr-10 text-[13px] font-medium text-slate-800 outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-100">
                                <button type="button" onclick="togglePwd('smtpPassword',this)"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                        class="h-4 w-4">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- From Address --}}
                        <div style="margin-inline: 10px;">
                            <label
                                class="mb-1.5 block text-[12px] font-semibold text-slate-600">{{ __('config.smtp_from_address') }}</label>
                            <input type="email" name="mail_from_address"
                                value="{{ old('mail_from_address', $smtp['from_address']) }}"
                                placeholder="noreply@example.com"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-[13px] font-medium text-slate-800 outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-100">
                            @error('mail_from_address')
                                <p class="mt-1 text-[11px] text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- From Name --}}
                        <div class="sm:col-span-2">
                            <label
                                class="mb-1.5 block text-[12px] font-semibold text-slate-600">{{ __('config.smtp_from_name') }}</label>
                            <input type="text" name="mail_from_name"
                                value="{{ old('mail_from_name', $smtp['from_name']) }}"
                                placeholder="{{ __('config.smtp_from_name_ph') }}"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-[13px] font-medium text-slate-800 outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-100">
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-between gap-3 px-6 py-4">
                        {{-- Test SMTP --}}
                        <div x-data="smtpTest()" class="flex items-center gap-3">
                            <input type="email" x-model="email" placeholder="{{ __('config.smtp_test_ph') }}"
                                class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-[12.5px] font-medium text-slate-800 outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-100 w-52">
                            <button type="button" @click="run" :disabled="loading"
                                class="inline-flex items-center gap-2 rounded-xl border border-blue-200 bg-blue-50 px-4 py-2 text-[12.5px] font-bold text-blue-600 transition hover:bg-blue-100 disabled:opacity-60">
                                <svg x-show="!loading" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" class="h-3.5 w-3.5">
                                    <path d="M22 2 11 13" />
                                    <polygon points="22 2 15 22 11 13 2 9 22 2" />
                                </svg>
                                <svg x-show="loading" class="h-3.5 w-3.5 animate-spin" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                                </svg>
                                {{ __('config.smtp_test_btn') }}
                            </button>
                            <span x-show="result !== null" x-transition
                                :class="success ? 'text-green-600 bg-green-50 border-green-200' :
                                    'text-red-600 bg-red-50 border-red-200'"
                                class="inline-flex items-center gap-1.5 rounded-xl border px-3 py-1.5 text-[12px] font-semibold">
                                <svg x-show="success" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" class="h-3.5 w-3.5">
                                    <path d="m5 12 5 5L20 7" />
                                </svg>
                                <svg x-show="!success" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" class="h-3.5 w-3.5">
                                    <line x1="18" y1="6" x2="6" y2="18" />
                                    <line x1="6" y1="6" x2="18" y2="18" />
                                </svg>
                                <span x-text="result"></span>
                            </span>
                        </div>

                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-amber-400 px-5 py-2 text-[13px] font-bold text-slate-900 transition hover:bg-amber-300">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                class="h-3.5 w-3.5">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                <polyline points="17 21 17 13 7 13 7 21" />
                                <polyline points="7 3 7 8 15 8" />
                            </svg>
                            {{ __('config.smtp_save_btn') }}
                        </button>
                    </div>
                </form>
            </div>

            {{-- ══════════════════════════════════════
             WHATSAPP
        ══════════════════════════════════════ --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                {{-- Card header --}}
                <div class="flex items-center gap-3 border-b border-slate-100 px-6 py-4">
                    <span
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-green-50 text-green-500">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z" />
                        </svg>
                    </span>
                    <div>
                        <p class="text-[14px] font-bold text-slate-800">{{ __('config.wa_title') }}</p>
                        <p class="text-[12px] text-slate-400">{{ __('config.wa_subtitle') }}</p>
                    </div>
                </div>

                {{-- Two-column layout: info left, QR right --}}
                @php
                    $waStatus = [
                        'connected' => __('config.wa_status_connected'),
                        'waiting' => __('config.wa_status_waiting'),
                        'loading' => __('config.wa_status_loading'),
                        'error' => __('config.wa_status_error'),
                        'offline' => __('config.wa_status_offline'),
                    ];
                @endphp
                <div x-data="waQr()" x-init="init()"
                    style="display:flex;align-items:stretch;min-height:0;">

                    {{-- ── Left: status + instructions + actions (50%) ── --}}
                    <div
                        style="width:50%;flex:none;border-right:1px solid #f1f5f9;padding:18px 24px;display:flex;flex-direction:column;gap:14px;">

                        {{-- Status row --}}
                        <div
                            style="display:flex;align-items:center;gap:10px;background:#f8fafc;border:1px solid #f1f5f9;border-radius:12px;padding:10px 12px;">
                            <span
                                style="position:relative;flex:none;width:34px;height:34px;display:grid;place-items:center;background:#f0fdf4;border-radius:10px;color:#22c55e;">
                                <svg viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z" />
                                </svg>
                                <span x-show="status === 'connected'"
                                    style="position:absolute;top:-2px;right:-2px;width:10px;height:10px;border-radius:50%;border:2px solid #fff;background:#22c55e;"
                                    class="animate-pulse"></span>
                                <span x-show="status === 'waiting'"
                                    style="position:absolute;top:-2px;right:-2px;width:10px;height:10px;border-radius:50%;border:2px solid #fff;background:#f59e0b;"
                                    class="animate-pulse"></span>
                                <span x-show="status === 'error' || status === 'offline'"
                                    style="position:absolute;top:-2px;right:-2px;width:10px;height:10px;border-radius:50%;border:2px solid #fff;background:#ef4444;"></span>
                            </span>
                            <div>
                                <p style="font-size:13px;font-weight:700;color:#0f172a;margin:0;">WhatsApp</p>
                                <p style="font-size:11.5px;font-weight:600;margin:0;"
                                    :style="{
                                        color: status === 'connected' ? '#16a34a' : status === 'waiting' ?
                                            '#d97706' : (status === 'error' || status === 'offline') ? '#dc2626' :
                                            '#94a3b8'
                                    }"
                                    x-text="(@json($waStatus))[status] ?? status">
                                </p>
                            </div>
                        </div>

                        {{-- Instructions (waiting only) --}}
                        <template x-if="status === 'waiting'">
                            <ol style="margin:0;padding:0;list-style:none;display:flex;flex-direction:column;gap:8px;">
                                <li style="display:flex;align-items:center;gap:8px;">
                                    <span
                                        style="flex:none;width:18px;height:18px;border-radius:50%;background:#22c55e;color:#fff;font-size:9px;font-weight:900;display:grid;place-items:center;">1</span>
                                    <span style="font-size:11.5px;color:#475569;">{{ __('config.wa_step1') }}</span>
                                </li>
                                <li style="display:flex;align-items:center;gap:8px;">
                                    <span
                                        style="flex:none;width:18px;height:18px;border-radius:50%;background:#22c55e;color:#fff;font-size:9px;font-weight:900;display:grid;place-items:center;">2</span>
                                    <span style="font-size:11.5px;color:#475569;">{!! __('config.wa_step2') !!}</span>
                                </li>
                                <li style="display:flex;align-items:center;gap:8px;">
                                    <span
                                        style="flex:none;width:18px;height:18px;border-radius:50%;background:#22c55e;color:#fff;font-size:9px;font-weight:900;display:grid;place-items:center;">3</span>
                                    <span style="font-size:11.5px;color:#475569;">{!! __('config.wa_step3') !!}</span>
                                </li>
                                <li style="display:flex;align-items:center;gap:8px;">
                                    <span
                                        style="flex:none;width:18px;height:18px;border-radius:50%;background:#22c55e;color:#fff;font-size:9px;font-weight:900;display:grid;place-items:center;">4</span>
                                    <span style="font-size:11.5px;color:#475569;">{{ __('config.wa_step4') }}</span>
                                </li>
                            </ol>
                        </template>

                        {{-- Connected: info text --}}
                        <template x-if="status === 'connected'">
                            <p style="font-size:12px;color:#64748b;line-height:1.6;margin:0;">
                                {{ __('config.wa_connected_text') }}</p>
                        </template>

                        {{-- Spacer --}}
                        <div style="flex:1;"></div>

                        {{-- Test send (connected only) --}}
                        <div x-show="status === 'connected'">
                            <div x-data="waTest()" style="display:flex;flex-direction:column;gap:6px;">
                                <div style="display:flex;gap:6px;">
                                    <input type="text" x-model="phone"
                                        placeholder="{{ __('config.wa_test_ph') }}"
                                        style="flex:1;min-width:0;border:1px solid #e2e8f0;border-radius:10px;background:#f8fafc;padding:7px 12px;font-size:12px;font-weight:500;color:#0f172a;outline:none;">
                                    <button type="button" @click="run" :disabled="loading"
                                        style="flex:none;display:inline-flex;align-items:center;gap:4px;border:1px solid #bbf7d0;background:#f0fdf4;border-radius:10px;padding:7px 12px;font-size:11.5px;font-weight:700;color:#16a34a;cursor:pointer;">
                                        <svg x-show="!loading" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" style="width:12px;height:12px;">
                                            <path d="M22 2 11 13" />
                                            <polygon points="22 2 15 22 11 13 2 9 22 2" />
                                        </svg>
                                        <svg x-show="loading" style="width:12px;height:12px;" class="animate-spin"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                                        </svg>
                                        {{ __('config.wa_test_btn') }}
                                    </button>
                                </div>
                                <span x-show="result !== null" x-transition
                                    :style="success ? 'color:#15803d;background:#f0fdf4;border-color:#86efac;' :
                                        'color:#dc2626;background:#fef2f2;border-color:#fca5a5;'"
                                    style="display:inline-flex;align-items:center;gap:6px;border:1px solid;border-radius:10px;padding:6px 10px;font-size:11.5px;font-weight:600;">
                                    <svg x-show="success" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5" style="width:12px;height:12px;flex:none;">
                                        <path d="m5 12 5 5L20 7" />
                                    </svg>
                                    <svg x-show="!success" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5" style="width:12px;height:12px;flex:none;">
                                        <line x1="18" y1="6" x2="6" y2="18" />
                                        <line x1="6" y1="6" x2="18" y2="18" />
                                    </svg>
                                    <span x-text="result"
                                        style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"></span>
                                </span>
                            </div>
                        </div>

                        {{-- Disconnect button (connected only) --}}
                        <template x-if="status === 'connected'">
                            <button type="button" @click="disconnect" :disabled="disconnecting"
                                style="display:inline-flex;align-items:center;justify-content:center;gap:6px;width:100%;border:1px solid #fecaca;background:#fef2f2;border-radius:10px;padding:8px 14px;font-size:12.5px;font-weight:700;color:#dc2626;cursor:pointer;">
                                <svg x-show="!disconnecting" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" style="width:14px;height:14px;">
                                    <path d="M18.36 6.64A9 9 0 1 1 5.64 5.64" />
                                    <line x1="12" y1="2" x2="12" y2="12" />
                                </svg>
                                <svg x-show="disconnecting" style="width:14px;height:14px;" class="animate-spin"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                                </svg>
                                <span
                                    x-text="disconnecting ? @json(__('config.wa_disconnecting')) : @json(__('config.wa_disconnect'))"></span>
                            </button>
                        </template>

                        {{-- Retry (error/offline only) --}}
                        <template x-if="status === 'error' || status === 'offline'">
                            <button type="button" @click="poll()"
                                style="display:inline-flex;align-items:center;justify-content:center;gap:6px;width:100%;border:1px solid #e2e8f0;background:#f8fafc;border-radius:10px;padding:8px 14px;font-size:12.5px;font-weight:600;color:#475569;cursor:pointer;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    style="width:14px;height:14px;">
                                    <path d="M1 4v6h6" />
                                    <path d="M23 20v-6h-6" />
                                    <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4-4.64 4.36A9 9 0 0 1 3.51 15" />
                                </svg>
                                {{ __('config.wa_retry') }}
                            </button>
                        </template>

                    </div>

                    {{-- ── Right: QR display (50%) ── --}}
                    <div style="width:50%;display:flex;align-items:center;justify-content:center;padding:24px;">

                        {{-- Loading --}}
                        <template x-if="status === 'loading'">
                            <div
                                style="display:flex;flex-direction:column;align-items:center;gap:10px;text-align:center;">
                                <div
                                    style="width:168px;height:168px;border-radius:16px;border:2px dashed #e2e8f0;background:#f8fafc;display:grid;place-items:center;">
                                    <svg class="animate-spin" style="width:28px;height:28px;color:#cbd5e1;"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                                    </svg>
                                </div>
                                <p style="font-size:11.5px;color:#94a3b8;margin:0;">{{ __('config.wa_loading') }}</p>
                            </div>
                        </template>

                        {{-- QR waiting --}}
                        <template x-if="status === 'waiting'">
                            <div
                                style="display:flex;flex-direction:column;align-items:center;gap:10px;text-align:center;">
                                <template x-if="qr">
                                    <div>
                                        <div
                                            style="overflow:hidden;border-radius:16px;border:3px solid #4ade80;box-shadow:0 8px 24px -4px rgba(34,197,94,0.20);">
                                            <img :src="qr" alt="QR Code WhatsApp"
                                                style="display:block;width:200px;height:200px;object-fit:contain;">
                                        </div>
                                        <p style="margin-top:10px;font-size:11px;color:#94a3b8;">
                                            {!! __('config.wa_qr_refresh') !!}</p>
                                    </div>
                                </template>
                                <template x-if="!qr">
                                    <div
                                        style="width:200px;height:200px;border-radius:16px;border:2px dashed #bbf7d0;background:#f0fdf4;display:grid;place-items:center;">
                                        <svg class="animate-spin" style="width:24px;height:24px;color:#86efac;"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                                        </svg>
                                    </div>
                                </template>
                            </div>
                        </template>

                        {{-- Connected --}}
                        <template x-if="status === 'connected'">
                            <div
                                style="display:flex;flex-direction:column;align-items:center;gap:12px;text-align:center;">
                                <div
                                    style="width:80px;height:80px;border-radius:50%;background:#dcfce7;color:#22c55e;display:grid;place-items:center;box-shadow:0 4px 20px rgba(34,197,94,0.15);">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                        style="width:36px;height:36px;">
                                        <path d="m5 12 5 5L20 7" />
                                    </svg>
                                </div>
                                <div>
                                    <p style="font-size:15px;font-weight:800;color:#0f172a;margin:0;">
                                        {{ __('config.wa_connected_title') }}</p>
                                    <p style="margin-top:4px;font-size:12px;color:#94a3b8;">
                                        {{ __('config.wa_connected_sub') }}</p>
                                </div>
                            </div>
                        </template>

                        {{-- Error / offline --}}
                        <template x-if="status === 'error' || status === 'offline'">
                            <div
                                style="display:flex;flex-direction:column;align-items:center;gap:12px;text-align:center;">
                                <div
                                    style="width:72px;height:72px;border-radius:50%;background:#fef2f2;color:#f87171;display:grid;place-items:center;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        style="width:32px;height:32px;">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" y1="8" x2="12" y2="12" />
                                        <line x1="12" y1="16" x2="12.01" y2="16" />
                                    </svg>
                                </div>
                                <div>
                                    <p style="font-size:13px;font-weight:700;color:#334155;margin:0;">
                                        {{ __('config.wa_service_down') }}</p>
                                    <p style="margin-top:4px;font-size:11.5px;color:#94a3b8;max-width:200px;"
                                        x-text="errorMsg || @json(__('config.wa_service_unavailable'))"></p>
                                </div>
                            </div>
                        </template>

                    </div>

                </div>
            </div>

        </div>

        <script>
            function togglePwd(id, btn) {
                const input = document.getElementById(id);
                input.type = input.type === 'password' ? 'text' : 'password';
            }

            function smtpTest() {
                return {
                    email: '',
                    loading: false,
                    result: null,
                    success: false,
                    async run() {
                        if (!this.email) return;
                        this.loading = true;
                        this.result = null;
                        try {
                            const r = await fetch('{{ route('config.canaux.smtp.test') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({
                                    email: this.email
                                }),
                            });
                            const d = await r.json();
                            this.success = d.ok === true;
                            this.result = d.message ?? (d.ok ? @json(__('config.smtp_test_sent')) : @json(__('config.smtp_test_failed')));
                        } catch (e) {
                            this.success = false;
                            this.result = @json(__('config.smtp_test_network'));
                        } finally {
                            this.loading = false;
                        }
                    }
                };
            }

            function waTest() {
                return {
                    phone: '',
                    loading: false,
                    result: null,
                    success: false,
                    async run() {
                        if (!this.phone) return;
                        this.loading = true;
                        this.result = null;
                        try {
                            const r = await fetch('{{ route('config.canaux.whatsapp.test') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({
                                    phone: this.phone
                                }),
                            });
                            const d = await r.json();
                            this.success = d.ok === true;
                            this.result = d.message ?? (d.ok ? @json(__('config.wa_test_sent')) : @json(__('config.wa_test_failed')));
                        } catch (e) {
                            this.success = false;
                            this.result = @json(__('config.wa_test_network'));
                        } finally {
                            this.loading = false;
                        }
                    }
                };
            }

            function waQr() {
                return {
                    status: 'loading', // loading | waiting | connected | error | offline
                    qr: null,
                    errorMsg: '',
                    disconnecting: false,
                    _timer: null,

                    init() {
                        this.poll();
                    },

                    async poll() {
                        try {
                            const r = await fetch('{{ route('config.canaux.whatsapp.qr') }}', {
                                headers: {
                                    'Accept': 'application/json'
                                }
                            });
                            const d = await r.json();

                            if (d.status === 'connected') {
                                this.status = 'connected';
                                this.qr = null;
                                return; // stop polling
                            }

                            if (d.status === 'waiting') {
                                this.status = 'waiting';
                                this.qr = d.qr ?? null;
                            } else {
                                this.status = 'error';
                                this.errorMsg = d.message ?? '';
                            }
                        } catch (e) {
                            this.status = 'offline';
                            this.errorMsg = e.message ?? '';
                        }

                        // Re-poll every 5s unless connected
                        clearTimeout(this._timer);
                        this._timer = setTimeout(() => this.poll(), 5000);
                    },

                    async disconnect() {
                        if (this.disconnecting) return;
                        this.disconnecting = true;
                        try {
                            await fetch('{{ route('config.canaux.whatsapp.disconnect') }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                    'Accept': 'application/json',
                                },
                            });
                        } catch (_) {}
                        this.disconnecting = false;
                        this.status = 'loading';
                        this.qr = null;
                        clearTimeout(this._timer);
                        this.poll();
                    },
                };
            }
        </script>

        </x-config-layout>
