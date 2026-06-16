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
</head>

<body class="font-sans antialiased bg-[#E8EAED] text-[#1d1f23]">
    <x-banner />

    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">

        {{-- Sidebar (Livewire) --}}
        @livewire('navigation-menu')

        {{-- Mobile sidebar backdrop --}}
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
            class="fixed inset-0 z-30 bg-slate-900/40 lg:hidden"></div>

        {{-- Main column --}}
        <div class="flex min-w-0 flex-1 flex-col lg:ml-[240px]">

            {{-- Topbar --}}
            @include('partials.topbar')

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
        </div>
    </div>

    @stack('modals')

    @livewireScripts
</body>

</html>