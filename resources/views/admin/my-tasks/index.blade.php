@extends('admin.layout.app')
@section('admin-content')
    <!-- Tailwind Table (Responsive + Pro look) -->
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <!-- Header -->
        <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-base font-semibold text-slate-900">My Tasks</h3>
                <p class="text-sm text-slate-500">Manage and track your tasks.</p>
            </div>

            <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                <form class="flex items-center gap-2" method="GET" action="{{ route('my-tasks') }}">
                    <div class="relative">
                        <input name="q" value="{{ request('q') }}" type="text" placeholder="Search tasks..."
                            class="w-full p-5 rounded-xl border border-slate-200 bg-slate-50 pl-9 pr-3 py-2 text-sm text-slate-900 placeholder-slate-400 shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 sm:w-64" />
                    </div>

                    <select name="status"
                        class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm">
                        <option value="">All statuses</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress
                        </option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed
                        </option>
                    </select>

                    <button
                        class="rounded-xl bg-slate-900 px-3 py-2 text-sm font-semibold text-white hover:bg-slate-800">Search</button>
                </form>
            </div>"
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Project</th>

                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Start
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">End
                        </th>

                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($tasks as $task)
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="grid h-10 w-10 place-items-center rounded-xl bg-sky-50 text-sky-700 ring-1 ring-sky-100">
                                        <!-- folder icon -->
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path
                                                d="M3 7a2 2 0 0 1 2-2h5l2 2h7a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="truncate text-sm font-semibold text-slate-900">{{ $task->title }}</div>
                                        <div class="truncate text-xs text-slate-500">
                                            {{ optional($task->project)->name ?? '—' }}
                                            @if ($task->checklist_items_count)
                                                • {{ $task->checklist_items_count }} items
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>


                            <td class="px-5 py-4">
                                @php
                                    $s = strtolower($task->status ?? 'pending');
                                @endphp

                                @if ($s === 'completed')
                                    <span
                                        class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        {{ $task->status }}
                                    </span>
                                @elseif($s === 'in progress')
                                    <span
                                        class="inline-flex items-center gap-2 rounded-full border border-amber-200 bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                        {{ $task->status }}
                                    </span>
                                @elseif($s === 'pending')
                                    <span
                                        class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 text-xs font-semibold text-slate-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-500"></span>
                                        {{ $task->status }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-2 rounded-full border border-rose-200 bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                        {{ $task->status }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-sm text-slate-600">
                                {{ optional($task->created_at)->format('Y-m-d') ?? '—' }}</td>
                            <td class="px-5 py-4 text-sm text-slate-600">
                                {{ optional($task->due_date)->format('Y-m-d') ?? '—' }}</td>

                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('tasks.show', $task) }}"
                                        class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50">
                                        <!-- eye icon -->
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                        View
                                    </a>



                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-sm text-slate-500">
                                No tasks found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer (pagination style) -->
        <div class="flex flex-col gap-3 border-t border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-slate-600">Showing <span class="font-semibold">{{ $tasks->firstItem() ?? 0 }}</span> to
                <span class="font-semibold">{{ $tasks->lastItem() ?? 0 }}</span> of <span
                    class="font-semibold">{{ $tasks->total() }}</span> results
            </p>
            <div class="flex items-center gap-2">
                @if ($tasks->onFirstPage())
                    <span class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-400">Prev</span>
                @else
                    <a href="{{ $tasks->previousPageUrl() }}"
                        class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Prev</a>
                @endif

                {{-- <div class="hidden md:block">
                    {{ $tasks->links() }}
                </div> --}}

                @if ($tasks->hasMorePages())
                    <a href="{{ $tasks->nextPageUrl() }}"
                        class="rounded-xl bg-slate-900 px-3 py-2 text-sm font-semibold text-white hover:bg-slate-800">Next</a>
                @else
                    <span class="rounded-xl bg-slate-200 px-3 py-2 text-sm text-slate-400">Next</span>
                @endif
            </div>
        </div>
    </div>
@endsection
