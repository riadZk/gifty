@php
$user = Auth::user();
@endphp

<header
    class="sticky top-4 z-20 mx-4 mt-4 flex h-[64px] items-center gap-3 rounded-3xl bg-white px-4 shadow-sm sm:mx-6 sm:px-6 lg:mx-6 lg:mt-4 lg:mr-6">

    {{-- Mobile sidebar toggle (controls parent x-data) --}}
    <button type="button" @click="sidebarOpen = true" aria-label="Ouvrir le menu"
        class="inline-grid h-10 w-10 place-items-center rounded-full bg-slate-100/70 text-slate-600 transition hover:bg-pcc-yellow/15 hover:text-pcc-yellow lg:hidden">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" class="h-4 w-4">
            <path d="M3 6h18M3 12h18M3 18h18" />
        </svg>
    </button>

    {{-- Search --}}
    <label class="relative ml-1 flex w-full max-w-md items-center">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
            stroke-linejoin="round" class="pointer-events-none absolute left-3 h-4 w-4 text-slate-400"
            aria-hidden="true">
            <circle cx="11" cy="11" r="7" />
            <path d="m20 20-3.5-3.5" />
        </svg>
        <input type="search" placeholder="Rechercher..."
            class="h-11 w-full rounded-2xl border-0 bg-slate-100/70 pl-9 pr-16 text-[13px] text-slate-700 placeholder:text-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pcc-yellow/40" />
        <span
            class="pointer-events-none absolute right-3 hidden items-center gap-1 rounded-lg bg-white px-1.5 py-0.5 text-[10px] font-semibold text-slate-400 shadow-sm sm:inline-flex">
            <kbd class="font-sans">⌘</kbd><kbd class="font-sans">F</kbd>
        </span>
    </label>

    {{-- Right cluster --}}
    <div class="ml-auto flex items-center gap-2 sm:gap-3">

        {{-- Messages --}}
        <button type="button" aria-label="Messages"
            class="inline-grid h-10 w-10 place-items-center rounded-full bg-slate-100/70 text-slate-600 transition hover:bg-pcc-yellow/15 hover:text-pcc-yellow">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                stroke-linejoin="round" class="h-4 w-4" aria-hidden="true">
                <path d="M4 6h16v12H4z" />
                <path d="m4 6 8 7 8-7" />
            </svg>
        </button>

        {{-- Notifications --}}
        <button type="button" aria-label="Notifications"
            class="relative inline-grid h-10 w-10 place-items-center rounded-full bg-slate-100/70 text-slate-600 transition hover:bg-pcc-yellow/15 hover:text-pcc-yellow">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                stroke-linejoin="round" class="h-4 w-4" aria-hidden="true">
                <path d="M18 8a6 6 0 1 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9" />
                <path d="M13.7 21a2 2 0 0 1-3.4 0" />
            </svg>
            <span
                class="absolute -right-0.5 -top-0.5 grid h-4 min-w-[16px] place-items-center rounded-full bg-pcc-yellow px-1 text-[10px] font-black leading-none text-[#101820]">8</span>
        </button>

        {{-- Profile --}}
        <x-dropdown align="right" width="56">
            <x-slot name="trigger">
                <button type="button"
                    class="flex items-center gap-2 rounded-full bg-slate-100/70 py-1 pl-1 pr-3 transition hover:bg-pcc-yellow/15">
                    @if ($user && $user->profile_photo_url)
                    <img class="h-8 w-8 rounded-full object-cover" src="{{ $user->profile_photo_url }}"
                        alt="{{ $user->name }}">
                    @else
                    <span
                        class="grid h-8 w-8 place-items-center rounded-full bg-pcc-yellow text-[12px] font-bold text-[#101820]">
                        {{ $user ? strtoupper(substr($user->name, 0, 1)) : '?' }}
                    </span>
                    @endif
                    <span class="hidden flex-col text-left leading-tight sm:flex">
                        <span class="text-[13px] font-bold text-slate-800">{{ $user?->name }}</span>
                        <span class="text-[11px] text-slate-500">{{ $user?->email }}</span>
                    </span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="hidden h-3 w-3 text-slate-400 sm:block" aria-hidden="true">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <div class="block px-4 py-3">
                    <div class="text-[13px] font-bold text-slate-800">{{ $user?->name }}</div>
                    <div class="text-[11px] text-slate-500">{{ $user?->email }}</div>
                </div>

                <x-dropdown-link href="{{ route('profile.show') }}">{{ __('Profile') }}</x-dropdown-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                <x-dropdown-link href="{{ route('api-tokens.index') }}">{{ __('API Tokens') }}</x-dropdown-link>
                @endif

                <div class="mx-3 my-1 h-px bg-slate-100"></div>

                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</header>