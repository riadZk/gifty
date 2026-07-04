<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description"
        content="Create your free account to search or filter through 600,000+ screens. No credit card required." />
    <title>{{ config('app.name', 'Gifty') }} — {{ __('auth.login_page_title') }}</title>
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

                <h1 class="title">{{ __('auth.login_title') }} <span
                        class="accent">{{ __('auth.login_accent') }}</span></h1>
                <p class="subtitle">{{ __('auth.login_subtitle') }}</p>

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
                <form class="form" method="POST" action="{{ route('login') }}" novalidate>
                    @csrf
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
                            placeholder="{{ __('auth.login_email_ph') }}" autocomplete="email" required autofocus />
                    </div>

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
                            placeholder="{{ __('auth.login_password_ph') }}" autocomplete="current-password"
                            required />
                        <button type="button" class="toggle-pass" aria-label="Show password">
                            <svg viewBox="0 0 24 24" width="20" height="20">
                                <path fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                    stroke-linejoin="round" d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z" />
                                <circle cx="12" cy="12" r="2.6" fill="none" stroke="currentColor"
                                    stroke-width="1.8" />
                            </svg>
                        </button>
                    </div>

                    <div class="field-row">
                        <label class="remember">
                            <input type="checkbox" name="remember" /> {{ __('auth.login_remember') }}
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="accent-link">{{ __('auth.login_forgot') }}</a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-continue"
                        data-loading="{{ __('auth.login_btn_loading') }}">{{ __('auth.login_btn') }}</button>
                </form>

                <p class="terms">
                    {{ __('auth.login_terms_pre') }}
                    <a href="#">{{ __('auth.login_terms_tos') }}</a> {{ __('auth.login_terms_and') }} <a
                        href="#">{{ __('auth.login_terms_pp') }}</a>.
                </p>

                @if (Route::has('register'))
                    <p class="login-line">
                        {{ __('auth.login_no_account') }} <a href="{{ route('register') }}"
                            class="accent-link">{{ __('auth.login_signup') }}</a>
                    </p>
                @endif


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
