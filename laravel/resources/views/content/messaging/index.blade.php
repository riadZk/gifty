<x-app-layout>

    <style>
        /* ── Stat cards (light, distinct from other pages) ── */
        .m-stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        @media (max-width:1024px) {
            .m-stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width:560px) {
            .m-stat-grid {
                grid-template-columns: 1fr;
            }
        }

        .m-stat {
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            border-radius: 18px;
            padding: 18px;
            border: 1px solid transparent;
            transition: transform .18s, box-shadow .18s;
        }

        .m-stat:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 32px -18px rgba(15, 23, 42, .45);
        }

        .m-stat .ic {
            width: 46px;
            height: 46px;
            border-radius: 13px;
            display: grid;
            place-items: center;
            color: #fff;
            margin-bottom: 16px;
            box-shadow: 0 8px 16px -6px rgba(15, 23, 42, .35);
        }

        .m-stat .meta {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .m-stat .val {
            font-size: 27px;
            font-weight: 900;
            line-height: 1;
            letter-spacing: -.02em;
        }

        .m-stat .lab {
            font-size: 12px;
            font-weight: 700;
            color: #64748b;
            margin-top: 8px;
        }

        .s-blue {
            background: #eff6ff;
            border-color: #dbeafe;
        }

        .s-blue .ic {
            background: #3b82f6;
        }

        .s-blue .val {
            color: #1d4ed8;
        }

        .s-green {
            background: #ecfdf5;
            border-color: #d1fae5;
        }

        .s-green .ic {
            background: #10b981;
        }

        .s-green .val {
            color: #047857;
        }

        .s-violet {
            background: #f5f3ff;
            border-color: #ede9fe;
        }

        .s-violet .ic {
            background: #8b5cf6;
        }

        .s-violet .val {
            color: #6d28d9;
        }

        .s-amber {
            background: #fffbeb;
            border-color: #fef3c7;
        }

        .s-amber .ic {
            background: #f59e0b;
        }

        .s-amber .val {
            color: #b45309;
        }

        /* ── Panel ── */
        .m-panel {
            background: #fff;
            border: 1px solid #eef2f7;
            border-radius: 18px;
            box-shadow: 0 1px 2px rgba(15, 23, 42, .04), 0 8px 24px -16px rgba(15, 23, 42, .25);
        }

        .m-label {
            display: block;
            font-size: 11px;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: .05em;
            margin-bottom: 8px;
        }

        .m-input,
        .m-textarea {
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 11px 14px;
            font-size: 13.5px;
            color: #0f172a;
            outline: none;
            transition: all .15s;
            background: #fff;
            font-family: inherit;
        }

        .m-input:focus,
        .m-textarea:focus {
            border-color: #FFC60B;
            box-shadow: 0 0 0 4px rgba(255, 198, 11, .16);
        }

        .m-textarea {
            resize: vertical;
            min-height: 130px;
            line-height: 1.6;
        }

        /* ── Channel cards ── */
        .ch-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        @media (max-width:560px) {
            .ch-grid {
                grid-template-columns: 1fr;
            }
        }

        .ch-card {
            position: relative;
            cursor: pointer;
            border: 1.5px solid #e8edf4;
            border-radius: 14px;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: border-color .15s, background .15s, box-shadow .15s;
        }

        .ch-card:hover {
            border-color: #cbd5e1;
        }

        .ch-card input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .ch-card .ch-ic {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
        }

        .ch-card .ch-name {
            font-size: 13.5px;
            font-weight: 800;
            color: #0f172a;
        }

        .ch-card .ch-sub {
            font-size: 11px;
            font-weight: 600;
            color: #94a3b8;
            margin-top: 1px;
        }

        .ch-card .ch-check {
            margin-left: auto;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            border: 2px solid #cbd5e1;
            display: grid;
            place-items: center;
            transition: all .15s;
            flex-shrink: 0;
        }

        .ch-card .ch-check svg {
            width: 12px;
            height: 12px;
            opacity: 0;
            transition: opacity .15s;
        }

        .ch-card.sel {
            border-color: #FFC60B;
            background: #fffdf5;
            box-shadow: 0 0 0 3px rgba(255, 198, 11, .14);
        }

        .ch-card.sel .ch-check {
            border-color: #f59e0b;
            background: #f59e0b;
        }

        .ch-card.sel .ch-check svg {
            opacity: 1;
        }

        .m-counter {
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
        }

        /* ── Preview ── */
        .preview-box {
            border: 1px dashed #e2e8f0;
            border-radius: 14px;
            padding: 16px;
            background: #f8fafc;
        }
    </style>

    <div class="flex flex-col gap-6">

        {{-- Header --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div class="flex flex-col gap-1">
                <nav class="flex items-center gap-1.5 text-[11.5px] font-semibold text-slate-400">
                    <span>{{ __('messaging.breadcrumb_communication') }}</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3 w-3">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                    <span class="text-slate-700">{{ __('messaging.compose_breadcrumb') }}</span>
                </nav>
                <h1 class="text-[26px] font-black tracking-tight text-slate-900">{{ __('messaging.compose_title') }}
                </h1>
                <p class="text-[13px] text-slate-500">{{ __('messaging.compose_subtitle') }}</p>
            </div>
            <a href="{{ route('messaging.history') }}"
                class="inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 text-[13.5px] font-extrabold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
                    <path d="M3 3v5h5" />
                    <path d="M3.05 13A9 9 0 1 0 6 5.3L3 8" />
                    <path d="M12 7v5l4 2" />
                </svg>
                {{ __('messaging.btn_history') }}
            </a>
        </div>

        {{-- Flash --}}
        @if (session('success'))
            <div role="status"
                class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-3 text-[13px] font-semibold text-emerald-700">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                    class="mt-0.5 h-4 w-4 shrink-0">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div role="alert"
                class="flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 px-5 py-3 text-[13px] font-semibold text-red-700">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                    class="mt-0.5 h-4 w-4 shrink-0">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        {{-- Stat cards --}}
        <div class="m-stat-grid">
            <div class="m-stat s-blue">
                <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
                        class="h-5 w-5">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg></div>
                <div class="meta">
                    <div class="val">{{ number_format($stats['total']) }}</div>
                    <div class="lab">{{ __('messaging.stat_total_clients') }}</div>
                </div>
            </div>
            <div class="m-stat s-green">
                <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
                        class="h-5 w-5">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                        <polyline points="22,6 12,13 2,6" />
                    </svg></div>
                <div class="meta">
                    <div class="val">{{ number_format($stats['withEmail']) }}</div>
                    <div class="lab">{{ __('messaging.stat_with_email') }}</div>
                </div>
            </div>
            <div class="m-stat s-violet">
                <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
                        class="h-5 w-5">
                        <path
                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                    </svg></div>
                <div class="meta">
                    <div class="val">{{ number_format($stats['withPhone']) }}</div>
                    <div class="lab">{{ __('messaging.stat_with_phone') }}</div>
                </div>
            </div>
            <div class="m-stat s-amber">
                <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
                        class="h-5 w-5">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg></div>
                <div class="meta">
                    <div class="val">{{ number_format($stats['active']) }}</div>
                    <div class="lab">{{ __('messaging.stat_active_clients') }}</div>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('messaging.send') }}" id="msg-form"
            class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            @csrf

            {{-- Left: composition --}}
            <div class="lg:col-span-2 flex flex-col gap-5">

                {{-- Recipients --}}
                <div class="m-panel p-5">
                    <div class="flex items-center justify-between">
                        <span class="m-label !mb-0">{{ __('messaging.label_recipients') }}</span>
                        <div class="flex items-center gap-3">
                            <button type="button" id="select-all"
                                class="text-[11.5px] font-bold text-amber-600 hover:underline">{{ __('messaging.btn_select_all') }}</button>
                            <button type="button" id="select-none"
                                class="text-[11.5px] font-bold text-slate-400 hover:underline">{{ __('messaging.btn_select_none') }}</button>
                        </div>
                    </div>
                    <div class="mt-3">
                        <x-select2 name="client_ids[]" id="client_ids" :multiple="true"
                            placeholder="{{ __('messaging.placeholder_clients') }}" :options="$clients
                                ->mapWithKeys(
                                    fn($c) => [
                                        $c->id => $c->company_name . ($c->contact_name ? ' — ' . $c->contact_name : ''),
                                    ],
                                )
                                ->all()"
                            wrapperClass="!mb-0" />
                    </div>
                    <p class="mt-2 m-counter"><span id="recipient-count">0</span>
                        {{ __('messaging.recipients_count') }}</p>
                </div>

                {{-- Channels --}}
                <div class="m-panel p-5">
                    <span class="m-label">{{ __('messaging.label_channels') }}</span>
                    <div class="ch-grid">
                        <label class="ch-card" data-channel="push">
                            <input type="checkbox" name="channels[]" value="push">
                            <span class="ch-ic" style="background:#eff6ff;color:#2563eb;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
                                    class="h-5 w-5">
                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                                    <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                                </svg>
                            </span>
                            <span>
                                <span class="ch-name">{{ __('messaging.channel_push_name') }}</span>
                                <span class="ch-sub block">{{ __('messaging.channel_push_sub') }}</span>
                            </span>
                            <span class="ch-check"><svg viewBox="0 0 24 24" fill="none" stroke="#fff"
                                    stroke-width="3.5">
                                    <path d="m5 12 5 5L20 7" />
                                </svg></span>
                        </label>

                        <label class="ch-card" data-channel="mail">
                            <input type="checkbox" name="channels[]" value="mail">
                            <span class="ch-ic" style="background:#f5f3ff;color:#7c3aed;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
                                    class="h-5 w-5">
                                    <rect x="2" y="4" width="20" height="16" rx="2" />
                                    <path d="m22 7-10 5L2 7" />
                                </svg>
                            </span>
                            <span>
                                <span class="ch-name">{{ __('messaging.channel_email_name') }}</span>
                                <span
                                    class="ch-sub block">{{ str_replace(':count', $stats['withEmail'], __('messaging.channel_reachable')) }}</span>
                            </span>
                            <span class="ch-check"><svg viewBox="0 0 24 24" fill="none" stroke="#fff"
                                    stroke-width="3.5">
                                    <path d="m5 12 5 5L20 7" />
                                </svg></span>
                        </label>

                        <label class="ch-card" data-channel="whatsapp">
                            <input type="checkbox" name="channels[]" value="whatsapp">
                            <span class="ch-ic" style="background:#ecfdf5;color:#059669;">
                                <svg viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                    <path
                                        d="M17.5 14.4c-.3-.1-1.7-.8-1.9-.9-.3-.1-.5-.1-.6.1-.2.3-.7.9-.8 1-.2.2-.3.2-.6.1-.3-.1-1.2-.4-2.2-1.4-.8-.7-1.4-1.6-1.5-1.9-.2-.3 0-.4.1-.6.1-.1.3-.3.4-.5.1-.1.2-.3.3-.4.1-.2 0-.3 0-.5 0-.1-.6-1.5-.8-2-.2-.5-.5-.5-.6-.5h-.5c-.2 0-.5.1-.7.3-.3.3-1 .9-1 2.3s1 2.7 1.2 2.9c.1.2 2 3 4.8 4.2.7.3 1.2.5 1.6.6.7.2 1.3.2 1.8.1.5-.1 1.7-.7 1.9-1.4.2-.7.2-1.2.2-1.4-.1-.1-.3-.2-.6-.3zM12 2a10 10 0 0 0-8.7 15l-1.3 4.7 4.8-1.3A10 10 0 1 0 12 2z" />
                                </svg>
                            </span>
                            <span>
                                <span class="ch-name">{{ __('messaging.channel_whatsapp_name') }}</span>
                                <span
                                    class="ch-sub block">{{ str_replace(':count', $stats['withPhone'], __('messaging.channel_reachable')) }}</span>
                            </span>
                            <span class="ch-check"><svg viewBox="0 0 24 24" fill="none" stroke="#fff"
                                    stroke-width="3.5">
                                    <path d="m5 12 5 5L20 7" />
                                </svg></span>
                        </label>
                    </div>
                </div>

                {{-- Message --}}
                <div class="m-panel p-5 flex flex-col gap-4">
                    <div>
                        <span class="m-label">{{ __('messaging.label_title') }}</span>
                        <input type="text" name="title" id="title" class="m-input" maxlength="150"
                            placeholder="{{ __('messaging.placeholder_title') }}" value="{{ old('title') }}"
                            required>
                    </div>
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="m-label">{{ __('messaging.label_message') }}</span>
                            <span class="m-counter"><span id="msg-count">0</span>/2000</span>
                        </div>
                        <textarea name="message" id="message" class="m-textarea" maxlength="2000"
                            placeholder="{{ __('messaging.placeholder_message') }}" required>{{ old('message') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Right: preview + submit --}}
            <div class="flex flex-col gap-5">
                <div class="m-panel p-5 lg:sticky lg:top-6">
                    <span class="m-label">{{ __('messaging.label_preview') }}</span>
                    <div class="preview-box">
                        <div class="flex items-start gap-3">
                            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-amber-100">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="1.9"
                                    class="h-4 w-4">
                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                                    <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                                </svg>
                            </span>
                            <div class="min-w-0 flex-1">
                                <p id="preview-title" class="text-[13.5px] font-bold text-slate-900 break-words">
                                    {{ __('messaging.preview_default_title') }}</p>
                                <p id="preview-body"
                                    class="mt-1 text-[12.5px] text-slate-500 break-words whitespace-pre-line">
                                    {{ __('messaging.preview_default_body') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-2" id="preview-channels">
                        <span
                            class="text-[11.5px] font-semibold text-slate-400">{{ __('messaging.preview_no_channel') }}</span>
                    </div>

                    <button type="submit" id="submit-btn"
                        class="mt-5 inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-amber-400 text-[13.5px] font-extrabold text-slate-900 shadow-sm transition hover:bg-amber-500 disabled:cursor-not-allowed disabled:opacity-50">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            class="h-4 w-4">
                            <line x1="22" y1="2" x2="11" y2="13" />
                            <polygon points="22 2 15 22 11 13 2 9 22 2" />
                        </svg>
                        {{ __('messaging.btn_send') }}
                    </button>
                    <p class="mt-2 text-center text-[11px] text-slate-400">{{ __('messaging.send_hint') }}
                    </p>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            (function() {
                const form = document.getElementById('msg-form');
                const titleEl = document.getElementById('title');
                const messageEl = document.getElementById('message');
                const previewT = document.getElementById('preview-title');
                const previewB = document.getElementById('preview-body');
                const previewCh = document.getElementById('preview-channels');
                const msgCount = document.getElementById('msg-count');
                const recipCount = document.getElementById('recipient-count');
                const submitBtn = document.getElementById('submit-btn');
                const $clients = window.jQuery ? jQuery('#client_ids') : null;

                const CH_LABELS = {
                    push: {
                        name: 'Push',
                        bg: '#eff6ff',
                        color: '#2563eb'
                    },
                    mail: {
                        name: 'E-mail',
                        bg: '#f5f3ff',
                        color: '#7c3aed'
                    },
                    whatsapp: {
                        name: 'WhatsApp',
                        bg: '#ecfdf5',
                        color: '#059669'
                    },
                };

                function selectedChannels() {
                    return [...document.querySelectorAll('input[name="channels[]"]:checked')].map(i => i.value);
                }

                function selectedClientCount() {
                    return $clients ? ($clients.val() || []).length :
                        document.querySelectorAll('#client_ids option:checked').length;
                }

                function updatePreview() {
                    previewT.textContent = titleEl.value.trim() || '{{ __('messaging.preview_default_title') }}';
                    previewB.textContent = messageEl.value.trim() || '{{ __('messaging.preview_default_body') }}';
                    msgCount.textContent = messageEl.value.length;

                    const chs = selectedChannels();
                    if (chs.length === 0) {
                        previewCh.innerHTML =
                            '<span class="text-[11.5px] font-semibold text-slate-400">{{ __('messaging.preview_no_channel') }}</span>';
                    } else {
                        previewCh.innerHTML = chs.map(c => {
                            const m = CH_LABELS[c];
                            return `<span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[11.5px] font-bold" style="background:${m.bg};color:${m.color}">${m.name}</span>`;
                        }).join('');
                    }

                    recipCount.textContent = selectedClientCount();
                    refreshSubmit();
                }

                function refreshSubmit() {
                    const ok = titleEl.value.trim() && messageEl.value.trim() &&
                        selectedChannels().length > 0 && selectedClientCount() > 0;
                    submitBtn.disabled = !ok;
                }

                // Channel card toggle visual
                document.querySelectorAll('.ch-card').forEach(card => {
                    const input = card.querySelector('input');
                    const sync = () => card.classList.toggle('sel', input.checked);
                    input.addEventListener('change', () => {
                        sync();
                        updatePreview();
                    });
                    sync();
                });

                titleEl.addEventListener('input', updatePreview);
                messageEl.addEventListener('input', updatePreview);

                // Select2 change
                if ($clients) {
                    $clients.on('change', updatePreview);
                } else {
                    document.getElementById('client_ids').addEventListener('change', updatePreview);
                }

                // Quick select all / none
                document.getElementById('select-all').addEventListener('click', () => {
                    const sel = document.getElementById('client_ids');
                    [...sel.options].forEach(o => o.selected = true);
                    if ($clients) $clients.trigger('change');
                    else updatePreview();
                });
                document.getElementById('select-none').addEventListener('click', () => {
                    const sel = document.getElementById('client_ids');
                    [...sel.options].forEach(o => o.selected = false);
                    if ($clients) $clients.val(null).trigger('change');
                    else updatePreview();
                });

                updatePreview();
            })();
        </script>
    @endpush

</x-app-layout>
