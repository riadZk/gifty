<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'Gifty') }} — {{ __('auth.forgot_page_title') }}</title>
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

                <h1 class="title">{{ __('auth.forgot_title') }} <span
                        class="accent">{{ __('auth.forgot_accent') }}</span></h1>
                <p class="subtitle">{{ __('auth.forgot_subtitle') }}</p>

                {{-- Session status --}}
                @session('status')
                    <div class="alert alert-success" role="status">{{ $value }}</div>
                @endsession

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
                <form class="form" method="POST" action="{{ route('password.email') }}" novalidate>
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
                            placeholder="{{ __('auth.forgot_email_ph') }}" autocomplete="email" required autofocus />
                    </div>

                    <button type="submit" class="btn btn-continue"
                        data-loading="{{ __('auth.forgot_btn_loading') }}">{{ __('auth.forgot_btn') }}</button>
                </form>

                <p class="login-line">
                    <a href="{{ route('login') }}" class="accent-link">
                        ← {{ __('auth.forgot_back') }}
                    </a>
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
