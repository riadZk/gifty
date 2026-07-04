<x-app-layout>

    @php
        $nav = [
            [
                'route' => 'config.profile',
                'label' => __('config.nav_profile'),
                'icon' => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
            ],
            [
                'route' => 'config.points-rules',
                'label' => __('config.nav_points_rules'),
                'icon' =>
                    '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>',
            ],
            [
                'route' => 'config.bonus-levels',
                'label' => __('config.nav_bonus_levels'),
                'icon' =>
                    '<polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/>',
            ],
        ];
    @endphp

    <div class="mx-auto max-w-[110rem] flex gap-6">

        {{-- ══ Sidebar ══ --}}
        <aside class="w-72 shrink-0">
            <div class="sticky top-20 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 px-5 py-4">
                    <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">
                        {{ __('config.sidebar_title') }}</p>
                </div>
                <nav class="p-3 space-y-1">
                    @foreach ($nav as $item)
                        @php $active = request()->routeIs($item['route']); @endphp
                        <a href="{{ route($item['route']) }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 text-[13px] font-semibold transition
                                {{ $active ? 'bg-amber-50 text-slate-900' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                            <span
                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg
                                {{ $active ? 'bg-amber-400 text-white' : 'bg-slate-100 text-slate-400' }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="h-4 w-4">{!! $item['icon'] !!}</svg>
                            </span>
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>
            </div>
        </aside>

        {{-- ══ Main content ══ --}}
        <div class="min-w-0 flex-1">
            {{ $slot }}
        </div>

    </div>

</x-app-layout>
