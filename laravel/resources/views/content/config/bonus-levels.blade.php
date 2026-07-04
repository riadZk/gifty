<x-app-layout>

    <style>
        /* ── Premium modal ── */
        .pcc-modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 60;
            background: rgba(15, 23, 42, .5);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .pcc-modal {
            background: #fff;
            border-radius: 22px;
            width: 100%;
            max-width: 540px;
            box-shadow: 0 30px 70px -15px rgba(15, 23, 42, .4);
            animation: modalIn .22s cubic-bezier(.2, .8, .3, 1);
            max-height: 90vh;
            overflow-y: auto;
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: scale(.95) translateY(10px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .pcc-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 22px 26px 18px;
            border-bottom: 1px solid #f1f5f9;
        }

        .pcc-modal-body {
            padding: 22px 26px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .pcc-modal-footer {
            padding: 18px 26px;
            border-top: 1px solid #f1f5f9;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .pcc-field label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .pcc-field input,
        .pcc-field textarea {
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 11px;
            padding: 10px 13px;
            font-size: 13px;
            color: #0f172a;
            outline: none;
            transition: all .15s;
            background: #fff;
            font-family: inherit;
        }

        .pcc-field input:focus,
        .pcc-field textarea:focus {
            border-color: #FFC60B;
            box-shadow: 0 0 0 4px rgba(255, 198, 11, .16);
        }

        .pcc-field textarea {
            resize: vertical;
            min-height: 76px;
        }

        .pcc-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            height: 40px;
            padding: 0 20px;
            border-radius: 12px;
            background: #FFC60B;
            color: #101820;
            font-size: 13px;
            font-weight: 800;
            border: none;
            cursor: pointer;
            transition: background .15s;
        }

        .pcc-btn-primary:hover {
            background: #f0b800;
        }

        .pcc-btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            height: 40px;
            padding: 0 20px;
            border-radius: 12px;
            background: #f1f5f9;
            color: #475569;
            font-size: 13px;
            font-weight: 800;
            border: none;
            cursor: pointer;
            transition: background .15s;
        }

        .pcc-btn-secondary:hover {
            background: #e2e8f0;
        }

        /* Image dropzone */
        .img-drop {
            border: 2px dashed #e2e8f0;
            border-radius: 13px;
            padding: 20px;
            cursor: pointer;
            transition: all .18s;
            background: #fafafa;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100px;
        }

        .img-drop:hover,
        .img-drop.drag {
            border-color: #FFC60B;
            background: #fffbeb;
        }

        .img-drop input[type=file] {
            display: none;
        }

        .img-preview {
            position: relative;
            display: inline-block;
        }

        .img-preview img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            display: block;
        }

        .img-remove {
            position: absolute;
            top: -7px;
            right: -7px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #ef4444;
            color: #fff;
            border: none;
            cursor: pointer;
            display: grid;
            place-items: center;
            font-size: 12px;
            font-weight: 900;
            line-height: 1;
        }
    </style>

    <div class="mx-auto max-w-[110rem] flex gap-6">

        {{-- Sidebar --}}
        @include('content.config._sidebar')

        {{-- Main --}}
        <div class="min-w-0 flex-1 flex flex-col gap-5">

            {{-- Header --}}
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <nav class="flex items-center gap-1.5 text-[11.5px] font-medium text-slate-400">
                        <span>{{ __('config.breadcrumb') }}</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3 w-3">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                        <span class="text-slate-600">{{ __('config.levels_page_title') }}</span>
                    </nav>
                    <h1 class="mt-1 text-[22px] font-black tracking-tight text-slate-900">
                        {{ __('config.levels_page_title') }}</h1>
                </div>
                <button type="button" onclick="openModal()"
                    class="inline-flex h-9 items-center gap-2 rounded-xl bg-amber-400 px-4 text-[12.5px] font-bold text-slate-900 shadow-sm transition hover:bg-amber-500">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    {{ __('config.levels_add_btn') }}
                </button>
            </div>

            {{-- Levels list --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                @forelse ($levels as $level)
                    <div class="flex items-center gap-4 border-b border-slate-100 px-5 py-4 last:border-0">
                        {{-- Image / icon --}}
                        @if ($level->image)
                            <img src="{{ $level->image }}" class="h-11 w-11 rounded-xl object-cover shadow-sm"
                                alt="">
                        @else
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-100">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="1.8"
                                    class="h-5 w-5">
                                    <polyline points="20 12 20 22 4 22 4 12" />
                                    <rect x="2" y="7" width="20" height="5" />
                                    <line x1="12" y1="22" x2="12" y2="7" />
                                </svg>
                            </span>
                        @endif

                        {{-- Info --}}
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-[14px] font-bold text-slate-900">{{ $level->name }}</span>
                                @if ($level->is_active)
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 text-[11px] font-bold text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        {{ __('config.levels_active') }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2 py-0.5 text-[11px] font-bold text-slate-500">
                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                        {{ __('config.levels_inactive') }}
                                    </span>
                                @endif
                            </div>
                            <p class="mt-0.5 text-[12.5px] text-slate-500">
                                <span
                                    class="font-semibold text-amber-600">{{ number_format((int) $level->required_points, 0, ',', ' ') }}
                                    pts</span>
                                {{ __('config.levels_pts_required') }} &nbsp;·&nbsp; {{ $level->reward_name }}
                            </p>
                            @if ($level->reward_description)
                                <p class="mt-0.5 text-[12px] text-slate-400">{{ $level->reward_description }}</p>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-2">
                            <button type="button"
                                onclick="openModal({{ json_encode(['id' => $level->id, 'name' => $level->name, 'required_points' => $level->required_points, 'reward_name' => $level->reward_name, 'reward_description' => $level->reward_description, 'is_active' => $level->is_active, 'sort_order' => $level->sort_order]) }})"
                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:bg-slate-50">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                    class="h-4 w-4">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                            </button>
                            <button type="button"
                                onclick="deleteLevel({{ $level->id }}, '{{ addslashes($level->name) }}')"
                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-red-100 text-red-400 transition hover:bg-red-50">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                    class="h-4 w-4">
                                    <polyline points="3 6 5 6 21 6" />
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                    <path d="M10 11v6M14 11v6" />
                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center gap-2 py-12 text-center">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="1.6" class="h-6 w-6">
                                <polyline points="20 12 20 22 4 22 4 12" />
                                <rect x="2" y="7" width="20" height="5" />
                            </svg>
                        </span>
                        <p class="text-[13px] font-semibold text-slate-500">{{ __('config.levels_empty_title') }}</p>
                        <p class="text-[12px] text-slate-400">{{ __('config.levels_empty_sub') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ══ Add/Edit modal ══ --}}
    <div id="level-modal" class="pcc-modal-backdrop" style="display:none;">
        <div class="pcc-modal">
            <div class="pcc-modal-header">
                <span id="modal-title"
                    class="text-[16px] font-black text-slate-900">{{ __('config.levels_modal_add') }}</span>
                <button type="button" onclick="closeModal()"
                    class="grid h-8 w-8 place-items-center rounded-full hover:bg-slate-100 text-slate-400 transition">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" class="h-4 w-4">
                        <path d="M18 6 6 18M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="level-form" class="contents">
                @csrf
                <input type="hidden" id="level-id" name="_level_id" value="">
                <div class="pcc-modal-body">

                    {{-- Bonus Name --}}
                    <div class="pcc-field">
                        <label>{{ __('config.levels_field_name') }}</label>
                        <input type="text" id="f-name" name="name" required maxlength="100"
                            placeholder="{{ __('config.levels_field_name_ph') }}">
                    </div>

                    {{-- Points + Sort --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="pcc-field">
                            <label>{{ __('config.levels_field_pts') }}</label>
                            <input type="number" id="f-pts" name="required_points" min="0"
                                step="1" required>
                        </div>
                        <div class="pcc-field">
                            <label>{{ __('config.levels_field_sort') }}</label>
                            <input type="number" id="f-sort" name="sort_order" min="0" value="0">
                        </div>
                    </div>

                    {{-- Reward Name --}}
                    <div class="pcc-field">
                        <label>{{ __('config.levels_field_reward') }}</label>
                        <input type="text" id="f-reward" name="reward_name" required maxlength="255"
                            placeholder="{{ __('config.levels_field_reward_ph') }}">
                    </div>

                    {{-- Image dropzone --}}
                    <div class="pcc-field">
                        <label>{{ __('config.levels_field_image') }}</label>
                        <div class="img-drop" id="f-img-drop" onclick="document.getElementById('f-image').click()">
                            <input type="file" id="f-image" name="image"
                                accept="image/jpeg,image/png,image/webp,image/gif">
                            <div id="f-img-placeholder">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5"
                                    class="h-8 w-8 mx-auto mb-2">
                                    <rect x="3" y="3" width="18" height="18" rx="2" />
                                    <circle cx="8.5" cy="8.5" r="1.5" />
                                    <polyline points="21 15 16 10 5 21" />
                                </svg>
                                <p class="text-[12px] font-semibold text-slate-400">
                                    {{ __('config.levels_img_click') }}</p>
                                <p class="text-[11px] text-slate-300 mt-0.5">{{ __('config.levels_img_types') }}</p>
                            </div>
                            <div id="f-img-preview" class="img-preview" style="display:none;">
                                <img id="f-img-thumb" src="" alt="Preview">
                                <button type="button" class="img-remove" id="f-img-remove"
                                    onclick="event.stopPropagation();clearImage()" title="Remove">×</button>
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="pcc-field">
                        <label>{{ __('config.levels_field_desc') }}</label>
                        <textarea id="f-desc" name="reward_description" placeholder="{{ __('config.levels_field_desc_ph') }}"></textarea>
                    </div>

                    {{-- Active checkbox --}}
                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="f-active" name="is_active" value="1" checked
                            class="h-4 w-4 rounded accent-[#FFC60B]">
                        <label for="f-active"
                            class="text-[13px] font-semibold text-slate-700">{{ __('config.levels_field_active') }}</label>
                    </div>
                </div>

                <div class="pcc-modal-footer">
                    <button type="button" onclick="closeModal()"
                        class="pcc-btn-secondary">{{ __('config.btn_cancel') }}</button>
                    <button type="submit" class="pcc-btn-primary">
                        <span id="modal-btn-txt">{{ __('config.levels_btn_save') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @php
        $levelsJs = [
            'modal_add' => __('config.levels_modal_add'),
            'modal_edit' => __('config.levels_modal_edit'),
            'btn_save' => __('config.levels_btn_save'),
            'swal_success' => __('config.levels_swal_success'),
            'swal_saved' => __('config.levels_swal_saved'),
            'swal_error' => __('config.levels_swal_error'),
            'delete_title' => __('config.levels_delete_title'),
            'delete_text' => __('config.levels_delete_text'),
            'delete_btn' => __('config.levels_delete_btn'),
            'cancel_btn' => __('config.levels_cancel_btn'),
            'deleted_title' => __('config.levels_deleted_title'),
            'deleted_text' => __('config.levels_deleted_text'),
            'delete_error' => __('config.levels_delete_error'),
        ];
    @endphp
    <script>
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
        const modal = document.getElementById('level-modal');
        const t = @json($levelsJs);

        function openModal(level = null) {
            document.getElementById('level-id').value = level ? level.id : '';
            document.getElementById('modal-title').textContent = level ? t.modal_edit : t.modal_add;
            document.getElementById('modal-btn-txt').textContent = t.btn_save;
            document.getElementById('f-name').value = level?.name ?? '';
            document.getElementById('f-pts').value = level?.required_points ?? '';
            document.getElementById('f-reward').value = level?.reward_name ?? '';
            document.getElementById('f-desc').value = level?.reward_description ?? '';
            document.getElementById('f-sort').value = level?.sort_order ?? 0;
            document.getElementById('f-active').checked = level ? !!level.is_active : true;
            // Reset image dropzone
            clearImage();
            modal.style.display = 'flex';
        }

        function closeModal() {
            modal.style.display = 'none';
        }

        modal.addEventListener('click', e => {
            if (e.target === modal) closeModal();
        });

        // Image preview
        document.getElementById('f-image').addEventListener('change', function() {
            if (!this.files[0]) return;
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('f-img-thumb').src = e.target.result;
                document.getElementById('f-img-placeholder').style.display = 'none';
                document.getElementById('f-img-preview').style.display = 'inline-block';
            };
            reader.readAsDataURL(this.files[0]);
        });

        function clearImage() {
            document.getElementById('f-image').value = '';
            document.getElementById('f-img-thumb').src = '';
            document.getElementById('f-img-preview').style.display = 'none';
            document.getElementById('f-img-placeholder').style.display = '';
        }

        // Drag-and-drop on dropzone
        const dropEl = document.getElementById('f-img-drop');
        ['dragover', 'dragenter'].forEach(ev => dropEl.addEventListener(ev, e => {
            e.preventDefault();
            dropEl.classList.add('drag');
        }));
        ['dragleave', 'drop'].forEach(ev => dropEl.addEventListener(ev, e => {
            e.preventDefault();
            dropEl.classList.remove('drag');
        }));
        dropEl.addEventListener('drop', e => {
            const file = e.dataTransfer.files[0];
            if (!file) return;
            const dt = new DataTransfer();
            dt.items.add(file);
            document.getElementById('f-image').files = dt.files;
            document.getElementById('f-image').dispatchEvent(new Event('change'));
        });

        document.getElementById('level-form').addEventListener('submit', async e => {
            e.preventDefault();
            const fd = new FormData(e.target);
            const id = fd.get('_level_id');
            fd.delete('_level_id');
            if (!fd.get('is_active')) fd.set('is_active', '0');
            const url = id ?
                '{{ url('/loyalty/levels') }}/' + id :
                '{{ route('loyalty.levels.store') }}';
            if (id) fd.append('_method', 'PUT');
            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                },
                body: fd,
            });
            const data = await res.json();
            if (res.ok) {
                closeModal();
                Swal.fire({
                    icon: 'success',
                    title: t.swal_success,
                    text: data.message ?? t.swal_saved,
                    confirmButtonColor: '#FFC60B',
                    timer: 1800,
                    showConfirmButton: false
                });
                setTimeout(() => location.reload(), 1900);
            } else {
                const errors = data.errors ?
                    Object.values(data.errors).flat().join('\n') :
                    (data.message ?? t.swal_error);
                Swal.fire({
                    icon: 'error',
                    title: t.swal_error,
                    text: errors,
                    confirmButtonColor: '#FFC60B'
                });
            }
        });

        function deleteLevel(id, name) {
            Swal.fire({
                title: t.delete_title,
                html: `<span style="font-size:13.5px;color:#475569">${t.delete_text}</span><br><strong style="font-size:13px;color:#0f172a">${name}</strong>`,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: t.cancel_btn,
                confirmButtonText: t.delete_btn,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#e2e8f0',
                reverseButtons: true,
                didOpen: () => {
                    const cancel = document.querySelector('.swal2-cancel');
                    if (cancel) cancel.style.color = '#475569';
                },
            }).then(async r => {
                if (!r.isConfirmed) return;
                const res = await fetch('{{ url('/loyalty/levels') }}/' + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                });
                const data = await res.json();
                if (res.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: t.deleted_title,
                        text: data.message ?? t.deleted_text,
                        confirmButtonColor: '#f59e0b',
                        timer: 1600,
                        showConfirmButton: false
                    });
                    setTimeout(() => location.reload(), 1700);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: t.swal_error,
                        text: data.message ?? t.delete_error,
                        confirmButtonColor: '#f59e0b'
                    });
                }
            });
        }
    </script>

</x-app-layout>
