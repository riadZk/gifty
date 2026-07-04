<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>503 — Service Unavailable</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@700;900&family=Manrope:wght@400;600&display=swap"
        rel="stylesheet">

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Manrope', sans-serif;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow: hidden;
            text-align: center;
            padding: 1.5rem;
        }

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
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 900;
            font-size: clamp(7rem, 24vw, 16rem);
            line-height: 1;
            letter-spacing: -0.05em;
            user-select: none;
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

        /* Progress bar (maintenance countdown feel) */
        @keyframes progress {
            0% {
                width: 0%;
            }

            100% {
                width: 100%;
            }
        }

        .progress-bar {
            height: 4px;
            border-radius: 9999px;
            background: #FFC60B;
            animation: progress 8s ease-in-out infinite;
        }

        @keyframes pulse-dot {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.4;
                transform: scale(0.75);
            }
        }

        .dot-1 {
            animation: pulse-dot 1.2s ease-in-out 0s infinite;
        }

        .dot-2 {
            animation: pulse-dot 1.2s ease-in-out 0.2s infinite;
        }

        .dot-3 {
            animation: pulse-dot 1.2s ease-in-out 0.4s infinite;
        }

        .blob-bg {
            position: fixed;
            pointer-events: none;
            border-radius: 9999px;
            filter: blur(80px);
        }

        @media (prefers-reduced-motion: reduce) {

            .fade-up,
            .fade-up-2,
            .fade-up-3,
            .fade-up-4,
            .gradient-code,
            .progress-bar,
            .dot-1,
            .dot-2,
            .dot-3 {
                animation: none;
            }
        }
    </style>
</head>

<body>
    <div class="blob-bg" style="width:18rem;height:18rem;top:-3rem;left:-3rem;background:rgba(255,198,11,0.22);"></div>
    <div class="blob-bg"
        style="width:20rem;height:20rem;bottom:-4rem;right:-2rem;background:rgba(255,198,11,0.14);animation:blob 18s ease-in-out infinite reverse;">
    </div>

    <div
        style="position:relative;z-index:10;display:flex;flex-direction:column;align-items:center;max-width:28rem;width:100%;">

        <!-- Floating icon -->
        <div class="fade-up"
            style="animation:float 5s ease-in-out infinite,fade-up 0.7s cubic-bezier(0.22,1,0.36,1) both;margin-bottom:0.5rem;">
            <div
                style="width:6rem;height:6rem;border-radius:9999px;background:rgba(255,198,11,0.15);display:flex;align-items:center;justify-content:center;">
                <svg style="width:3rem;height:3rem;" fill="none" stroke="#FFC60B" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                </svg>
            </div>
        </div>

        <!-- Error code -->
        <h1 class="fade-up gradient-code">503</h1>

        <!-- Heading -->
        <h2 class="fade-up-2"
            style="margin-top:-0.5rem;font-family:'Space Grotesk',sans-serif;font-size:1.75rem;font-weight:700;letter-spacing:-0.02em;color:#000;">
            Under Maintenance
        </h2>

        <!-- Description -->
        <p class="fade-up-3" style="margin-top:0.75rem;font-size:1rem;line-height:1.75;color:#6b7280;max-width:22rem;">
            We're performing scheduled maintenance to improve your experience.
            We'll be back shortly!
        </p>

        <!-- Animated progress bar -->
        <div class="fade-up-3"
            style="margin-top:2rem;width:100%;max-width:18rem;background:#f3f4f6;border-radius:9999px;overflow:hidden;">
            <div class="progress-bar"></div>
        </div>

        <!-- Pulsing dots -->
        <div class="fade-up-3" style="display:flex;gap:0.5rem;margin-top:1rem;align-items:center;">
            <div class="dot-1" style="width:8px;height:8px;border-radius:9999px;background:#FFC60B;"></div>
            <div class="dot-2" style="width:8px;height:8px;border-radius:9999px;background:#FFC60B;"></div>
            <div class="dot-3" style="width:8px;height:8px;border-radius:9999px;background:#FFC60B;"></div>
            <span style="margin-left:0.5rem;font-size:0.8rem;color:#9ca3af;">Working on it…</span>
        </div>

        <!-- Button -->
        <div class="fade-up-4" style="margin-top:2.5rem;">
            <a href="javascript:location.reload()"
                style="display:inline-flex;align-items:center;gap:0.5rem;border-radius:0.75rem;padding:0.75rem 1.75rem;font-size:0.875rem;font-weight:600;color:#000;background:#FFC60B;box-shadow:0 8px 24px rgba(255,198,11,0.35);text-decoration:none;transition:transform 0.15s,box-shadow 0.15s;"
                onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 32px rgba(255,198,11,0.45)'"
                onmouseout="this.style.transform='';this.style.boxShadow='0 8px 24px rgba(255,198,11,0.35)'">
                <svg style="width:1rem;height:1rem;" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Check again
            </a>
        </div>

    </div>
</body>

</html>
