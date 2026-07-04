<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 — Server Error</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@700;900&family=Manrope:wght@400;600&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes fade-up {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-up {
            animation: fade-up 0.7s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        .fade-up-2 {
            animation: fade-up 0.7s 0.12s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        .fade-up-3 {
            animation: fade-up 0.7s 0.24s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        .fade-up-4 {
            animation: fade-up 0.7s 0.36s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        @keyframes gradient-shift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .gradient-code {
            background: linear-gradient(110deg, #FFC60B, #000000, #FFC60B, #b38900, #FFC60B);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            color: transparent;
            animation: gradient-shift 6s ease infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-14px);
            }
        }

        .float {
            animation: float 5s ease-in-out infinite;
        }

        @keyframes shake {

            0%,
            100% {
                transform: rotate(0deg);
            }

            20% {
                transform: rotate(-8deg);
            }

            40% {
                transform: rotate(8deg);
            }

            60% {
                transform: rotate(-5deg);
            }

            80% {
                transform: rotate(5deg);
            }
        }

        .shake-icon {
            animation: float 5s ease-in-out infinite, shake 3s ease-in-out 1s infinite;
        }

        @keyframes blob {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(30px, -20px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.95);
            }
        }

        .blob {
            animation: blob 14s ease-in-out infinite;
            will-change: transform;
        }

        .blob-2 {
            animation: blob 18s ease-in-out infinite reverse;
        }

        @media (prefers-reduced-motion: reduce) {

            .fade-up,
            .fade-up-2,
            .fade-up-3,
            .fade-up-4,
            .gradient-code,
            .float,
            .shake-icon,
            .blob,
            .blob-2 {
                animation: none;
            }
        }
    </style>
</head>

<body class="bg-white antialiased" style="font-family:'Manrope',sans-serif;">

    <div class="relative flex min-h-screen flex-col items-center justify-center overflow-hidden px-6 text-center">

        <div class="blob pointer-events-none absolute -left-20 -top-20 h-72 w-72 rounded-full blur-3xl"
            style="background:rgba(255,198,11,0.25);"></div>
        <div class="blob-2 pointer-events-none absolute -bottom-24 -right-16 h-80 w-80 rounded-full blur-3xl"
            style="background:rgba(255,198,11,0.15);"></div>

        <div class="relative z-10 flex flex-col items-center">

            <!-- Icon -->
            <div class="fade-up mb-2">
                <div class="shake-icon flex h-24 w-24 items-center justify-center rounded-full"
                    style="background:rgba(255,198,11,0.15);">
                    <svg class="h-12 w-12" fill="none" stroke="#FFC60B" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                    </svg>
                </div>
            </div>

            <!-- Error code -->
            <h1 class="fade-up gradient-code select-none text-[clamp(7rem,24vw,16rem)] font-black leading-none tracking-tighter"
                style="font-family:'Space Grotesk',sans-serif;">
                500
            </h1>

            <h2 class="fade-up-2 -mt-2 text-2xl font-bold tracking-tight text-black sm:text-3xl"
                style="font-family:'Space Grotesk',sans-serif;">
                Server Error
            </h2>

            <p class="fade-up-3 mt-3 max-w-sm text-base leading-relaxed text-gray-500">
                Something went wrong on our end. We're already working on it.
                Please try again in a few minutes.
            </p>

            <div class="fade-up-4 mt-10 flex flex-col items-center gap-3 sm:flex-row">
                <a href="javascript:location.reload()"
                    class="group inline-flex items-center gap-2 rounded-xl px-7 py-3 text-sm font-semibold text-black shadow-lg transition hover:-translate-y-0.5 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2"
                    style="background:#FFC60B; box-shadow:0 8px 24px rgba(255,198,11,0.35); --tw-ring-color:#FFC60B;">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Try again
                </a>
                <a href="{{ url('/') }}"
                    class="inline-flex items-center gap-2 rounded-xl border-2 border-black bg-white px-7 py-3 text-sm font-semibold text-black shadow-sm transition hover:-translate-y-0.5 hover:bg-black hover:text-white hover:shadow-md focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Back to home
                </a>
            </div>

        </div>
    </div>

</body>

</html>
