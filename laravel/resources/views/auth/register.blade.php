<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="Créez votre compte sur la plateforme de fidélité." />
    <title>{{ config('app.name', 'Gifty') }} — {{ __('auth.register_page_title') }}</title>
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
                <a href="{{ url('/') }}" class="logo" aria-label="Accueil">
                    <img src="{{ asset('logo.svg') }}" alt="Logo" class="logo-img" />
                </a>

                <h1 class="title">{{ __('auth.register_title') }} <span
                        class="accent">{{ __('auth.register_accent') }}</span></h1>
                <p class="subtitle">{{ __('auth.register_subtitle') }}</p>

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

                {{-- Session status --}}
                @session('status')
                    <div class="alert alert-success" role="status">{{ $value }}</div>
                @endsession

                <!-- Form -->
                <form class="form" method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Name --}}
                    <div class="field">
                        <span class="field-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="18" height="18">
                                <path fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                    stroke-linejoin="round" d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" fill="none" stroke="currentColor"
                                    stroke-width="1.8" />
                            </svg>
                        </span>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            placeholder="{{ __('auth.register_name_ph') }}" autocomplete="name" required autofocus />
                    </div>

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
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            placeholder="{{ __('auth.register_email_ph') }}" autocomplete="email" required />
                    </div>

                    {{-- Phone (optional) --}}
                    <div class="field">
                        <span class="field-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="18" height="18">
                                <path fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.18 2 2 0 0 1 3.6 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.6a16 16 0 0 0 6.08 6.08l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
                            </svg>
                        </span>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                            placeholder="{{ __('auth.register_phone_ph') }}" autocomplete="tel" />
                    </div>

                    {{-- Password --}}
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
                            placeholder="{{ __('auth.register_password_ph') }}" autocomplete="new-password"
                            required />
                        <button type="button" class="toggle-pass" aria-label="Afficher le mot de passe">
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
                            placeholder="{{ __('auth.register_confirm_ph') }}" autocomplete="new-password"
                            required />
                        <button type="button" class="toggle-pass" aria-label="Afficher le mot de passe">
                            <svg viewBox="0 0 24 24" width="20" height="20">
                                <path fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                    stroke-linejoin="round" d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z" />
                                <circle cx="12" cy="12" r="2.6" fill="none" stroke="currentColor"
                                    stroke-width="1.8" />
                            </svg>
                        </button>
                    </div>

                    {{-- Terms --}}
                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="field-row" style="justify-content:flex-start">
                            <label class="remember">
                                <input type="checkbox" name="terms" id="terms" required />
                                <span>
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' =>
                                            '<a target="_blank" href="' . route('terms.show') . '" class="accent-link">' . __('Terms of Service') . '</a>',
                                        'privacy_policy' =>
                                            '<a target="_blank" href="' . route('policy.show') . '" class="accent-link">' . __('Privacy Policy') . '</a>',
                                    ]) !!}
                                </span>
                            </label>
                        </div>
                    @endif

                    <button type="submit" class="btn btn-continue"
                        data-loading="{{ __('auth.register_btn_loading') }}">{{ __('auth.register_btn') }}</button>
                </form>

                <p class="login-line">
                    {{ __('auth.register_have_account') }} <a href="{{ route('login') }}"
                        class="accent-link">{{ __('auth.register_login') }}</a>
                </p>
            </div>
        </section>

        <!-- ============ RIGHT PANEL ============ -->
        <section class="right-panel" id="scene">
            <div class="glow glow-1"></div>
            <div class="glow glow-2"></div>

            <!-- Infinite scrolling phone mosaic (columns built by JS) -->
            <div class="mosaic" id="mosaic"></div>
        </section>
    </div>

    <script src="{{ asset('js/app.js') }}?v={{ @filemtime(public_path('js/app.js')) ?: time() }}"></script>
</body>

</html>
