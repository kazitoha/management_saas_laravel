   <!-- Top Bar -->
   <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/80 backdrop-blur">
       <div class="flex items-center justify-between gap-3 px-4 py-3 md:px-8">
           <!-- Left: date/time -->
           <div class="hidden flex-col md:flex">
               <div class="text-sm font-semibold">Tuesday, January 27, 2026</div>
               <div class="text-xs text-slate-500">04:05:36 PM</div>
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
                       class="w-full rounded-full border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm outline-none ring-blue-200 focus:border-blue-300 focus:ring-4"
                       placeholder="Search tasks, projects, notes..." />
               </div>
           </div>

           <!-- Right: actions -->
           <div class="flex items-center gap-2">
               <button
                   class="hidden rounded-full border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 md:inline-flex">
                   Add
               </button>
               <button
                   class="grid h-10 w-10 place-items-center rounded-full border border-slate-200 bg-white text-slate-700 hover:bg-slate-50"
                   title="Download">
                   <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                       <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                       <path d="M7 10l5 5 5-5" />
                       <path d="M12 15V3" />
                   </svg>
               </button>
               <div class="flex items-center gap-2 rounded-full border border-slate-200 bg-white p-1.5 pl-3">
                   <span class="text-sm font-semibold">admin</span>
                   <span
                       class="grid h-8 w-8 place-items-center rounded-full bg-slate-900 text-xs font-semibold text-white">
                       A
                   </span>
               </div>
           </div>
       </div>
   </header>
