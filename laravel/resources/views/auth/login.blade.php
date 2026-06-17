<x-guest-layout>
    <style>
        body {
            background:
                linear-gradient(135deg, transparent 0 72%, rgba(255,204,0,.18) 72% 82%, #ffcc00 82% 100%),
                radial-gradient(circle at 84% 10%, rgba(255,204,0,.08), transparent 28%),
                #f7f8fb;
        }
        .brand-panel {
            background:
                linear-gradient(160deg, rgba(8,12,15,.82) 0%, rgba(8,12,15,.55) 60%, rgba(180,110,0,.38) 100%),
                url('/truck-login.png') center/cover no-repeat;
        }
        .brand-panel::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(115deg, rgba(255,255,255,.04), transparent 34%),
                repeating-linear-gradient(120deg, rgba(255,255,255,.035) 0 1px, transparent 1px 16px);
            opacity: .5;
        }
        .dot-bg {
            background-image: radial-gradient(#d9dee8 1px, transparent 1px);
            background-size: 18px 18px;
        }
        .iw:focus-within {
            border-color: #ffcc00 !important;
            box-shadow: 0 0 0 3px rgba(255,204,0,.18);
        }
        input[type="checkbox"] { accent-color: #ffcc00; }
    </style>

    <main class="grid lg:grid-cols-[minmax(370px,42vw)_1fr] min-h-screen">

        {{-- LEFT: Brand Panel --}}
        <section class="brand-panel relative flex flex-col justify-between overflow-hidden text-white py-10 px-8 lg:py-16 lg:px-14"
            aria-label="Présentation Plateforme PCC">
            <div class="relative z-10">
                <a class="inline-flex items-center h-14 px-3 py-2 rounded bg-yellow-400 shadow-2xl"
                    href="{{ url('/') }}" aria-label="Tractafric Equipment CAT"
                    style="width:min(350px,78vw)">
                    <img src="{{ asset('logo.svg') }}" alt="Tractafric Equipment CAT"
                        class="block w-full h-full object-contain">
                </a>

                <h1 class="max-w-lg mt-14 font-bold text-4xl leading-tight">
                    Plateforme <span class="block text-yellow-400">Points de Fidélité PCC</span>
                </h1>
                <p class="max-w-sm mt-4 text-white/90 text-xs leading-relaxed">
                    Gérez le programme de fidélisation de vos clients en toute simplicité.
                </p>

                <div class="grid gap-5 max-w-lg mt-10 pt-6 border-t-2 border-yellow-400">

                    <div class="grid grid-cols-[40px_1fr] gap-4 items-center">
                        <span class="grid place-items-center w-10 h-10 text-yellow-400">
                            <svg viewBox="0 0 24 24" stroke-width="1.8" class="w-9 h-9 stroke-current fill-none">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                <path d="M9 12l2 2 4-5"/>
                            </svg>
                        </span>
                        <div>
                            <strong class="block text-xs font-bold">Sécurisé</strong>
                            <span class="block mt-1 text-white/80 text-xs">Accès protégé et données chiffrées</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-[40px_1fr] gap-4 items-center">
                        <span class="grid place-items-center w-10 h-10 text-yellow-400">
                            <svg viewBox="0 0 24 24" stroke-width="1.8" class="w-9 h-9 stroke-current fill-none">
                                <path d="M3 3v18h18"/><path d="M7 15l4-4 3 3 5-7"/><path d="M18 7h1v5"/>
                            </svg>
                        </span>
                        <div>
                            <strong class="block text-xs font-bold">Tableaux de bord</strong>
                            <span class="block mt-1 text-white/80 text-xs">Suivez vos KPI en temps réel</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-[40px_1fr] gap-4 items-center">
                        <span class="grid place-items-center w-10 h-10 text-yellow-400">
                            <svg viewBox="0 0 24 24" stroke-width="1.8" class="w-9 h-9 stroke-current fill-none">
                                <path d="M20 12v10H4V12"/><path d="M2 7h20v5H2z"/><path d="M12 22V7"/>
                                <path d="M12 7H8.5a2.5 2.5 0 1 1 2.2-3.7L12 7z"/>
                                <path d="M12 7h3.5a2.5 2.5 0 1 0-2.2-3.7L12 7z"/>
                            </svg>
                        </span>
                        <div>
                            <strong class="block text-xs font-bold">Gestion des récompenses</strong>
                            <span class="block mt-1 text-white/80 text-xs">Supervisez les bonus et livraisons</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-[40px_1fr] gap-4 items-center">
                        <span class="grid place-items-center w-10 h-10 text-yellow-400">
                            <svg viewBox="0 0 24 24" stroke-width="1.8" class="w-9 h-9 stroke-current fill-none">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </span>
                        <div>
                            <strong class="block text-xs font-bold">Gestion des clients</strong>
                            <span class="block mt-1 text-white/80 text-xs">Pilotez votre base clients facilement</span>
                        </div>
                    </div>

                </div>
            </div>
            <p class="relative z-10 mt-10 text-white/85 text-xs leading-relaxed">
                &copy; 2026 Tractafric Equipment<br>Tous droits réservés.
            </p>
        </section>

        {{-- RIGHT: Login Panel --}}
        <section class="dot-bg grid place-items-center p-8" aria-label="Connexion administrateur">
            <div class="w-full max-w-lg overflow-hidden border border-gray-200/90 rounded-xl bg-white/95 shadow-2xl">

                <div class="p-8 lg:p-12">

                    {{-- Lock icon --}}
                    <div class="grid place-items-center w-12 h-12 mx-auto mb-4 rounded-full bg-gray-900 text-yellow-400 shadow-xl"
                        aria-hidden="true">
                        <svg viewBox="0 0 24 24" stroke-width="1.8" class="w-5 h-5 stroke-current fill-none">
                            <rect x="5" y="11" width="14" height="10" rx="2"/>
                            <path d="M8 11V7a4 4 0 0 1 8 0v4"/>
                            <path d="M12 15v2"/>
                        </svg>
                    </div>

                    <h2 class="text-center font-bold text-2xl leading-none text-gray-900">Bienvenue</h2>
                    <p class="mt-2 mb-5 text-gray-500 text-center text-xs">
                        Connectez-vous à votre espace administrateur
                    </p>

                    {{-- Validation errors --}}
                    @if($errors->any())
                    <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-700 text-xs">
                        <ul class="m-0 pl-4">
                            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                        </ul>
                    </div>
                    @endif

                    {{-- Session status --}}
                    @session('status')
                    <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-700 text-xs">{{ $value }}</div>
                    @endsession

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="grid gap-1.5 mb-4">
                            <label for="email" class="text-gray-800 text-xs font-bold">Adresse e-mail</label>
                            <div class="iw grid grid-cols-[18px_1fr_18px] gap-2.5 items-center min-h-[44px] px-3 border border-gray-200 rounded-lg bg-white transition-all">
                                <svg viewBox="0 0 24 24" stroke-width="1.8" class="w-4 h-4 text-gray-400 stroke-current fill-none">
                                    <path d="M4 4h16v16H4z"/><path d="m22 6-10 7L2 6"/>
                                </svg>
                                <input id="email" name="email" type="email" value="{{ old('email') }}"
                                    placeholder="exemple@tractafric.com"
                                    autocomplete="username" required autofocus
                                    class="w-full border-0 outline-none bg-transparent text-gray-900 text-xs placeholder-gray-400">
                                <span></span>
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="grid gap-1.5 mb-4">
                            <label for="password" class="text-gray-800 text-xs font-bold">Mot de passe</label>
                            <div class="iw grid grid-cols-[18px_1fr_18px] gap-2.5 items-center min-h-[44px] px-3 border border-gray-200 rounded-lg bg-white transition-all">
                                <svg viewBox="0 0 24 24" stroke-width="1.8" class="w-4 h-4 text-gray-400 stroke-current fill-none">
                                    <rect x="5" y="11" width="14" height="10" rx="2"/>
                                    <path d="M8 11V7a4 4 0 0 1 8 0v4"/>
                                </svg>
                                <input id="password" name="password" type="password"
                                    placeholder="Votre mot de passe"
                                    autocomplete="current-password" required
                                    class="w-full border-0 outline-none bg-transparent text-gray-900 text-xs placeholder-gray-400">
                                <button type="button" aria-label="Afficher/masquer le mot de passe"
                                    class="grid place-items-center border-0 p-0 bg-transparent text-gray-400 cursor-pointer hover:text-gray-600"
                                    onclick="var i=this.previousElementSibling;i.type=i.type==='password'?'text':'password'">
                                    <svg viewBox="0 0 24 24" stroke-width="1.8" class="w-4 h-4 stroke-current fill-none">
                                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Remember / Forgot --}}
                        <div class="flex justify-between gap-4 items-center mt-1 mb-5 text-xs">
                            <label class="inline-flex items-center gap-2 text-gray-500 cursor-pointer">
                                <input type="checkbox" name="remember" class="w-4 h-4">
                                Se souvenir de moi
                            </label>
                            @if(Route::has('password.request'))
                            <a class="text-yellow-600 font-bold no-underline text-xs hover:text-yellow-700"
                                href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                            @endif
                        </div>

                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 w-full min-h-[44px] rounded-lg border-0 bg-gradient-to-br from-yellow-400 to-yellow-500 text-gray-900 font-black cursor-pointer text-xs shadow-lg shadow-yellow-400/20 hover:opacity-90 transition-opacity">
                            Se connecter
                            <svg viewBox="0 0 24 24" stroke-width="1.8" class="w-4 h-4 stroke-current fill-none">
                                <path d="M5 12h14"/><path d="m13 6 6 6-6 6"/>
                            </svg>
                        </button>
                    </form>

                    {{-- Divider --}}
                    <div class="grid grid-cols-[1fr_auto_1fr] gap-4 items-center my-5 text-gray-400 text-xs font-black uppercase">
                        <span class="block h-px bg-gray-200"></span>
                        <span class="grid place-items-center w-8 h-8 rounded-full bg-gray-100 text-xs">ou</span>
                        <span class="block h-px bg-gray-200"></span>
                    </div>

                    <button type="button"
                        class="inline-flex items-center justify-center gap-2 w-full min-h-[44px] rounded-lg border border-gray-200 bg-white text-gray-800 font-bold cursor-pointer text-xs hover:bg-gray-50 transition-colors">
                        <svg viewBox="0 0 24 24" stroke-width="1.8" class="w-4 h-4 stroke-current fill-none">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            <path d="M9 12l2 2 4-5"/>
                        </svg>
                        Connexion SSO
                    </button>

                </div>

                <div class="flex justify-center gap-3 items-center px-6 py-4 border-t border-gray-200 bg-gray-50 text-gray-500 text-xs">
                    <svg viewBox="0 0 24 24" stroke-width="1.8" class="w-5 h-5 flex-shrink-0 stroke-current fill-none text-gray-400">
                        <path d="M3 18v-6a9 9 0 0 1 18 0v6"/>
                        <path d="M21 19a2 2 0 0 1-2 2h-1v-7h3v5z"/>
                        <path d="M3 19a2 2 0 0 0 2 2h1v-7H3v5z"/>
                    </svg>
                    <div>
                        <strong class="block text-gray-800 text-xs font-bold">Besoin d'aide ?</strong>
                        <a class="text-yellow-600 font-bold no-underline hover:text-yellow-700 text-xs" href="#">
                            Contacter l'administrateur
                        </a>
                    </div>
                </div>

            </div>
        </section>

    </main>
</x-guest-layout>
