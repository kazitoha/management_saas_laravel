   <!-- MOBILE BOTTOM BAR -->
   <nav class="fixed bottom-0 left-0 right-0 z-30 border-t border-slate-200 bg-white/90 backdrop-blur md:hidden">
       <div class="mx-auto grid max-w-3xl grid-cols-5 px-2 py-2">
           <button id="bottomMenuBtn"
               class="flex flex-col items-center gap-1 rounded-xl p-2 text-slate-700 hover:bg-slate-50">
               <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2">
                   <path d="M3 7h18M3 12h18M3 17h18" />
               </svg>
               <span class="text-[11px] font-semibold">Menu</span>
           </button>

           <button class="flex flex-col items-center gap-1 rounded-xl p-2 text-slate-700 hover:bg-slate-50">
               <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2">
                   <circle cx="11" cy="11" r="8" />
                   <path d="M21 21l-4.3-4.3" />
               </svg>
               <span class="text-[11px] font-semibold">Search</span>
           </button>

           <button class="flex flex-col items-center gap-1 rounded-xl bg-slate-900 p-2 text-white shadow-sm">
               <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2">
                   <path d="M12 5v14" />
                   <path d="M5 12h14" />
               </svg>
               <span class="text-[11px] font-semibold">Add</span>
           </button>

           <button class="flex flex-col items-center gap-1 rounded-xl p-2 text-slate-700 hover:bg-slate-50">
               <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2">
                   <path d="M8 7h13M8 12h13M8 18h13" />
                   <path d="M3 6h.01M3 12h.01M3 18h.01" />
               </svg>
               <span class="text-[11px] font-semibold">Tasks</span>
           </button>

           <button id="bottomProfileBtn"
               class="flex flex-col items-center gap-1 rounded-xl p-2 text-slate-700 hover:bg-slate-50">
               <span
                   class="grid h-6 w-6 place-items-center rounded-full bg-slate-900 text-[10px] font-bold text-white">A</span>
               <span class="text-[11px] font-semibold">Profile</span>
           </button>
       </div>

       <!-- Bottom profile menu -->
       <div id="bottomProfileMenu" class="hidden border-t border-slate-200 bg-white">
           <div class="mx-auto max-w-3xl px-3 py-2">
               <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                   <a href="#" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">Profile</a>
                   <a href="#" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">Settings</a>
                   <div class="h-px bg-slate-200"></div>
                   <a href="#"
                       class="block px-4 py-3 text-sm font-semibold text-rose-600 hover:bg-rose-50">Logout</a>
               </div>
           </div>
       </div>
   </nav>
