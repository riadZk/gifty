<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'Gifty') }} — {{ __('auth.reset_page_title') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ @filemtime(public_path('css/app.css')) ?: time() }}" />
</head>

<body>
    <div class="page">

        {{-- ── Language switcher ── --}}
        @php
            $currentLocale = app()->getLocale();
            $otherLocale = $currentLocale === 'fr' ? 'en' : 'fr';
            $flags = [
                'en' => 'https://loupiot.zyfed.fr/assets/img/countries/english.png',
                'fr' => 'https://loupiot.zyfed.fr/assets/img/countries/french.png',
            ];
            $labels = ['en' => 'EN', 'fr' => 'FR'];
        @endphp
        <form method="POST" action="{{ route('locale.switch', $otherLocale) }}" id="auth-locale-form"
            style="display:none;">
            @csrf
        </form>
        <button type="button" onclick="document.getElementById('auth-locale-form').submit()"
            style="position:fixed;top:16px;left:16px;z-index:50;display:flex;align-items:center;gap:6px;background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:6px 10px 6px 8px;cursor:pointer;box-shadow:0 1px 4px rgba(15,23,42,.08);font-family:inherit;">
            <span
                style="width:20px;height:20px;border-radius:4px;overflow:hidden;border:1px solid #e2e8f0;display:flex;align-items:center;justify-content:center;flex:none;">
                <img src="{{ $flags[$otherLocale] }}" alt="{{ $labels[$otherLocale] }}"
                    style="width:100%;height:100%;object-fit:cover;">
            </span>
            <span style="font-size:12px;font-weight:700;color:#475569;">{{ $labels[$otherLocale] }}</span>
        </button>

        <!-- ============ LEFT PANEL ============ -->
        <section class="left-panel">
            <div class="form-wrap fade-in">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="logo" aria-label="Gifty home">
                    <img src="{{ asset('logo.svg') }}" alt="Gifty" class="logo-img" />
                </a>

                <h1 class="title">{{ __('auth.reset_title') }} <span
                        class="accent">{{ __('auth.reset_accent') }}</span></h1>
                <p class="subtitle">{{ __('auth.reset_subtitle') }}</p>

                {{-- Validation errors --}}
                @if ($errors->any())
                    <div class="alert alert-error" role="alert">
                        <ul>
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form -->
                <form class="form" method="POST" action="{{ route('password.update') }}" novalidate>
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    {{-- Email --}}
                    <div class="field">
                        <span class="field-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="18" height="18">
                                <path fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                    stroke-linejoin="round" d="M3 6.5h18v11H3z" />
                                <path fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                    stroke-linejoin="round" d="m3.5 7 8.5 6 8.5-6" />
                            </svg>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}"
                            placeholder="{{ __('auth.reset_email_ph') }}" autocomplete="username" required autofocus />
                    </div>

                    {{-- New password --}}
                    <div class="field">
                        <span class="field-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="18" height="18">
                                <rect x="4" y="10" width="16" height="10" rx="2" fill="none"
                                    stroke="currentColor" stroke-width="1.8" />
                                <path d="M8 10V7a4 4 0 0 1 8 0v3" fill="none" stroke="currentColor"
                                    stroke-width="1.8" stroke-linecap="round" />
                            </svg>
                        </span>
                        <input type="password" id="password" name="password"
                            placeholder="{{ __('auth.reset_password_ph') }}" autocomplete="new-password" required />
                        <button type="button" class="toggle-pass" aria-label="Show password">
                            <svg viewBox="0 0 24 24" width="20" height="20">
                                <path fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                    stroke-linejoin="round" d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z" />
                                <circle cx="12" cy="12" r="2.6" fill="none" stroke="currentColor"
                                    stroke-width="1.8" />
                            </svg>
                        </button>
                    </div>

                    {{-- Confirm password --}}
                    <div class="field">
                        <span class="field-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="18" height="18">
                                <path fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                    stroke-linejoin="round" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                <path fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                    stroke-linejoin="round" d="M9 12l2 2 4-5" />
                            </svg>
                        </span>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="{{ __('auth.reset_confirm_ph') }}" autocomplete="new-password" required />
                        <button type="button" class="toggle-pass" aria-label="Show password">
                            <svg viewBox="0 0 24 24" width="20" height="20">
                                <path fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                    stroke-linejoin="round" d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z" />
                                <circle cx="12" cy="12" r="2.6" fill="none" stroke="currentColor"
                                    stroke-width="1.8" />
                            </svg>
                        </button>
                    </div>

                    <button type="submit" class="btn btn-continue"
                        data-loading="{{ __('auth.reset_btn_loading') }}">{{ __('auth.reset_btn') }}</button>
                </form>

                <p class="login-line">
                    <a href="{{ route('login') }}" class="accent-link">← {{ __('auth.forgot_back') }}</a>
                </p>
            </div>
        </section>

        <!-- ============ RIGHT PANEL ============ -->
        <section class="right-panel" id="scene">
            <div class="glow glow-1"></div>
            <div class="glow glow-2"></div>
            <div class="mosaic" id="mosaic"></div>
        </section>
    </div>

    <script src="{{ asset('js/app.js') }}?v={{ @filemtime(public_path('js/app.js')) ?: time() }}"></script>
</body>

</html>
<x-slot name="logo">
    <x-authentication-card-logo />
</x-slot>

<x-validation-errors class="mb-4" />

<form method="POST" action="{{ route('password.update') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <div class="block">
        <x-label for="email" value="{{ __('Email') }}" />
        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required
            autofocus autocomplete="username" />
    </div>

    <div class="mt-4">
        <x-label for="password" value="{{ __('Password') }}" />
        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
            autocomplete="new-password" />
    </div>

    <div class="mt-4">
        <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"
            required autocomplete="new-password" />
    </div>

    <div class="flex items-center justify-end mt-4">
        <x-button>
            {{ __('Reset Password') }}
        </x-button>
    </div>
</form>
</x-authentication-card>
</x-guest-layout>
