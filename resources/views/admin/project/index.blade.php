@extends('admin.layout.app')

@section('title', 'Projects')

@section('admin-content')
    @php
        $totalProjects = $projects->count();
        $completedProjects = $projects->where('status', 'completed')->count();
        $inProgressProjects = $projects->where('status', 'in_progress')->count();
        $notStartedProjects = $projects->where('status', 'not_started')->count();
    @endphp

    <div class="mx-auto max-w-6xl space-y-4 px-4 py-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div
            class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="text-xs font-semibold uppercase tracking-wide text-slate-400">Projects</div>
                <h2 class="text-xl font-semibold text-slate-800">Project Overview</h2>
                <p class="text-sm text-slate-500">Track progress across all active work.</p>
            </div>
            <a href="{{ route('projects.create') }}"
                class="inline-flex items-center rounded-md border border-sky-500 bg-white px-3 py-2 text-sm font-semibold text-sky-600 hover:bg-sky-50">
                Add Project
            </a>
        </div>

        {{-- Summary --}}
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="text-xs uppercase text-slate-400">Total</div>
                <div class="text-2xl font-semibold text-slate-800">{{ $totalProjects }}</div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="text-xs uppercase text-slate-400">In Progress</div>
                <div class="text-2xl font-semibold text-amber-600">{{ $inProgressProjects }}</div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="text-xs uppercase text-slate-400">Completed</div>
                <div class="text-2xl font-semibold text-emerald-600">{{ $completedProjects }}</div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="text-xs uppercase text-slate-400">Not Started</div>
                <div class="text-2xl font-semibold text-slate-600">{{ $notStartedProjects }}</div>
            </div>
        </div>

        @if ($projects->isEmpty())
            {{-- Empty state --}}
            <div class="rounded-2xl border border-slate-200 bg-white px-4 py-10 text-center shadow-sm">
                <div class="text-4xl mb-2">🗂️</div>
                <h5 class="text-base font-semibold text-slate-800 mt-1">No projects yet</h5>
                <p class="text-sm text-slate-500 mt-1 mb-4">
                    Create your first project to start organizing tasks.
                </p>
                <a href="{{ route('projects.create') }}"
                    class="inline-flex items-center rounded-md border border-sky-500 text-sky-600 px-3 py-2 text-sm font-medium bg-white hover:bg-sky-50 transition">
                    <i class="bi bi-folder-plus mr-1"></i>
                    Create Project
                </a>
            </div>
        @else
            {{-- Projects grid --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($projects as $project)
                    @php
                        $total = $project->tasks->count();
                        $completed = $project->tasks->where('status', 'completed')->count();
                        $progress = $total ? round(($completed / $total) * 100) : 0;
                        $todo = $project->to_do_tasks ?? $project->tasks->where('status', 'to_do')->count();
                        $doing =
                            $project->in_progress_tasks ?? $project->tasks->where('status', 'in_progress')->count();
                        $done = $project->completed_tasks ?? $project->tasks->where('status', 'completed')->count();
                    @endphp

                    <div class="h-full">
                        <div class="flex h-full flex-col rounded-2xl border border-slate-200 bg-white shadow-sm">
                            <div class="flex h-full flex-col p-4">
                                {{-- Title + status --}}
                                <div class="mb-2 flex items-start justify-between gap-2">
                                    <h5 class="truncate text-sm font-semibold text-slate-800" title="{{ $project->name }}">
                                        {{ $project->name }}
                                    </h5>
                                    <div class="flex-shrink-0">
                                        @include('partials.status-badge', ['status' => $project->status])
                                    </div>
                                </div>

                                {{-- Description --}}
                                <p class="mb-3 line-clamp-2 text-xs text-slate-500">
                                    {{ $project->description ?: 'No description provided.' }}
                                </p>

                                {{-- Deadline --}}
                                <div class="mb-3 flex items-center gap-1 text-[11px] text-slate-500">
                                    <span class="font-semibold text-slate-700 mr-1">Deadline:</span>
                                    @if ($project->end_date && $project->end_date->isFuture())
                                        <span>{{ $project->end_date->diffForHumans() }}</span>
                                    @elseif($project->end_date)
                                        <span class="text-rose-600 font-semibold">Deadline passed</span>
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </div>

                                {{-- Progress bar --}}
                                <div class="mb-3">
                                    <div class="h-1.5 w-full overflow-hidden rounded-full bg-slate-200">
                                        <div class="h-1.5 rounded-full bg-emerald-500"
                                            style="width: {{ $progress }}%;">
                                        </div>
                                    </div>
                                    <div class="mt-1 flex justify-between text-[11px] text-slate-500">
                                        <span>{{ $progress }}% complete</span>
                                        <span>{{ $completed }}/{{ $total }} tasks</span>
                                    </div>
                                </div>

                                {{-- Counters --}}
                                <div class="mb-3 flex flex-wrap gap-2 text-[11px]">
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2 py-1 text-slate-700">
                                        <span>To do: {{ $todo }}</span>
                                    </span>
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2 py-1 text-amber-800">
                                        <span>Doing: {{ $doing }}</span>
                                    </span>
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-1 text-emerald-800">
                                        <span>Done: {{ $done }}</span>
                                    </span>
                                </div>

                                {{-- Actions --}}
                                <div class="mt-auto flex items-center gap-2 border-t border-slate-100 pt-2">
                                    <a href="{{ route('projects.tasks.index', $project->id) }}"
                                        class="inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-2.5 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50"
                                        title="Open board"> <i class="bi bi-kanban p-1"></i> </a>

                                    <a href="{{ route('projects.show', $project->id) }}"
                                        class="inline-flex items-center justify-center rounded-md border border-sky-500 bg-white px-2.5 py-1.5 text-xs font-medium text-sky-600 hover:bg-sky-50"
                                        title="Details">
                                        <i class="bi bi-eye p-1"></i>
                                    </a>

                                    <a href="{{ route('projects.edit', $project->id) }}"
                                        class="inline-flex items-center justify-center rounded-md border border-amber-400 bg-amber-50 px-2.5 py-1.5 text-xs font-medium text-amber-700 hover:bg-amber-100"
                                        title="Edit">
                                        <i class="bi bi-pencil-square p-1"></i>
                                    </a>

                                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST"
                                        class="ml-auto"
                                        onsubmit="return confirm('Delete this project? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center justify-center rounded-md border border-rose-500 bg-rose-50 px-2.5 py-1.5 text-xs font-medium text-rose-700 hover:bg-rose-100"
                                            title="Delete">
                                            <i class="bi bi-trash p-1"></i>
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
