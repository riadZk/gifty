<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    @stack('styles')
</head>

<body class="font-sans antialiased text-[#1d1f23]" style="background-color: #f9fbfe; overflow-x: hidden;">
    <x-banner />

    <div x-data="{ mobileMenuOpen: false }" class="min-h-screen">

        {{-- Topnav (Livewire) --}}
        @livewire('navigation-menu')

        {{-- Main column --}}
        <div class="flex flex-col">

            {{-- Page Heading (optional slot) --}}
            @if (isset($header))
                <header class="mx-4 mt-6 rounded-3xl bg-white px-6 py-5 shadow-sm sm:mx-6 lg:mx-8">
                    {{ $header }}
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="mt-auto px-4 py-4 sm:px-6 lg:px-8">
                <div
                    class="flex flex-wrap items-center justify-between gap-2 border-t border-slate-200/60 pt-4 text-[11.5px] text-slate-400">
                    <span>&copy; {{ date('Y') }} <strong class="font-semibold text-slate-500">PCC Fidélité</strong>.
                        Tous droits réservés.</span>
                    <span>v1.0.0</span>
                </div>
            </footer>
        </div>
    </div>

    @stack('modals')

    @livewireScripts
    @stack('scripts')
</body>

</html>
