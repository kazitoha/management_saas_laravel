@php
    $navItems = [
        [
            'label' => 'Dashboard',
            'icon' => 'home',
            'route' => 'dashboard',
            'patterns' => ['dashboard'],
            'icon_theme' => 'default', // optional (for icon box color)
        ],
        [
            'label' => 'Projects',
            'icon' => 'folder',
            'route' => 'projects.index',
            'patterns' => ['projects.*'],
            'icon_theme' => 'emerald', // optional (for icon box color)
        ],
        // [
        //     'label' => 'My Tasks',
        //     'icon' => 'home',
        //     'route' => 'dashboard',
        //     'patterns' => ['dashboard'],
        //     'icon_theme' => 'default', // optional (for icon box color)
        // ],
        // [
        //     'label' => 'Attendance',
        //     'icon' => 'home',
        //     'route' => 'dashboard',
        //     'patterns' => ['dashboard'],
        //     'icon_theme' => 'default', // optional (for icon box color)
        // ],
        // [
        //     'label' => 'Conveyance',
        //     'icon' => 'home',
        //     'route' => 'dashboard',
        //     'patterns' => ['dashboard'],
        //     'icon_theme' => 'default', // optional (for icon box color)
        // ],
        // [
        //     'label' => 'Leave',
        //     'icon' => 'home',
        //     'route' => 'dashboard',
        //     'patterns' => ['dashboard'],
        //     'icon_theme' => 'default', // optional (for icon box color)
        // ],
        [
            'label' => 'Clients',
            'icon' => 'users',
            'route' => 'clients.index',
            'patterns' => ['clients.*'],
            'icon_theme' => 'emerald', // optional (for icon box color)
        ],
        // [
        //     'label' => 'Quotations',
        //     'icon' => 'home',
        //     'route' => 'dashboard',
        //     'patterns' => ['dashboard'],
        //     'icon_theme' => 'default', // optional (for icon box color)
        // ],
        // [
        //     'label' => 'Bills',
        //     'icon' => 'home',
        //     'route' => 'dashboard',
        //     'patterns' => ['dashboard'],
        //     'icon_theme' => 'default', // optional (for icon box color)
        // ],
        // [
        //     'label' => 'Routine',
        //     'icon' => 'home',
        //     'route' => 'dashboard',
        //     'patterns' => ['dashboard'],
        //     'icon_theme' => 'default', // optional (for icon box color)
        // ],
        // [
        //     'label' => 'Notes',
        //     'icon' => 'home',
        //     'route' => 'dashboard',
        //     'patterns' => ['dashboard'],
        //     'icon_theme' => 'default', // optional (for icon box color)
        // ],
        // [
        //     'label' => 'Reminders',
        //     'icon' => 'home',
        //     'route' => 'dashboard',
        //     'patterns' => ['dashboard'],
        //     'icon_theme' => 'default', // optional (for icon box color)
        // ],
        // [
        //     'label' => 'Files',
        //     'icon' => 'home',
        //     'route' => 'dashboard',
        //     'patterns' => ['dashboard'],
        //     'icon_theme' => 'default', // optional (for icon box color)
        // ],
        // admins Settings
        // [
        //     'label' => 'All Tasks',
        //     'icon' => 'home',
        //     'route' => 'dashboard',
        //     'patterns' => ['dashboard'],
        //     'icon_theme' => 'default', // optional (for icon box color)
        // ],
        // [
        //     'label' => 'View Attendance',
        //     'icon' => 'home',
        //     'route' => 'dashboard',
        //     'patterns' => ['dashboard'],
        //     'icon_theme' => 'default', // optional (for icon box color)
        // ],
        // [
        //     'label' => 'Leave Requests',
        //     'icon' => 'home',
        //     'route' => 'dashboard',
        //     'patterns' => ['dashboard'],
        //     'icon_theme' => 'default', // optional (for icon box color)
        // ],
        // [
        //     'label' => 'Leave Types',
        //     'icon' => 'home',
        //     'route' => 'dashboard',
        //     'patterns' => ['dashboard'],
        //     'icon_theme' => 'default', // optional (for icon box color)
        // ],
        // [
        //     'label' => 'Users',
        //     'icon' => 'home',
        //     'route' => 'dashboard',
        //     'patterns' => ['dashboard'],
        //     'icon_theme' => 'default', // optional (for icon box color)
        // ],
        // [
        //     'label' => 'Accounts',
        //     'icon' => 'home',
        //     'route' => 'dashboard',
        //     'patterns' => ['dashboard'],
        //     'icon_theme' => 'default', // optional (for icon box color)
        // ],
        // [
        //     'label' => 'Conveyance',
        //     'icon' => 'home',
        //     'route' => 'dashboard',
        //     'patterns' => ['dashboard'],
        //     'icon_theme' => 'default', // optional (for icon box color)
        // ],
        // [
        //     'label' => 'Incomes',
        //     'icon' => 'home',
        //     'route' => 'dashboard',
        //     'patterns' => ['dashboard'],
        //     'icon_theme' => 'default', // optional (for icon box color)
        // ],
        // [
        //     'label' => 'Expenses',
        //     'icon' => 'home',
        //     'route' => 'dashboard',
        //     'patterns' => ['dashboard'],
        //     'icon_theme' => 'default', // optional (for icon box color)
        // ],
    ];
