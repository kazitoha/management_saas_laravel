 <!-- TOP BAR -->
 <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/80 backdrop-blur transition-all duration-300">
     <div class="flex items-center justify-between gap-3 px-4 py-3 md:px-8">
         <!-- Mobile: menu button -->
         <div class="flex items-center gap-2 md:hidden">
             <button id="mobileMenuBtn"
                 class="grid h-10 w-10 place-items-center rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-all duration-200 active:scale-95"
                 aria-label="Open menu">
                 <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                     <path d="M3 7h18M3 12h18M3 17h18" />
                 </svg>
             </button>

             <div class="flex items-center gap-2">
                 <div class="grid h-10 w-10 place-items-center rounded-xl bg-slate-900 text-white">TM
                 </div>
                 <div class="leading-tight">
                     <div class="text-sm font-semibold">Task Manager</div>
                     <div class="text-xs text-slate-500">Dashboard</div>
                 </div>
             </div>
         </div>

         <!-- Left: date/time (desktop only) -->
         <div class="hidden flex-col md:flex cursor-default select-none">
             <div class="text-sm font-semibold" data-date>Tuesday, January 27, 2026</div>
             <div class="text-xs text-slate-500" data-time>04:05:36 PM</div>
         </div>

         <!-- Center: search -->
         <div class="flex flex-1 items-center justify-center">
             <div class="relative w-full max-w-2xl">
                 <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                     <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                         <circle cx="11" cy="11" r="8" />
                         <path d="M21 21l-4.3-4.3" />
                     </svg>
                 </span>
                 <input
                     class="w-full rounded-full border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm outline-none ring-blue-200 focus:border-blue-300 focus:ring-4 focus:bg-white transition-all duration-200"
                     placeholder="Search tasks, projects, notes..." autocomplete="off" />
             </div>
         </div>

         <!-- Right: actions -->
         <div class="flex items-center gap-2">


             <button
                 class="hidden md:grid h-10 w-10 place-items-center rounded-full border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-all duration-200 active:scale-95"
                 title="Download">
                 <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                     <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                     <path d="M7 10l5 5 5-5" />
                     <path d="M12 15V3" />
                 </svg>
             </button>

             <!-- Profile Dropdown -->
             @php
                 $superAdmin = Auth::guard('superadmin')->user();
                 $superAdminName = $superAdmin?->name ?? 'Super Admin';
                 $superAdminInitial = strtoupper(substr($superAdminName, 0, 1));
             @endphp

             <div class="relative">
                 <button id="profileBtn"
                     class="flex items-center gap-2 rounded-full border border-slate-200 bg-white p-1.5 pl-3 hover:bg-slate-50 transition-all duration-200 hover:border-slate-300 active:scale-95"
                     aria-haspopup="menu" aria-expanded="false">
                     <span class="hidden sm:inline text-sm font-semibold">{{ $superAdminName }}</span>
                     <span
                         class="grid h-8 w-8 place-items-center rounded-full bg-slate-900 text-xs font-semibold text-white">
                         {{ $superAdminInitial }}
                     </span>
                     <svg viewBox="0 0 24 24" class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor"
                         stroke-width="2">
                         <path d="M6 9l6 6 6-6" />
                     </svg>
                 </button>

                 <div id="profileMenu"
                     class="absolute right-0 mt-2 hidden w-56 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-lg transition-all duration-200 opacity-0 scale-95"
                     role="menu">
                     <a href="#"
                         class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors duration-150"
                         role="menuitem">Profile</a>
                     <a href="#"
                         class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors duration-150"
                         role="menuitem">Settings</a>
                     <a href="#"
                         class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors duration-150"
                         role="menuitem">Help</a>
                     <div class="h-px bg-slate-200"></div>


                     <form method="POST" action="{{ route('superadmin.logout') }}">
                         @csrf
                         <button type="submit"
                             class="block px-4 py-3 text-sm font-semibold text-rose-600 hover:bg-rose-50 transition-colors duration-150"
                             role="menuitem">
                             Logout
                         </button>
                     </form>

                 </div>
             </div>
         </div>
     </div>
 </header>
