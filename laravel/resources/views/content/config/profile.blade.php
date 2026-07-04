<x-app-layout>

    @php
        $currentUser = $user ?? Auth::user();
        $initials = strtoupper(mb_substr($currentUser->name, 0, 2));
    @endphp

    {{-- Override Jetstream form-section & action-section styles to match our design --}}
    <style>
        /* Hide the default left description column */
        .pcc-profile-wrap [class*="md:col-span-1"]:first-child {
            display: none !important;
        }

        .pcc-profile-wrap [class*="md:col-span-2"] {
            --tw-col-start: 1 !important;
            grid-column: 1 / -1 !important;
        }

        /* Card shells */
        .pcc-profile-wrap .pcc-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, .06);
        }

        .pcc-profile-wrap .pcc-card-title {
            font-size: 14px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 18px;
        }

        /* Inputs */
        .pcc-profile-wrap input[type="text"],
        .pcc-profile-wrap input[type="email"],
        .pcc-profile-wrap input[type="password"] {
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #f8fafc;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 600;
            color: #0f172a;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }

        .pcc-profile-wrap input:focus {
            border-color: #fbbf24;
            box-shadow: 0 0 0 3px rgba(251, 191, 36, .15);
        }

        .pcc-profile-wrap label.block {
            font-size: 12px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
            display: block;
        }

        /* Primary button */
        .pcc-profile-wrap button[type="submit"],
        .pcc-profile-wrap button.pcc-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            height: 36px;
            padding: 0 18px;
            background: #fbbf24;
            color: #0f172a;
            font-size: 12.5px;
            font-weight: 700;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            transition: background .15s;
        }

        .pcc-profile-wrap button[type="submit"]:hover,
        .pcc-profile-wrap button.pcc-primary:hover {
            background: #f59e0b;
        }

        /* Danger button */
        .pcc-profile-wrap button.pcc-danger {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            height: 36px;
            padding: 0 18px;
            background: #fef2f2;
            color: #dc2626;
            font-size: 12.5px;
            font-weight: 700;
            border-radius: 12px;
            border: 1px solid #fecaca;
            cursor: pointer;
            transition: background .15s;
        }

        .pcc-profile-wrap button.pcc-danger:hover {
            background: #fee2e2;
        }

        /* Secondary button */
        .pcc-profile-wrap button.pcc-secondary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            height: 36px;
            padding: 0 14px;
            background: #f8fafc;
            color: #475569;
            font-size: 12.5px;
            font-weight: 600;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            transition: background .15s;
        }

        .pcc-profile-wrap button.pcc-secondary:hover {
            background: #f1f5f9;
        }

        /* Saved message */
        .pcc-profile-wrap [dusk="action-message"] {
            font-size: 12px;
            font-weight: 600;
            color: #059669;
        }

        /* Error messages */
        .pcc-profile-wrap p[role="alert"],
        .pcc-profile-wrap .text-red-600 {
            font-size: 11.5px;
            color: #dc2626;
            margin-top: 4px;
        }

        /* Grid form layout */
        .pcc-profile-wrap .pcc-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        @media (max-width: 640px) {
            .pcc-profile-wrap .pcc-grid {
                grid-template-columns: 1fr;
            }
        }

        .pcc-profile-wrap .pcc-full {
            grid-column: 1 / -1;
        }

        /* Photo dropzone */
        .pcc-profile-wrap .photo-drop {
            border: 2px dashed #e2e8f0;
            border-radius: 13px;
            padding: 22px 20px;
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

        .pcc-profile-wrap .photo-drop:hover,
        .pcc-profile-wrap .photo-drop.drag {
            border-color: #fbbf24;
            background: #fffbeb;
        }

        .pcc-profile-wrap .photo-drop input[type=file] {
            display: none;
        }
    </style>

    <div class="mx-auto max-w-[110rem] flex gap-6">

        {{-- Sidebar --}}
        @include('content.config._sidebar')

        {{-- Main --}}
        <div class="pcc-profile-wrap min-w-0 flex-1 flex flex-col gap-5">

            {{-- Breadcrumb --}}
            <div>
                <nav class="flex items-center gap-1.5 text-[11.5px] font-medium text-slate-400">
                    <span>{{ __('config.breadcrumb') }}</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3 w-3">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                    <span class="text-slate-600">{{ __('config.profile_page_title') }}</span>
                </nav>
                <h1 class="mt-1 text-[22px] font-black tracking-tight text-slate-900">
                    {{ __('config.profile_page_title') }}</h1>
            </div>

            {{-- ── Avatar / Photo card ── --}}
            <div class="pcc-card">
                <p class="pcc-card-title">{{ __('config.profile_photo_title') }}</p>
                <div class="flex flex-col sm:flex-row gap-6 items-start">

                    {{-- Current photo + info --}}
                    <div class="flex flex-col items-center gap-2 text-center sm:w-36">
                        @if ($currentUser->hasMedia('profile-photo'))
                            <img id="photo-preview-img" src="{{ $currentUser->profile_photo_url }}"
                                alt="{{ $currentUser->name }}"
                                class="h-24 w-24 rounded-2xl object-cover shadow-md border border-slate-200">
                        @else
                            <span id="photo-initials"
                                class="flex h-24 w-24 items-center justify-center rounded-2xl bg-amber-400 text-[26px] font-black text-slate-900 shadow-md">
                                {{ $initials }}
                            </span>
                            <img id="photo-preview-img" src="" alt=""
                                class="h-24 w-24 rounded-2xl object-cover shadow-md border border-slate-200 hidden">
                        @endif
                        <p class="text-[14px] font-black text-slate-900 mt-1">{{ $currentUser->name }}</p>
                        <p class="text-[12px] font-medium text-slate-400">{{ $currentUser->email }}</p>
                        <span
                            class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-[11px] font-bold text-emerald-700">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                            {{ __('config.profile_admin_badge') }}
                        </span>
                    </div>

                    {{-- Upload dropzone --}}
                    <div class="flex-1 flex flex-col gap-3">
                        <div class="photo-drop" id="photo-drop"
                            onclick="document.getElementById('photo-input').click()">
                            <input type="file" id="photo-input" accept="image/jpeg,image/png,image/webp">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5"
                                class="h-8 w-8 mb-2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>
                            <p class="text-[13px] font-semibold text-slate-500">{{ __('config.profile_photo_drop') }}
                            </p>
                            <p class="mt-0.5 text-[11.5px] text-slate-400">{{ __('config.profile_photo_types') }}</p>
                        </div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <button id="photo-save-btn" onclick="uploadPhoto()" style="display:none;"
                                class="inline-flex h-9 items-center gap-2 rounded-xl bg-amber-400 px-4 text-[12.5px] font-bold text-slate-900 shadow-sm transition hover:bg-amber-500">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    class="h-4 w-4">
                                    <path d="m5 12 5 5L20 7" />
                                </svg>
                                {{ __('config.profile_photo_save') }}
                            </button>
                            <button id="photo-remove-btn" onclick="removePhoto()"
                                @if (!$currentUser->hasMedia('profile-photo')) style="display:none;" @endif
                                class="inline-flex h-9 items-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 text-[12.5px] font-bold text-red-600 transition hover:bg-red-100">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    class="h-4 w-4">
                                    <polyline points="3 6 5 6 21 6" />
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                    <path d="M10 11v6" />
                                    <path d="M14 11v6" />
                                </svg>
                                {{ __('config.profile_photo_remove') }}
                            </button>
                        </div>
                        <span id="photo-msg" class="hidden text-[12px] font-semibold"></span>
                    </div>
                </div>
            </div>

            {{-- ── Profile information (Livewire) ── --}}
            <div class="pcc-card">
                <p class="pcc-card-title">{{ __('config.profile_info_title') }}</p>
                @livewire('profile.update-profile-information-form')
            </div>

            {{-- ── Update password (Livewire) ── --}}
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="pcc-card">
                    <p class="pcc-card-title">{{ __('config.profile_password_title') }}</p>
                    @livewire('profile.update-password-form')
                </div>
            @endif

            {{-- ── Two-factor (Livewire) ── --}}
            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="pcc-card">
                    <p class="pcc-card-title">{{ __('config.profile_2fa_title') }}</p>
                    @livewire('profile.two-factor-authentication-form')
                </div>
            @endif

            {{-- ── Browser sessions (Livewire) ── --}}
            <div class="pcc-card">
                <p class="pcc-card-title">{{ __('config.profile_sessions_title') }}</p>
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            {{-- ── Delete account (Livewire) ── --}}
            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <div class="pcc-card border-red-100">
                    <p class="pcc-card-title text-red-600">{{ __('config.profile_delete_title') }}</p>
                    @livewire('profile.delete-user-form')
                </div>
            @endif

        </div>
    </div>

    <script>
        const photoInput = document.getElementById('photo-input');
        const photoPreview = document.getElementById('photo-preview-img');
        const photoInitials = document.getElementById('photo-initials');
        const photoSaveBtn = document.getElementById('photo-save-btn');
        const photoRemoveBtn = document.getElementById('photo-remove-btn');
        const photoMsg = document.getElementById('photo-msg');
        const photoDrop = document.getElementById('photo-drop');
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

        @php
            $profileJs = [
                'delete_photo_title' => __('config.profile_delete_photo_title'),
                'delete_photo_text' => __('config.profile_delete_photo_text'),
                'delete_photo_btn' => __('config.profile_delete_photo_btn'),
                'cancel_btn' => __('config.profile_cancel_btn'),
                'deleted_title' => __('config.profile_deleted_title'),
                'deleted_text' => __('config.profile_deleted_text'),
                'error_title' => __('config.profile_error_title'),
                'delete_error' => __('config.profile_delete_error'),
                'saved' => __('config.profile_saved'),
                'error' => __('config.profile_error'),
            ];
        @endphp
        const pt = @json($profileJs);

        photoInput.addEventListener('change', function() {
            if (!this.files[0]) return;
            const reader = new FileReader();
            reader.onload = e => {
                photoPreview.src = e.target.result;
                photoPreview.classList.remove('hidden');
                if (photoInitials) photoInitials.style.display = 'none';
                photoSaveBtn.style.display = '';
            };
            reader.readAsDataURL(this.files[0]);
        });

        ['dragover', 'dragenter'].forEach(ev =>
            photoDrop.addEventListener(ev, e => {
                e.preventDefault();
                photoDrop.classList.add('drag');
            })
        );
        ['dragleave', 'drop'].forEach(ev =>
            photoDrop.addEventListener(ev, e => {
                e.preventDefault();
                photoDrop.classList.remove('drag');
            })
        );
        photoDrop.addEventListener('drop', e => {
            const file = e.dataTransfer.files[0];
            if (!file) return;
            const dt = new DataTransfer();
            dt.items.add(file);
            photoInput.files = dt.files;
            photoInput.dispatchEvent(new Event('change'));
        });

        async function uploadPhoto() {
            if (!photoInput.files[0]) return;
            const fd = new FormData();
            fd.append('photo', photoInput.files[0]);
            const res = await fetch('{{ route('config.profile.photo.update') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                },
                body: fd,
            });
            const data = await res.json();
            showMsg(data.message ?? (res.ok ? pt.saved : pt.error), res.ok);
            if (res.ok) {
                if (data.url) photoPreview.src = data.url;
                photoSaveBtn.style.display = 'none';
                photoRemoveBtn.style.display = '';
                photoInput.value = '';
                setTimeout(() => location.reload(), 800);
            }
        }

        async function removePhoto() {
            const result = await Swal.fire({
                title: pt.delete_photo_title,
                html: `<span style="font-size:13.5px;color:#475569">${pt.delete_photo_text}</span>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: pt.delete_photo_btn,
                cancelButtonText: pt.cancel_btn,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#e2e8f0',
                reverseButtons: true,
                didOpen: () => {
                    const cancel = document.querySelector('.swal2-cancel');
                    if (cancel) cancel.style.color = '#475569';
                },
            });

            if (!result.isConfirmed) return;

            const res = await fetch('{{ route('config.profile.photo.remove') }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                },
            });
            const data = await res.json();
            if (res.ok) {
                photoPreview.src = '';
                photoPreview.classList.add('hidden');
                if (photoInitials) photoInitials.style.display = '';
                photoRemoveBtn.style.display = 'none';
                photoSaveBtn.style.display = 'none';
                photoInput.value = '';
                Swal.fire({
                    icon: 'success',
                    title: pt.deleted_title,
                    text: data.message ?? pt.deleted_text,
                    confirmButtonColor: '#f59e0b',
                    timer: 1800,
                    showConfirmButton: false,
                });
                setTimeout(() => location.reload(), 1900);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: pt.error_title,
                    text: data.message ?? pt.delete_error,
                    confirmButtonColor: '#f59e0b',
                });
            }
        }

        function showMsg(text, ok) {
            photoMsg.textContent = text;
            photoMsg.className = 'text-[12px] font-semibold ' + (ok ? 'text-emerald-600' : 'text-red-500');
            setTimeout(() => {
                photoMsg.className = 'hidden';
            }, 3000);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</x-app-layout>
