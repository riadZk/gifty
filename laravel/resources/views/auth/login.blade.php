<x-guest-layout>
    <style>
        * {
            box-sizing: border-box
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Manrope, sans-serif;
            color: #15171d;
            background: linear-gradient(135deg, transparent 0 72%, rgba(255, 204, 0, .18) 72% 82%, #ffcc00 82% 100%),
                radial-gradient(circle at 84% 10%, rgba(255, 204, 0, .08), transparent 28%), #f7f8fb
        }

        .lp {
            display: grid;
            grid-template-columns: minmax(370px, 42vw) 1fr;
            min-height: 100vh
        }

        /* ── Brand panel ── */
        .bp {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: clamp(34px, 5vw, 64px) clamp(28px, 4vw, 54px) 44px;
            overflow: hidden;
            color: #fff;
            background:
                linear-gradient(160deg, rgba(8, 12, 15, .82) 0%, rgba(8, 12, 15, .55) 60%, rgba(180, 110, 0, .38) 100%),
                url('/truck-login.png') center/cover no-repeat
        }

        .bp::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(115deg, rgba(255, 255, 255, .04), transparent 34%),
                repeating-linear-gradient(120deg, rgba(255, 255, 255, .035) 0 1px, transparent 1px 16px);
            opacity: .5
        }



        .bc,
        .bf {
            position: relative;
            z-index: 1
        }

        .lc {
            display: inline-flex;
            align-items: center;
            width: min(350px, 78vw);
            height: 68px;
            padding: 7px 10px;
            border-radius: 5px;
            background: #ffcc00;
            box-shadow: 0 16px 34px rgba(0, 0, 0, .34)
        }

        .lc img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: contain
        }

        .bt {
            max-width: 480px;
            margin: clamp(48px, 8vh, 78px) 0 0;
            font-family: "Space Grotesk", Manrope, sans-serif;
            font-size: clamp(34px, 4.8vw, 56px);
            line-height: 1.02
        }

        .bt span {
            display: block;
            color: #ffcc00
        }

        .btx {
            max-width: 430px;
            margin: 22px 0 0;
            color: rgba(255, 255, 255, .9);
            font-size: 17px;
            line-height: 1.7
        }

        .fl {
            display: grid;
            gap: 24px;
            max-width: 470px;
            margin-top: clamp(34px, 7vh, 70px);
            padding-top: 28px;
            border-top: 3px solid #ffcc00
        }

        .fi {
            display: grid;
            grid-template-columns: 42px 1fr;
            gap: 18px;
            align-items: center
        }

        .fi-icon {
            display: grid;
            place-items: center;
            width: 42px;
            height: 42px;
            color: #ffcc00
        }

        .fi-icon svg {
            width: 42px;
            height: 42px;
            stroke: currentColor;
            fill: none
        }

        .fi strong {
            display: block;
            font-size: 16px
        }

        .fi span {
            display: block;
            margin-top: 4px;
            color: rgba(255, 255, 255, .84);
            font-size: 14px
        }

        .bf {
            color: rgba(255, 255, 255, .86);
            font-size: 13px;
            line-height: 1.8
        }

        /* ── Login panel ── */
        .rp {
            display: grid;
            place-items: center;
            padding: 32px;
            background-image: radial-gradient(#d9dee8 1px, transparent 1px);
            background-size: 18px 18px
        }

        .card {
            width: min(100%, 560px);
            overflow: hidden;
            border: 1px solid rgba(217, 222, 232, .9);
            border-radius: 12px;
            background: rgba(255, 255, 255, .94);
            box-shadow: 0 24px 70px rgba(16, 24, 40, .16)
        }

        .card-body {
            padding: clamp(30px, 5vw, 54px)
        }

        .lock {
            display: grid;
            place-items: center;
            width: 62px;
            height: 62px;
            margin: 0 auto 22px;
            border-radius: 999px;
            background: #111820;
            color: #ffcc00;
            box-shadow: 0 10px 26px rgba(16, 24, 40, .18)
        }

        .lock svg {
            width: 28px;
            height: 28px;
            stroke: currentColor;
            fill: none
        }

        .h2 {
            margin: 0;
            text-align: center;
            font-family: "Space Grotesk", Manrope, sans-serif;
            font-size: clamp(30px, 4vw, 42px);
            line-height: 1
        }

        .sub {
            margin: 12px 0 22px;
            color: #667085;
            text-align: center;
            font-size: 15px
        }

        .err {
            margin-bottom: 18px;
            padding: 12px 16px;
            border-radius: 8px;
            background: #fef2f2;
            color: #b91c1c;
            font-size: 13px
        }

        .ok {
            margin-bottom: 18px;
            padding: 12px 16px;
            border-radius: 8px;
            background: #f0fdf4;
            color: #15803d;
            font-size: 13px
        }

        .fg {
            display: grid;
            gap: 7px;
            margin-bottom: 18px
        }

        .fg label {
            color: #1d2430;
            font-size: 13px;
            font-weight: 800
        }

        .iw {
            display: grid;
            grid-template-columns: 24px 1fr 24px;
            gap: 12px;
            align-items: center;
            min-height: 54px;
            padding: 0 14px;
            border: 1.5px solid #dfe3ea;
            border-radius: 7px;
            background: #fff;
            transition: border-color .18s, box-shadow .18s
        }

        .iw:focus-within {
            border-color: #ffcc00;
            box-shadow: 0 0 0 4px rgba(255, 204, 0, .18)
        }

        .iw svg {
            width: 20px;
            height: 20px;
            color: #6b7280;
            stroke: currentColor;
            fill: none
        }

        .iw input {
            width: 100%;
            border: 0;
            outline: 0;
            background: transparent;
            color: #15171d;
            font: inherit;
            font-size: 15px
        }

        .iw input::placeholder {
            color: #8b95a5
        }

        .fa {
            display: inline-grid;
            place-items: center;
            border: 0;
            padding: 0;
            background: transparent;
            color: #6b7280;
            cursor: pointer
        }

        .fa svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            fill: none
        }

        .row {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: center;
            margin: 3px 0 24px;
            font-size: 13px
        }

        .rem {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #667085
        }

        .rem input {
            width: 17px;
            height: 17px;
            accent-color: #ffcc00
        }

        .lnk {
            color: #d89f00;
            font-weight: 800;
            text-decoration: none
        }

        .btn,
        .sso {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
            min-height: 56px;
            border-radius: 8px;
            font: inherit;
            font-weight: 900;
            cursor: pointer;
            font-size: 15px
        }

        .btn {
            border: 0;
            background: linear-gradient(135deg, #ffc400, #ffb000);
            color: #111820;
            box-shadow: 0 12px 24px rgba(255, 196, 0, .22);
            transition: opacity .15s
        }

        .btn:hover {
            opacity: .9
        }

        .btn svg,
        .sso svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            fill: none
        }

        .div {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 16px;
            align-items: center;
            margin: 22px 0;
            color: #98a2b3;
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase
        }

        .div::before,
        .div::after {
            content: "";
            height: 1px;
            background: #dfe3ea
        }

        .div span {
            display: grid;
            place-items: center;
            width: 34px;
            height: 34px;
            border-radius: 999px;
            background: #f3f5f8
        }

        .sso {
            border: 1.5px solid #dfe3ea;
            background: #fff;
            color: #1d2430;
            transition: background .15s
        }

        .sso:hover {
            background: #f9fafb
        }

        .help {
            display: flex;
            justify-content: center;
            gap: 14px;
            align-items: center;
            padding: 22px 24px;
            border-top: 1px solid #dfe3ea;
            background: #f7f8fa;
            color: #475467;
            font-size: 13px
        }

        .help svg {
            width: 26px;
            height: 26px;
            flex-shrink: 0;
            stroke: currentColor;
            fill: none
        }

        .help strong {
            display: block;
            color: #1d2430
        }

        @media(max-width:960px) {
            .lp {
                grid-template-columns: 1fr
            }

            .bp {
                min-height: auto
            }

            .bf {
                margin-top: 48px
            }
        }

        @media(max-width:560px) {
            .rp {
                padding: 18px
            }

            .lc {
                width: 260px;
                height: 54px
            }

            .row,
            .help {
                align-items: flex-start;
                flex-direction: column
            }
        }
    </style>

    <main class="lp">

        {{-- ═══════════ LEFT: Brand Panel ═══════════ --}}
        <section class="bp" aria-label="Présentation Plateforme PCC">
            <div class="bc">
                <a class="lc" href="{{ url('/') }}" aria-label="Tractafric Equipment CAT">
                    <img src="{{ asset('logo.svg') }}" alt="Tractafric Equipment CAT">
                </a>
                <h1 class="bt">Plateforme <span>Points de Fidélité PCC</span></h1>
                <p class="btx">Gérez le programme de fidélisation de vos clients en toute simplicité.</p>
                <div class="fl">
                    <div class="fi">
                        <span class="fi-icon"><svg viewBox="0 0 24 24" stroke-width="1.8">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                <path d="M9 12l2 2 4-5" />
                            </svg></span>
                        <div><strong>Sécurisé</strong><span>Accès protégé et données chiffrées</span></div>
                    </div>
                    <div class="fi">
                        <span class="fi-icon"><svg viewBox="0 0 24 24" stroke-width="1.8">
                                <path d="M3 3v18h18" />
                                <path d="M7 15l4-4 3 3 5-7" />
                                <path d="M18 7h1v5" />
                            </svg></span>
                        <div><strong>Tableaux de bord</strong><span>Suivez vos KPI en temps réel</span></div>
                    </div>
                    <div class="fi">
                        <span class="fi-icon"><svg viewBox="0 0 24 24" stroke-width="1.8">
                                <path d="M20 12v10H4V12" />
                                <path d="M2 7h20v5H2z" />
                                <path d="M12 22V7" />
                                <path d="M12 7H8.5a2.5 2.5 0 1 1 2.2-3.7L12 7z" />
                                <path d="M12 7h3.5a2.5 2.5 0 1 0-2.2-3.7L12 7z" />
                            </svg></span>
                        <div><strong>Gestion des récompenses</strong><span>Supervisez les bonus et livraisons</span>
                        </div>
                    </div>
                    <div class="fi">
                        <span class="fi-icon"><svg viewBox="0 0 24 24" stroke-width="1.8">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg></span>
                        <div><strong>Gestion des clients</strong><span>Pilotez votre base clients facilement</span>
                        </div>
                    </div>
                </div>
            </div>
            <p class="bf">© 2026 Tractafric Equipment<br>Tous droits réservés.</p>
        </section>

        {{-- ═══════════ RIGHT: Login Panel ═══════════ --}}
        <section class="rp" aria-label="Connexion administrateur">
            <div class="card">
                <div class="card-body">
                    <div class="lock" aria-hidden="true">
                        <svg viewBox="0 0 24 24" stroke-width="1.8">
                            <rect x="5" y="11" width="14" height="10" rx="2" />
                            <path d="M8 11V7a4 4 0 0 1 8 0v4" />
                            <path d="M12 15v2" />
                        </svg>
                    </div>
                    <h2 class="h2">Bienvenue</h2>
                    <p class="sub">Connectez-vous à votre espace administrateur</p>

                    {{-- Validation errors --}}
                    @if($errors->any())
                    <div class="err">
                        <ul style="margin:0;padding-left:18px">
                            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                        </ul>
                    </div>
                    @endif

                    {{-- Session status --}}
                    @session('status')
                    <div class="ok">{{ $value }}</div>
                    @endsession

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="fg">
                            <label for="email">Adresse e-mail</label>
                            <div class="iw">
                                <svg viewBox="0 0 24 24" stroke-width="1.8">
                                    <path d="M4 4h16v16H4z" />
                                    <path d="m22 6-10 7L2 6" />
                                </svg>
                                <input id="email" name="email" type="email" value="{{ old('email') }}"
                                    placeholder="exemple@tractafric.com" autocomplete="username" required autofocus>
                                <span></span>
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="fg">
                            <label for="password">Mot de passe</label>
                            <div class="iw">
                                <svg viewBox="0 0 24 24" stroke-width="1.8">
                                    <rect x="5" y="11" width="14" height="10" rx="2" />
                                    <path d="M8 11V7a4 4 0 0 1 8 0v4" />
                                </svg>
                                <input id="password" name="password" type="password" placeholder="Votre mot de passe"
                                    autocomplete="current-password" required>
                                <button class="fa" type="button" aria-label="Afficher/masquer le mot de passe"
                                    onclick="var i=this.previousElementSibling;i.type=i.type==='password'?'text':'password'">
                                    <svg viewBox="0 0 24 24" stroke-width="1.8">
                                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Remember / Forgot --}}
                        <div class="row">
                            <label class="rem">
                                <input type="checkbox" name="remember"> Se souvenir de moi
                            </label>
                            @if(Route::has('password.request'))
                            <a class="lnk" href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                            @endif
                        </div>

                        <button class="btn" type="submit">
                            Se connecter
                            <svg viewBox="0 0 24 24" stroke-width="1.8">
                                <path d="M5 12h14" />
                                <path d="m13 6 6 6-6 6" />
                            </svg>
                        </button>
                    </form>

                    <div class="div"><span>ou</span></div>

                    <button class="sso" type="button">
                        <svg viewBox="0 0 24 24" stroke-width="1.8">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            <path d="M9 12l2 2 4-5" />
                        </svg>
                        Connexion SSO
                    </button>
                </div>

                <div class="help">
                    <svg viewBox="0 0 24 24" stroke-width="1.8">
                        <path d="M3 18v-6a9 9 0 0 1 18 0v6" />
                        <path d="M21 19a2 2 0 0 1-2 2h-1v-7h3v5z" />
                        <path d="M3 19a2 2 0 0 0 2 2h1v-7H3v5z" />
                    </svg>
                    <div><strong>Besoin d'aide ?</strong><a class="lnk" href="#"> Contacter l'administrateur</a></div>
                </div>
            </div>
        </section>

    </main>
</x-guest-layout>