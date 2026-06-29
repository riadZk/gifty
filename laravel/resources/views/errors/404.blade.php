<x-app-layout>
    <style>
        @keyframes cloud-drift   { 0%,100%{transform:translateX(0)} 50%{transform:translateX(10px)} }
        @keyframes cloud-drift-r { 0%,100%{transform:translateX(0)} 50%{transform:translateX(-8px)} }
        @keyframes cone-bob      { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-5px)} }
        @keyframes deco-blink    { 0%,100%{opacity:.35;transform:scale(1)} 50%{opacity:.9;transform:scale(1.2)} }
        @keyframes num-pulse     { 0%,100%{transform:scale(1)} 50%{transform:scale(1.025)} }
        .cl1 { animation: cloud-drift   5s   ease-in-out infinite; }
        .cl2 { animation: cloud-drift-r 6.5s ease-in-out infinite; }
        .cl3 { animation: cloud-drift   8s   ease-in-out infinite 1.5s; }
        .cb  { animation: cone-bob      3s   ease-in-out infinite; }
        .db  { animation: deco-blink    2.8s ease-in-out infinite; }
        .n4  { display:inline-block; animation: num-pulse 4s ease-in-out infinite; }
    </style>

    <div class="flex flex-col items-center justify-center py-10 px-4" style="min-height:calc(100vh - 180px)">

        <h1 class="n4 text-[7rem] sm:text-[8.5rem] font-black leading-none tracking-tighter text-[#1a1d23]">404</h1>
        <h2 class="text-2xl sm:text-3xl font-bold text-[#1a1d23] -mt-3">Page non trouvée</h2>
        <p class="mt-3 text-center text-slate-400 text-sm max-w-xs leading-relaxed">
            Désolé, la page que vous recherchez n'existe pas<br>ou a été déplacée.
        </p>

        <div class="w-full max-w-lg my-8 select-none">
            <svg viewBox="0 0 560 305" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto">
                <defs>
                    <pattern id="bp" width="28" height="28" patternUnits="userSpaceOnUse" patternTransform="rotate(-45)">
                        <rect width="14" height="28" fill="#111827"/>
                        <rect x="14" width="14" height="28" fill="#FBBF24"/>
                    </pattern>
                    <clipPath id="bc"><rect x="40" y="150" width="138" height="92" rx="6"/></clipPath>
                </defs>

                <!-- Decorative shapes -->
                <circle cx="30" cy="162" r="13" stroke="#60A5FA" stroke-width="2.5" class="db" style="animation-delay:.5s"/>
                <g class="db" style="animation-delay:.3s">
                    <rect x="104" y="20" width="3" height="16" rx="1.5" fill="#60A5FA"/>
                    <rect x="98"  y="26" width="16" height="3"  rx="1.5" fill="#60A5FA"/>
                </g>
                <g class="db" style="animation-delay:1s">
                    <rect x="408" y="28" width="3"  height="18" rx="1.5" fill="#FBBF24"/>
                    <rect x="401" y="35" width="17" height="3"  rx="1.5" fill="#FBBF24"/>
                </g>
                <g class="db" style="animation-delay:.7s">
                    <line x1="500" y1="68" x2="514" y2="82" stroke="#FBBF24" stroke-width="2.5" stroke-linecap="round"/>
                    <line x1="514" y1="68" x2="500" y2="82" stroke="#FBBF24" stroke-width="2.5" stroke-linecap="round"/>
                </g>
                <circle cx="520" cy="200" r="11" stroke="#FBBF24" stroke-width="2.5" class="db" style="animation-delay:1.3s"/>
                <circle cx="168" cy="54"  r="4"  fill="#BFDBFE" class="db" style="animation-delay:.15s"/>
                <circle cx="458" cy="128" r="3.5" fill="#FDE68A" class="db" style="animation-delay:.8s"/>

                <!-- Clouds -->
                <g class="cl1">
                    <ellipse cx="76" cy="64" rx="30" ry="19" fill="white"/>
                    <ellipse cx="56" cy="71" rx="20" ry="15" fill="white"/>
                    <ellipse cx="98" cy="71" rx="20" ry="15" fill="white"/>
                    <ellipse cx="76" cy="77" rx="34" ry="12" fill="white"/>
                </g>
                <g class="cl2">
                    <ellipse cx="266" cy="42" rx="36" ry="22" fill="white"/>
                    <ellipse cx="244" cy="50" rx="24" ry="16" fill="white"/>
                    <ellipse cx="290" cy="50" rx="24" ry="16" fill="white"/>
                    <ellipse cx="266" cy="57" rx="42" ry="13" fill="white"/>
                </g>
                <g class="cl3">
                    <ellipse cx="430" cy="54" rx="28" ry="17" fill="white"/>
                    <ellipse cx="412" cy="60" rx="19" ry="13" fill="white"/>
                    <ellipse cx="450" cy="60" rx="19" ry="13" fill="white"/>
                    <ellipse cx="430" cy="66" rx="33" ry="11" fill="white"/>
                </g>

                <!-- Ground shadow -->
                <ellipse cx="278" cy="284" rx="242" ry="17" fill="#D1D9E6"/>

                <!-- Barricade -->
                <rect x="70"  y="240" width="11" height="44" rx="3" fill="#9CA3AF"/>
                <rect x="157" y="240" width="11" height="44" rx="3" fill="#9CA3AF"/>
                <rect x="62"  y="278" width="27" height="9"  rx="3" fill="#9CA3AF"/>
                <rect x="149" y="278" width="27" height="9"  rx="3" fill="#9CA3AF"/>
                <rect x="40" y="150" width="138" height="92" rx="6" fill="url(#bp)" clip-path="url(#bc)"/>
                <rect x="40" y="150" width="138" height="92" rx="6" stroke="#CBD5E1" stroke-width="1.5"/>
                <rect x="40" y="182" width="138" height="34" fill="white" opacity="0.88"/>
                <text x="109" y="208" text-anchor="middle" font-size="26" font-weight="900"
                      fill="#111827" font-family="Manrope,sans-serif" letter-spacing="1">404</text>

                <!-- Excavator Tracks -->
                <rect x="190" y="247" width="204" height="28" rx="14" fill="#1F2937"/>
                <rect x="198" y="252" width="188" height="18" rx="9"  fill="#374151"/>
                <rect x="202" y="252" width="19"  height="18" rx="2"  fill="#1F2937"/>
                <rect x="227" y="252" width="19"  height="18" rx="2"  fill="#1F2937"/>
                <rect x="252" y="252" width="19"  height="18" rx="2"  fill="#1F2937"/>
                <rect x="277" y="252" width="19"  height="18" rx="2"  fill="#1F2937"/>
                <rect x="302" y="252" width="19"  height="18" rx="2"  fill="#1F2937"/>
                <rect x="327" y="252" width="19"  height="18" rx="2"  fill="#1F2937"/>
                <rect x="352" y="252" width="19"  height="18" rx="2"  fill="#1F2937"/>
                <rect x="369" y="252" width="16"  height="18" rx="2"  fill="#1F2937"/>
                <circle cx="203" cy="261" r="13" fill="#111827"/>
                <circle cx="203" cy="261" r="6"  fill="#374151"/>
                <circle cx="381" cy="261" r="13" fill="#111827"/>
                <circle cx="381" cy="261" r="6"  fill="#374151"/>
                <circle cx="292" cy="257" r="9"  fill="#2D3748"/>
                <!-- Chassis -->
                <rect x="210" y="228" width="174" height="24" rx="5" fill="#FBBF24"/>
                <rect x="210" y="244" width="174" height="6"  rx="0" fill="#D97706"/>
                <!-- Upper body -->
                <rect x="218" y="195" width="168" height="37" rx="6" fill="#FBBF24"/>
                <rect x="218" y="224" width="168" height="6"  fill="#D97706"/>
                <!-- Counterweight -->
                <rect x="216" y="199" width="30"  height="24" rx="5" fill="#D97706"/>
                <!-- Cab -->
                <rect x="294" y="165" width="90"  height="44" rx="7" fill="#FBBF24"/>
                <rect x="299" y="165" width="80"  height="10" rx="5" fill="#D97706"/>
                <rect x="302" y="172" width="56"  height="29" rx="4" fill="#7BAED4"/>
                <rect x="306" y="175" width="20"  height="12" rx="2" fill="white" opacity="0.45"/>
                <rect x="296" y="201" width="88"  height="6"  fill="#D97706"/>

                <!-- Arm group with digging animation -->
                <g>
                    <path d="M 246,213 L 259,200 L 170,114 L 157,127 Z" fill="#FBBF24"/>
                    <path d="M 249,210 L 257,205 L 196,145 L 188,150 Z" fill="#94A3B8" opacity="0.75"/>
                    <circle cx="164" cy="120" r="8" fill="#D97706"/>
                    <path d="M 157,123 L 170,117 L 136,194 L 123,200 Z" fill="#FBBF24"/>
                    <path d="M 161,121 L 168,118 L 141,188 L 134,191 Z" fill="#94A3B8" opacity="0.75"/>
                    <circle cx="129" cy="197" r="6" fill="#D97706"/>
                    <path d="M 110,185 L 150,185 L 146,212 Q 130,226 114,212 Z" fill="#374151"/>
                    <path d="M 110,185 L 114,212 Q 130,226 146,212 L 150,185" stroke="#1F2937" stroke-width="1.5"/>
                    <path d="M 114,212 L 112,223" stroke="#4B5563" stroke-width="3.5" stroke-linecap="round"/>
                    <path d="M 122,218 L 120,229" stroke="#4B5563" stroke-width="3.5" stroke-linecap="round"/>
                    <path d="M 130,220 L 128,231" stroke="#4B5563" stroke-width="3.5" stroke-linecap="round"/>
                    <path d="M 138,219 L 136,230" stroke="#4B5563" stroke-width="3.5" stroke-linecap="round"/>
                    <path d="M 146,215 L 144,225" stroke="#4B5563" stroke-width="3.5" stroke-linecap="round"/>
                    <animateTransform attributeName="transform" type="rotate"
                        values="-5 252 205; 9 252 205; -5 252 205"
                        dur="3s" repeatCount="indefinite"
                        calcMode="spline" keySplines="0.45 0 0.55 1;0.45 0 0.55 1"/>
                </g>

                <!-- Traffic Cones -->
                <g class="cb" style="animation-delay:.4s" transform="translate(417,232)">
                    <rect x="-15" y="36" width="30" height="9" rx="3" fill="#C2410C"/>
                    <polygon points="0,0 -13,36 13,36" fill="#F97316"/>
                    <rect x="-7" y="14" width="14" height="6" rx="1" fill="white" opacity="0.6"/>
                </g>
                <g class="cb" style="animation-delay:1.1s" transform="translate(455,237)">
                    <rect x="-13" y="31" width="26" height="8" rx="3" fill="#C2410C"/>
                    <polygon points="0,0 -11,31 11,31" fill="#F97316"/>
                    <rect x="-6" y="11" width="12" height="5" rx="1" fill="white" opacity="0.6"/>
                </g>
            </svg>
        </div>

        <!-- Help card -->
        <div class="flex items-start gap-4 rounded-2xl border border-blue-100 bg-blue-50 px-5 py-4 max-w-sm w-full mb-6">
            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold text-xl leading-none">?</div>
            <div>
                <p class="font-semibold text-slate-800 text-sm">Besoin d'aide ?</p>
                <p class="text-slate-500 text-xs mt-0.5 leading-relaxed">Retournez à l'accueil ou contactez l'administrateur.</p>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row items-center gap-3">
            <a href="{{ url('/') }}"
               class="inline-flex items-center gap-2.5 rounded-xl bg-[#1a1d23] px-7 py-3 text-sm font-semibold text-white shadow transition hover:bg-slate-800">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Retour à l'accueil
            </a>
            <a href="javascript:history.back()"
               class="inline-flex items-center gap-2.5 rounded-xl border border-slate-200 bg-white px-7 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Page précédente
            </a>
        </div>

    </div>
</x-app-layout>