@endphp

@php
    $user = auth()->user();

    // Active check for parent items (uses patterns + route)
    $isItemActive = function (array $item): bool {
        $patterns = $item['patterns'] ?? [];
        if (!empty($item['route'])) {
            $patterns[] = $item['route'];
        }
        return !empty($patterns) ? request()->routeIs($patterns) : false;
    };

    // Active check for children
    $isChildActive = fn(array $child): bool => request()->routeIs($child['route']);

    // Parent open if itself or any child active
    $hasActiveChild = function (array $item) use ($isChildActive): bool {
        foreach ($item['children'] ?? [] as $child) {
            if ($isChildActive($child)) {
                return true;
            }
        }
        return false;
    };

    // Permission filter (same logic as your old code)
    $navItems = array_values(
        array_filter($navItems, function (array $item) use ($user) {
            if (!$user) {
                return true;
            }

            $routes = [];
            if (!empty($item['route'])) {
                $routes[] = $item['route'];
            }
            foreach ($item['children'] ?? [] as $child) {
                $routes[] = $child['route'];
            }

            if (empty($routes)) {
                return true;
            }

            foreach ($routes as $r) {
                if (permissionExists($r)) {
                    return true;
                }
            }
            return false;
        }),
    );

    // Styles for this specific design
    $linkClass = function (bool $active) {
        return $active
            ? 'flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-900 shadow-sm transition-all duration-200 hover:shadow-md'
            : 'flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-all duration-200 hover:translate-x-1';
    };

    $summaryClass = function (bool $active) {
        return $active
            ? 'flex cursor-pointer items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-900 shadow-sm transition-all duration-200 list-none'
            : 'flex cursor-pointer items-center justify-between gap-3 rounded-xl px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-all duration-200 hover:translate-x-1 list-none';
    };

    $childLinkClass = function (bool $active) {
        return $active
            ? 'block rounded-xl bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-900'
            : 'block rounded-xl px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:translate-x-1 transition-all';
    };

    // Quick icon color mapping (optional). You can add more.
    $iconBox = function (string $key, bool $active) {
        // keep your design colors: blue for active primary, orange for dropdown parent, etc.
        if ($active) {
            return 'bg-blue-50 text-blue-600';
        }
        return match ($key) {
            'orange' => 'bg-orange-50 text-orange-600',
            'emerald' => 'bg-emerald-50 text-emerald-600',
            default => 'bg-slate-50 text-slate-700',
        };
    };

    // Minimal inline SVG icons by name (to match your old “svg icon design”)
    // Add more icons as needed.
    $iconSvg = function (string $name) {
        return match ($name) {
            'home'
                => '<svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 10.5 12 3l9 7.5V21a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1v-10.5z"/></svg>',
            'users'
                => '<svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
            'shield'
                => '<svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l8 4v6c0 5-3.5 9.4-8 10-4.5-.6-8-5-8-10V6l8-4z"/></svg>',
            'user'
                => '<svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4"/></svg>',
            'folder'
                => '<svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7a2 2 0 0 1 2-2h5l2 2h7a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>',
            default
                => '<svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7h18M3 12h18M3 17h18"/></svg>',
        };
    };
@endphp

<!-- DESKTOP SIDEBAR (dynamic) -->
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
                $hasChildren = !empty($item['children'] ?? []);
                $active = $isItemActive($item);
                $open = $active || $hasActiveChild($item);

                // Optional: per-item icon color key (set this in your navItems: 'icon_theme' => 'orange')
                $iconTheme = $item['icon_theme'] ?? ($hasChildren ? 'orange' : 'default');
            @endphp

            @if (!$hasChildren)
                <a href="{{ route($item['route']) }}" class="{{ $linkClass($active) }}">
                    <span
                        class="grid h-9 w-9 place-items-center rounded-xl transition-all duration-200 {{ $iconBox($iconTheme, $active) }}">
                        {!! $iconSvg($item['icon']) !!}
                    </span>
                    {{ $item['label'] }}
                </a>
            @else
                <details class="group" {{ $open ? 'open' : '' }}>
                    <summary class="{{ $summaryClass($active) }}">
                        <span class="flex items-center gap-3">
                            <span
                                class="grid h-9 w-9 place-items-center rounded-xl {{ $iconBox($iconTheme, $active) }}">
                                {!! $iconSvg($item['icon']) !!}
                            </span>
                            {{ $item['label'] }}
                        </span>

                        <!-- Arrow Icon -->
                        <svg class="h-4 w-4 text-slate-400 transition-transform duration-200 group-open:rotate-180"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M6 9l6 6 6-6" />
                        </svg>
                    </summary>

                    <!-- Submenu -->
                    <div class="mt-1 space-y-1 pl-12">
                        @foreach ($item['children'] as $child)
                            @if ($user && !permissionExists($child['route']))
                                @continue
                            @endif

                            @php $childActive = $isChildActive($child); @endphp

                            <a href="{{ route($child['route']) }}" class="{{ $childLinkClass($childActive) }}">
                                {{ $child['label'] }}
                            </a>
                        @endforeach
                    </div>
                </details>
            @endif
        @endforeach
    </nav>
</aside>

{{-- Optional: remove default marker triangle for summary --}}
<style>
    summary::-webkit-details-marker {
        display: none;
    }
</style>
