@extends('admin.layout.app')
@section('admin-content')
    <!-- Greeting card -->
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <div class="text-lg font-bold">Good Evening, admin 👋</div>
                <div class="text-sm text-slate-500">Here's your overview for today.</div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <select
                    class="w-full sm:w-auto rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 outline-none ring-blue-200 focus:ring-4">
                    <option>Last 7 days</option>
                    <option>Last 30 days</option>
                    <option>This month</option>
                </select>
                <select
                    class="w-full sm:w-auto rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 outline-none ring-blue-200 focus:ring-4">
                    <option>My data</option>
                    <option>Team</option>
                    <option>All</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Stat cards -->
    <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="text-[11px] font-bold tracking-widest text-slate-400">TOTAL TASKS</div>
            <div class="mt-2 text-3xl font-extrabold">3</div>
            <div class="mt-2 text-sm text-slate-500">+0 created in last 7 days</div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="text-[11px] font-bold tracking-widest text-slate-400">COMPLETED</div>
            <div class="mt-2 text-3xl font-extrabold">2</div>
            <div class="mt-3">
                <div class="h-2 w-full rounded-full bg-slate-100">
                    <div class="h-2 w-2/3 rounded-full bg-emerald-400"></div>
                </div>
                <div class="mt-2 text-sm text-slate-500">67% complete</div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="text-[11px] font-bold tracking-widest text-slate-400">OVERDUE</div>
            <div class="mt-2 text-3xl font-extrabold">1</div>
            <div class="mt-2 text-sm text-slate-500">0 due today</div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="text-[11px] font-bold tracking-widest text-slate-400">REMINDERS</div>
            <div class="mt-2 text-3xl font-extrabold">0</div>
            <div class="mt-2 text-sm text-slate-500">0 this week</div>
        </div>
    </div>

    <!-- Presence + Summary -->
    <div class="mt-4 grid grid-cols-1 gap-4 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm xl:col-span-1">
            <div class="text-[11px] font-bold tracking-widest text-slate-400">PRESENCE (MONTH)</div>
            <div class="mt-2 text-3xl font-extrabold">1/31</div>
            <div class="mt-2 text-sm text-slate-500">Total late 749 min</div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm xl:col-span-3">
            <div class="flex items-center justify-between gap-3">
                <div class="text-sm font-bold">Task Summary</div>
                <div class="text-sm text-slate-500">
                    Total <span class="font-semibold text-slate-900">3</span>
                </div>
            </div>

            <div class="mt-4">
                <div class="h-3 w-full overflow-hidden rounded-full bg-slate-100">
                    <div class="flex h-full">
                        <div class="h-full w-1/3 bg-emerald-400"></div>
                        <div class="h-full w-0 bg-blue-400"></div>
                        <div class="h-full w-2/3 bg-amber-400"></div>
                    </div>
                </div>

                <div class="mt-3 flex flex-wrap gap-x-6 gap-y-2 text-xs text-slate-500">
                    <span class="inline-flex items-center gap-2">
                        <span class="h-2 w-2 rounded-sm bg-emerald-400"></span> To Do 33%
                    </span>
                    <span class="inline-flex items-center gap-2">
                        <span class="h-2 w-2 rounded-sm bg-blue-400"></span> In Progress 0%
                    </span>
                    <span class="inline-flex items-center gap-2">
                        <span class="h-2 w-2 rounded-sm bg-amber-400"></span> Completed 67%
                    </span>
                </div>
            </div>

            <div class="mt-6 rounded-xl border border-dashed border-slate-200 bg-slate-50 p-6 text-sm text-slate-400">
                Task summary details / list goes here…
            </div>
        </div>
    </div>

    <!-- Charts row -->
    <div class="mt-4 grid grid-cols-1 gap-4 xl:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm xl:col-span-2">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm font-bold">Activity</div>
                    <div class="text-xs text-slate-500">(Last 7 days)</div>
                </div>
                <div class="text-xs text-slate-500">0 created</div>
            </div>

            <div class="mt-4 h-56 rounded-xl border border-slate-200 bg-white">
                <div
                    class="h-full w-full rounded-xl bg-[linear-gradient(to_right,rgba(148,163,184,.25)_1px,transparent_1px),linear-gradient(to_bottom,rgba(148,163,184,.25)_1px,transparent_1px)] bg-[size:48px_48px]">
                </div>
            </div>

            <div class="mt-3 flex items-center justify-between text-xs text-slate-400">
                <span>Jan 21</span><span>Jan 22</span><span>Jan 23</span><span>Jan 24</span><span>Jan
                    25</span><span>Jan 26</span><span>Jan 27</span>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div>
                <div class="text-sm font-bold">Reminders (Next 7 days)</div>
                <div class="text-xs text-slate-500">Schedule glance</div>
            </div>

            <div class="mt-4 h-56 rounded-xl border border-slate-200 bg-slate-50 p-4">
                <div class="space-y-3">
                    <div class="h-10 rounded-lg bg-white"></div>
                    <div class="h-10 rounded-lg bg-white"></div>
                    <div class="h-10 rounded-lg bg-white"></div>
                    <div class="h-10 rounded-lg bg-white"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
