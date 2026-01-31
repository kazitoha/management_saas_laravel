<!-- MOBILE DRAWER OVERLAY -->
<div id="drawerOverlay"
    class="fixed inset-0 z-40 hidden bg-slate-900/50 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>

<!-- MOBILE DRAWER -->
<aside id="mobileDrawer"
    class="fixed left-0 top-0 z-50 h-full w-[86%] max-w-xs -translate-x-full bg-white shadow-xl transition-transform duration-300 md:hidden"
    aria-hidden="true">
    <div class="flex items-center justify-between gap-3 border-b border-slate-200 px-4 py-4">
        <div class="flex items-center gap-3">
            <div class="grid h-10 w-10 place-items-center rounded-xl bg-slate-900 text-white">TM</div>
            <div class="leading-tight">
                <div class="text-sm font-semibold">Task Manager</div>
                <div class="text-xs text-slate-500">Admin Panel</div>
            </div>
        </div>

        <button id="drawerClose"
            class="grid h-10 w-10 place-items-center rounded-xl border border-slate-200 hover:bg-slate-50 transition-all duration-200 hover:border-slate-300 active:scale-95"
            aria-label="Close menu">
            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 6 6 18" />
                <path d="M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="px-4 py-4">
        <div class="text-xs font-semibold tracking-widest text-slate-400">NAVIGATION</div>

        <nav class="mt-4 space-y-1">
            <a href="{{ route('superadmin.dashboard') }}"
                class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-900 shadow-sm">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-blue-50 text-blue-600">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 10.5 12 3l9 7.5V21a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1v-10.5z" />
                    </svg>
                </span>
                Home
            </a>

            <a href="{{ route('superadmin.admins.index') }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-emerald-50 text-emerald-600">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 11V7a4 4 0 0 0-8 0v4" />
                        <rect x="5" y="11" width="14" height="10" rx="2" />
                    </svg>
                </span>
                Admins
            </a>

            <!-- Keep your other nav links (same as desktop) -->
            <a href="#"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-orange-50 text-orange-600">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 7h18M3 12h18M3 17h18" />
                    </svg>
                </span>
                Projects
            </a>

            <a href="#"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-emerald-50 text-emerald-600">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 11l3 3L22 4" />
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                    </svg>
                </span>
                My Tasks
            </a>

            <a href="#"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-lime-50 text-lime-700">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M8 7V3m8 4V3M4 11h16" />
                        <rect x="4" y="7" width="16" height="14" rx="2" />
                    </svg>
                </span>
                Attendance
            </a>

            <a href="#"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-indigo-50 text-indigo-600">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M7 17l10-10M17 17H7V7" />
                    </svg>
                </span>
                Conveyance
            </a>

            <a href="#"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-slate-100 text-slate-700">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 1v22M5 5h14M5 19h14" />
                    </svg>
                </span>
                Leaves
            </a>

            <a href="#"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-pink-50 text-pink-600">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </span>
                Clients
            </a>

            <a href="#"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-violet-50 text-violet-600">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 19.5A2.5 2.5 0 0 0 6.5 22H20" />
                        <path d="M20 2H6.5A2.5 2.5 0 0 0 4 4.5v15" />
                        <path d="M8 7h8M8 11h8M8 15h6" />
                    </svg>
                </span>
                Quotations
            </a>

            <a href="#"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-amber-50 text-amber-700">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 1v22" />
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7H14a3.5 3.5 0 0 1 0 7H6" />
                    </svg>
                </span>
                Bills
            </a>

            <a href="#"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-sky-50 text-sky-600">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M8 6h13M8 12h13M8 18h13" />
                        <path d="M3 6h.01M3 12h.01M3 18h.01" />
                    </svg>
                </span>
                Routines
            </a>

            <a href="#"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-green-50 text-green-700">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 19.5A2.5 2.5 0 0 0 6.5 22H20" />
                        <path d="M20 2H6.5A2.5 2.5 0 0 0 4 4.5v15" />
                    </svg>
                </span>
                Notes
            </a>
        </nav>
    </div>

    {{-- <div class="mt-auto border-t border-slate-200 p-4">
        <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-3">
            <div class="grid h-10 w-10 place-items-center rounded-full bg-white text-slate-700 ring-1 ring-slate-200">
                A
            </div>
            <div class="min-w-0">
                <div class="truncate text-sm font-semibold">admin</div>
                <div class="truncate text-xs text-slate-500">admin@example.com</div>
            </div>
        </div>
    </div> --}}
</aside>
