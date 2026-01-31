@php
    $navItems = [
        [
            'label' => 'Dashboard',
            'icon' => 'home',
            'route' => 'superadmin.dashboard',
            'patterns' => ['superadmin.dashboard'],
            'color' => 'text-blue-600',
            'bg' => 'bg-blue-50',
        ],
        [
            'label' => 'Admins',
            'icon' => 'users',
            'route' => 'superadmin.admins.index',
            'patterns' => ['superadmin.admins.*'],
            'color' => 'text-emerald-600',
            'bg' => 'bg-emerald-50',
        ],
    ];

    $iconSvgs = [
        'home' =>
            '<svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 10.5 12 3l9 7.5V21a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1v-10.5z" /></svg>',
        'clipboard' =>
            '<svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5h6" /><path d="M9 3h6a2 2 0 0 1 2 2v2H7V5a2 2 0 0 1 2-2z" /><rect x="5" y="7" width="14" height="14" rx="2" /></svg>',
        'users' =>
            '<svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 11V7a4 4 0 0 0-8 0v4" /><rect x="5" y="11" width="14" height="10" rx="2" /></svg>',
    ];
@endphp

<!-- DESKTOP SIDEBAR -->
<aside class="hidden w-72 shrink-0 border-r border-slate-200 bg-white md:flex md:flex-col">
    <!-- Brand -->
    <div class="flex items-center gap-3 px-6 py-5">
        <div class="grid h-10 w-10 place-items-center rounded-xl bg-slate-900 text-white">TM</div>
        <div class="leading-tight">
            <div class="text-sm font-semibold">Task Manager</div>
            <div class="text-xs text-slate-500">Admin Panel</div>
        </div>
    </div>

    <div class="px-6 pb-4">
        <div class="text-xs font-semibold tracking-widest text-slate-400">NAVIGATION</div>
    </div>

    <!-- Nav -->
    <nav class="flex-1 space-y-1 px-4 pb-6">
        @foreach ($navItems as $item)
            @php
                $isActive = false;
                if (isset($item['patterns'])) {
                    foreach ((array) $item['patterns'] as $pattern) {
                        if (request()->routeIs($pattern)) {
                            $isActive = true;
                            break;
                        }
                    }
                } elseif (isset($item['route'])) {
                    $isActive = request()->routeIs($item['route']);
                }
                $iconColor = $item['color'] ?? 'text-slate-600';
                $iconBg = $item['bg'] ?? 'bg-slate-100';
            @endphp

            <a href="{{ isset($item['route']) ? route($item['route']) : '#' }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ $isActive ? 'border border-slate-200 bg-slate-50 font-semibold text-slate-900 shadow-sm' : 'text-slate-700 hover:bg-slate-50 hover:translate-x-1 transition-all duration-200' }}">
                <span class="grid h-9 w-9 place-items-center rounded-xl {{ $iconBg }} {{ $iconColor }}">
                    {!! $iconSvgs[$item['icon']] ?? '' !!}
                </span>
                {{ $item['label'] }}
            </a>

            @if (!empty($item['children']))
                <div class="ml-12 space-y-1">
                    @foreach ($item['children'] as $child)
                        <a href="{{ route($child['route']) }}"
                            class="block rounded-lg px-3 py-2 text-xs text-slate-600 hover:bg-slate-50">
                            {{ $child['label'] }}
                        </a>
                    @endforeach
                </div>
            @endif
        @endforeach
    </nav>
</aside>
