@extends('admin.layout.app')

@section('title')
    {{ $project->name }} - Project Details
@endsection

@section('admin-content')
    @php
        $totalTasks = $project->tasks->count();
        $completedTasks = $project->tasks->where('status', 'completed')->count();
        $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

        $startDate = $project->start_date ? $project->start_date->format('Y-m-d') : '—';
        $endDate = $project->end_date ? $project->end_date->format('Y-m-d') : '—';
        $budget = $project->budget ? '$' . $project->budget : '—';
        $taskProgressLabel = $totalTasks ? round($progress) . '% complete' : 'No tasks yet';
    @endphp

    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 space-y-6">
        {{-- Header --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="p-5 sm:p-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    {{-- Title --}}
                    <div class="min-w-0 space-y-1">
                        <div class="text-xs font-semibold uppercase tracking-wider text-slate-400">Project</div>
                        <h1 class="truncate text-2xl font-semibold text-slate-900">{{ $project->name }}</h1>
                        <p class="text-sm text-slate-500">Overview, timeline, tasks progress, and team management.</p>
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-wrap items-center gap-2 sm:justify-end">
                        @include('partials.status-badge', ['status' => $project->status])

                        <a href="{{ route('projects.tasks.index', $project) }}"
                            class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50">
                            <i class="bi bi-kanban"></i>
                            Board
                        </a>

                        <a href="{{ route('projects.edit', $project) }}"
                            class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-800">
                            <i class="bi bi-pencil-square"></i>
                            Edit
                        </a>

                        <a href="{{ route('projects.index') }}"
                            class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50">
                            <i class="bi bi-arrow-left"></i>
                            Back
                        </a>
                    </div>
                </div>
            </div>

            {{-- Summary strip --}}
            <div class="border-t border-slate-100 bg-slate-50/60 p-4 sm:p-6">
                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="text-xs font-medium uppercase text-slate-400">Total Tasks</div>
                        <div class="mt-1 text-2xl font-semibold text-slate-900">{{ $totalTasks }}</div>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="text-xs font-medium uppercase text-slate-400">Completed</div>
                        <div class="mt-1 text-2xl font-semibold text-emerald-600">{{ $completedTasks }}</div>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="text-xs font-medium uppercase text-slate-400">Progress</div>
                        <div class="mt-2">
                            <div class="flex items-baseline justify-between">
                                <div class="text-2xl font-semibold text-slate-900">{{ $taskProgressLabel }}</div>
                                <div class="text-xs text-slate-500">{{ $completedTasks }}/{{ $totalTasks }}</div>
                            </div>
                            <div class="mt-2 h-2 w-full overflow-hidden rounded-full bg-slate-200">
                                <div class="h-full rounded-full bg-sky-600" style="width: {{ $progress }}%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="text-xs font-medium uppercase text-slate-400">Team Members</div>
                        <div class="mt-1 text-2xl font-semibold text-slate-900">{{ $teamMembers->count() }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Flash success --}}
        @if (session('success'))
            Team
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Main content --}}
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-5">
            {{-- Left: Overview --}}
            <div class="lg:col-span-3 space-y-4">
                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                    <div class="p-5 sm:p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-base font-semibold text-slate-900">Overview</h2>
                                <p class="mt-1 text-sm text-slate-500">
                                    {{ $project->description ?: 'No description provided for this project.' }}
                                </p>
                            </div>
                        </div>

                        {{-- Info tiles --}}
                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                                <div class="flex items-center justify-between">
                                    <div class="text-xs font-medium uppercase tracking-wide text-slate-500">Start Date</div>
                                    <i class="bi bi-calendar-event text-slate-400"></i>
                                </div>
                                <div class="mt-1 text-sm font-semibold text-slate-900">{{ $startDate }}</div>
                            </div>

                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                                <div class="flex items-center justify-between">
                                    <div class="text-xs font-medium uppercase tracking-wide text-slate-500">End Date</div>
                                    <i class="bi bi-calendar2-check text-slate-400"></i>
                                </div>
                                <div class="mt-1 text-sm font-semibold text-slate-900">{{ $endDate }}</div>
                            </div>

                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                                <div class="flex items-center justify-between">
                                    <div class="text-xs font-medium uppercase tracking-wide text-slate-500">Status</div>
                                    <i class="bi bi-flag text-slate-400"></i>
                                </div>
                                <div class="mt-2">
                                    @include('partials.status-badge', ['status' => $project->status])
                                </div>
                            </div>

                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                                <div class="flex items-center justify-between">
                                    <div class="text-xs font-medium uppercase tracking-wide text-slate-500">Budget</div>
                                    <i class="bi bi-cash-coin text-slate-400"></i>
                                </div>
                                <div class="mt-1 text-sm font-semibold text-slate-900">{{ $budget }}</div>
                            </div>
                        </div>

                        {{-- Progress --}}
                        <div class="mt-6 rounded-xl border border-slate-200 bg-white p-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-semibold text-slate-900">Project Progress</h3>
                                <div class="text-xs text-slate-500">
                                    {{ $completedTasks }} / {{ $totalTasks }} tasks
                                </div>
                            </div>

                            <div class="mt-3 h-2.5 w-full overflow-hidden rounded-full bg-slate-200">
                                <div class="h-full rounded-full bg-emerald-500" style="width: {{ $progress }}%"></div>
                            </div>

                            <div class="mt-2 flex justify-between text-[11px] text-slate-500">
                                <span>{{ round($progress) }}% complete</span>
                                <span>{{ $totalTasks ? $totalTasks - $completedTasks : 0 }} remaining</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Team Members --}}
            <div class="lg:col-span-2 space-y-4">
                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                    <div class="p-5 sm:p-6" x-data="{ open: false }">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-base font-semibold text-slate-900">Team Members</h2>
                                <p class="mt-1 text-sm text-slate-500">Manage who has access to this project.</p>
                            </div>

                            <button @click=" true"
                                class="inline-flex items-center gap-2 rounded-xl bg-sky-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700 active:scale-[0.99]">
                                <i class="bi bi-person-plus"></i>
                                Add
                            </button>
                        </div>

                        {{-- Members list --}}
                        <div class="mt-5">
                            @if ($teamMembers->isEmpty())
                                <div
                                    class="rounded-xl border border-dashed border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                                    No team members added yet.
                                </div>
                            @else
                                <div class="space-y-2">
                                    @foreach ($teamMembers as $user)
                                        <div
                                            class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
                                            {{-- Avatar --}}
                                            <div
                                                class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-sm font-semibold text-slate-700">
                                                {{ Str::of($user->name ?? 'U')->substr(0, 1)->upper() }}
                                            </div>

                                            {{-- Info --}}
                                            <div class="min-w-0 flex-1">
                                                <div class="truncate text-sm font-semibold text-slate-900">
                                                    {{ $user->name }}</div>
                                                <div class="truncate text-xs text-slate-500">{{ $user->email }}</div>
                                            </div>

                                            {{-- Remove --}}
                                            <form method="POST" action="{{ route('projects.removeMember') }}"
                                                onsubmit="return confirm('Remove this member from the project?');">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="project_id" value="{{ $project->id }}">
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">

                                                <button type="submit"
                                                    class="inline-flex items-center gap-2 rounded-xl border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-100">
                                                    <i class="bi bi-trash"></i>
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Modal (Tailwind + Alpine) --}}
                        <div x-show="open" x-cloak class="relative z-50" aria-labelledby="modal-title" role="dialog"
                            aria-modal="true">
                            <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black/40 backdrop-blur-sm">
                            </div>

                            <div class="fixed inset-0 overflow-y-auto">
                                <div class="flex min-h-full items-center justify-center px-4 py-8">
                                    <div x-show="open" x-transition @click.away="open = false"
                                        class="w-full max-w-lg rounded-2xl bg-white shadow-2xl ring-1 ring-black/5 overflow-hidden">

                                        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                                            <h3 id="modal-title" class="text-base font-semibold text-slate-900">Add Team
                                                Member</h3>
                                            <button @click="open = false"
                                                class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-700"
                                                aria-label="Close">
                                                ✕
                                            </button>
                                        </div>

                                        <form action="{{ route('projects.addMember') }}" method="POST"
                                            class="px-5 py-5 space-y-4">
                                            @csrf
                                            <input type="hidden" name="project_id" value="{{ $project->id }}">

                                            <div>
                                                <label for="user_id"
                                                    class="block text-sm font-medium text-slate-700">Select User</label>
                                                <select name="user_id" id="user_id"
                                                    class="mt-1 block w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm
                                                           focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div
                                                class="flex items-center justify-end gap-2 border-t border-slate-100 pt-4">
                                                <button type="button" @click="open = false"
                                                    class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50">
                                                    Cancel
                                                </button>

                                                <button type="submit"
                                                    class="rounded-xl bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700 active:scale-[0.99]">
                                                    Add Member
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /Modal --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
