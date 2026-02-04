@extends('admin.layout.app')

@section('title', $task->title)

@section('admin-content')
    @php
        $priorityLabel = ucfirst($task->priority);
        $priorityBadge = match ($task->priority) {
            'high' => 'bg-rose-50 text-rose-700 ring-rose-200',
            'medium' => 'bg-amber-50 text-amber-700 ring-amber-200',
            default => 'bg-slate-50 text-slate-700 ring-slate-200',
        };

        $priorityDot = match ($task->priority) {
            'high' => 'bg-rose-500',
            'medium' => 'bg-amber-500',
            default => 'bg-slate-400',
        };

        $dueLabel = $task->due_date ? $task->due_date->format('Y-m-d') : '—';
        $isOverdue = $task->due_date && $task->due_date->isPast() && $task->status !== 'completed';
    @endphp

    <div class="min-h-[calc(100vh-4rem)] bg-slate-50">
        <div class="mx-auto max-w-6xl space-y-5 px-4 py-6 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-col gap-4 p-5 sm:flex-row sm:items-start sm:justify-between sm:p-6">
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2 text-xs">
                            <span
                                class="inline-flex items-center gap-2 rounded-full px-2.5 py-1 font-semibold ring-1
                            {{ $isOverdue ? 'bg-rose-50 text-rose-700 ring-rose-200' : 'bg-slate-50 text-slate-700 ring-slate-200' }}">
                                <i class="bi bi-calendar3"></i>
                                Due: {{ $dueLabel }}
                            </span>

                            @include('partials.status-badge', ['status' => $task->status])

                            <span
                                class="inline-flex items-center gap-2 rounded-full px-2.5 py-1 font-semibold ring-1 {{ $priorityBadge }}">
                                <span class="h-2 w-2 rounded-full {{ $priorityDot }}"></span>
                                {{ $priorityLabel }}
                            </span>

                            @if ($isOverdue)
                                <span
                                    class="inline-flex items-center gap-2 rounded-full bg-rose-600 px-2.5 py-1 font-semibold text-white">
                                    <i class="bi bi-exclamation-triangle"></i> Overdue
                                </span>
                            @endif
                        </div>

                        <h1 class="mt-2 truncate text-2xl font-bold text-slate-900 sm:text-3xl">
                            {{ $task->title }}
                        </h1>

                        <div class="mt-2 flex flex-wrap items-center gap-2 text-sm text-slate-600">
                            <span>
                                Project:
                                @if ($task->project)
                                    <a href="{{ route('projects.show', $task->project) }}"
                                        class="font-semibold text-sky-700 hover:underline">
                                        {{ $task->project->name }}
                                    </a>
                                @else
                                    —
                                @endif
                            </span>
                            <span class="text-slate-300">•</span>
                            <span>
                                Assignee: <span
                                    class="font-semibold text-slate-900">{{ $task->user?->name ?? 'Unassigned' }}</span>
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 sm:justify-end">
                        @if (!$task->assigned_to)
                            <form action="{{ route('tasks.assignToMe', $task) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-xl border border-sky-200 bg-sky-50 px-4 py-2 text-sm font-semibold text-sky-700 hover:bg-sky-100">
                                    <i class="bi bi-person-check"></i> Assign to me
                                </button>
                            </form>
                        @endif

                        <button type="button"
                            class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800"
                            onclick="openEditTaskModal()">
                            <i class="bi bi-pencil-square"></i> Edit
                        </button>

                        <a href="{{ route('projects.tasks.index', $task->project_id) }}"
                            class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>

            {{-- Two column layout --}}
            <div class="grid gap-4 lg:grid-cols-3">
                {{-- Left: main --}}
                <div class="space-y-4 lg:col-span-2">

                    {{-- Description + core info --}}
                    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <div class="border-b border-slate-100 p-5 sm:p-6">
                            <h2 class="text-sm font-semibold text-slate-900">Details</h2>
                        </div>

                        <div class="p-5 sm:p-6 space-y-4">
                            <div class="grid gap-3 sm:grid-cols-2">
                                <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                    <div class="text-xs text-slate-500">Status</div>
                                    <div class="mt-1 font-semibold text-slate-900">
                                        {{ ucwords(str_replace('_', ' ', $task->status)) }}
                                    </div>
                                </div>
                                <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                    <div class="text-xs text-slate-500">Priority</div>
                                    <div class="mt-1 font-semibold text-slate-900">{{ $priorityLabel }}</div>
                                </div>
                            </div>

                            <div class="rounded-xl border border-slate-200 p-4">
                                <div class="text-xs font-semibold uppercase tracking-wide text-slate-400">Description</div>
                                <p class="mt-2 text-sm leading-relaxed text-slate-700">
                                    {{ $task->description ?: 'No description provided.' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Checklist --}}
                    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <div class="flex items-center justify-between border-b border-slate-100 p-5 sm:p-6">
                            <h2 class="text-sm font-semibold text-slate-900">Checklist</h2>
                            <span class="text-xs text-slate-500">{{ $task->checklistItems->count() }} items</span>
                        </div>

                        <div class="p-5 sm:p-6 space-y-4">
                            @if (permissionExists('tasks.destroy') || Auth::user()->roles->contains('name', 'admin'))
                                <form action="{{ route('tasks.checklist.store', $task) }}" method="POST"
                                    class="flex gap-2">
                                    @csrf
                                    <input type="text" name="title" required placeholder="Add a checklist item…"
                                        class="flex-1 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20">
                                    <button type="submit"
                                        class="inline-flex items-center gap-2 rounded-xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-sky-700">
                                        <i class="bi bi-plus-lg"></i> Add
                                    </button>
                                </form>
                            @endif

                            @if ($task->checklistItems->isEmpty())
                                <div class="rounded-xl bg-slate-50 p-4 text-sm text-slate-600 ring-1 ring-slate-200">
                                    No checklist items yet.
                                </div>
                            @else
                                <ul class="divide-y divide-slate-100 rounded-xl border border-slate-200 bg-white">
                                    @foreach ($task->checklistItems as $item)
                                        <li class="flex items-center justify-between gap-3 p-3">
                                            <form action="{{ route('tasks.checklist.toggle', $item) }}" method="POST"
                                                class="flex min-w-0 items-center gap-3">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                    class="grid h-6 w-6 place-items-center rounded-lg border transition
                                                {{ $item->is_completed ? 'bg-emerald-600 border-emerald-600 text-white' : 'bg-white border-slate-300 hover:bg-slate-50' }}">
                                                    @if ($item->is_completed)
                                                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none"
                                                            stroke="currentColor" stroke-width="3">
                                                            <path d="M20 6 9 17l-5-5" />
                                                        </svg>
                                                    @else
                                                        <span class="sr-only">Toggle</span>
                                                    @endif
                                                </button>

                                                <span
                                                    class="truncate text-sm {{ $item->is_completed ? 'line-through text-slate-400' : 'text-slate-800' }}">
                                                    {{ $item->title }}
                                                </span>
                                            </form>
                                            @if (permissionExists('tasks.checklist.destroy') || Auth::user()->roles->contains('name', 'admin'))
                                                <form action="{{ route('tasks.checklist.destroy', $item) }}" method="POST"
                                                    onsubmit="return confirm('Delete this item?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-2 rounded-xl px-3 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-50">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Right: sidebar --}}
                <div class="space-y-4">

                    {{-- Time tracker --}}
                    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <div class="flex items-center justify-between border-b border-slate-100 p-5 sm:p-6">
                            <div>
                                <h2 class="text-sm font-semibold text-slate-900">Time tracker</h2>
                                <p class="mt-1 text-xs text-slate-500">Track active work time.</p>
                            </div>
                            <div
                                class="inline-flex items-center gap-2 rounded-full bg-slate-50 px-3 py-1 text-xs text-slate-600 ring-1 ring-slate-200">
                                <span id="tracker-state-dot" class="h-2 w-2 rounded-full bg-slate-400"></span>
                                <span id="tracker-state">Idle</span>
                            </div>
                        </div>

                        <div class="p-5 sm:p-6 space-y-4">
                            <div class="rounded-xl bg-slate-50 p-4 text-center ring-1 ring-slate-200">
                                <div class="text-[11px] font-semibold uppercase tracking-widest text-slate-400">Elapsed
                                </div>
                                <div id="time-display" class="mt-2 font-mono text-4xl font-bold text-slate-900">
                                    00:00:00
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-2">
                                <button id="start-btn" type="button"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-3 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                                    <i class="bi bi-play-fill"></i> Start
                                </button>
                                <button id="pause-btn" type="button"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 px-3 py-2 text-sm font-semibold text-white hover:bg-amber-600">
                                    <i class="bi bi-pause-fill"></i> Pause
                                </button>
                                <button id="reset-btn" type="button"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Quick status --}}
                    @if (permissionExists('tasks.updateStatus') || Auth::user()->roles->contains('name', 'admin'))
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                            <div class="border-b border-slate-100 p-5 sm:p-6">
                                <h2 class="text-sm font-semibold text-slate-900">Quick status</h2>
                            </div>
                            <div class="p-5 sm:p-6">
                                <form action="{{ route('tasks.updateStatus', $task) }}" method="POST"
                                    class="space-y-3">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status"
                                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20">
                                        <option value="to_do" @selected($task->status === 'to_do')>To Do</option>
                                        <option value="in_progress" @selected($task->status === 'in_progress')>In Progress</option>
                                        <option value="completed" @selected($task->status === 'completed')>Completed</option>
                                    </select>

                                    <button type="submit"
                                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-sky-700">
                                        <i class="bi bi-check2-circle"></i> Update
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    @if (permissionExists('tasks.destroy') || Auth::user()->roles->contains('name', 'admin'))
                        {{-- Danger --}}
                        <div class="rounded-2xl border border-rose-200 bg-white shadow-sm">
                            <div class="border-b border-rose-100 bg-rose-50 p-5 sm:p-6">
                                <h2 class="text-sm font-semibold text-rose-800">Danger</h2>
                            </div>
                            <div class="p-5 sm:p-6">
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                    onsubmit="return confirm('Delete this task? This cannot be undone.');"
                                    class="space-y-3">
                                    @csrf
                                    @method('DELETE')
                                    <p class="text-sm text-slate-600">Deletes task and checklist items permanently.</p>
                                    <button type="submit"
                                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-rose-700">
                                        <i class="bi bi-trash3"></i> Delete task
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Edit modal --}}
            <div id="editTaskModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">
                <div class="w-full max-w-xl rounded-2xl bg-white shadow-2xl ring-1 ring-black/5">
                    <div class="flex items-center justify-between border-b border-slate-100 p-5">
                        <div>
                            <h3 class="text-base font-semibold text-slate-900">Edit task</h3>
                            <p class="mt-1 text-xs text-slate-500">Update fields and save.</p>
                        </div>
                        <button type="button" class="rounded-xl p-2 text-slate-500 hover:bg-slate-100"
                            onclick="closeEditTaskModal()" aria-label="Close">✕</button>
                    </div>

                    @if ($errors->any())
                        <div class="mx-5 mt-4 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
                            <div class="font-semibold">Please fix:</div>
                            <ul class="mt-2 list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('tasks.update', $task) }}" method="POST" class="p-5 space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700" for="edit_title">Title</label>
                            <input id="edit_title" type="text" name="title" required
                                value="{{ old('title', $task->title) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20">
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700"
                                for="edit_description">Description</label>
                            <textarea id="edit_description" name="description" rows="4"
                                class="w-full resize-none rounded-xl border border-slate-300 px-4 py-2.5 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20">{{ old('description', $task->description) }}</textarea>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700" for="edit_due_date">Due
                                    date</label>
                                <input id="edit_due_date" type="date" name="due_date"
                                    value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20">
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700"
                                    for="edit_priority">Priority</label>
                                <select id="edit_priority" name="priority" required
                                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20">
                                    <option value="low" @selected(old('priority', $task->priority) === 'low')>Low</option>
                                    <option value="medium" @selected(old('priority', $task->priority) === 'medium')>Medium</option>
                                    <option value="high" @selected(old('priority', $task->priority) === 'high')>High</option>
                                </select>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700"
                                    for="edit_status">Status</label>
                                <select id="edit_status" name="status" required
                                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20">
                                    <option value="to_do" @selected(old('status', $task->status) === 'to_do')>To Do</option>
                                    <option value="in_progress" @selected(old('status', $task->status) === 'in_progress')>In Progress</option>
                                    <option value="completed" @selected(old('status', $task->status) === 'completed')>Completed</option>
                                </select>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700" for="edit_assigned_to">Assign
                                    to</label>
                                <select id="edit_assigned_to" name="assigned_to"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20">
                                    <option value="">Unassigned</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" @selected(old('assigned_to', $task->assigned_to) == $user->id)>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-2 border-t border-slate-100 pt-4">
                            <button type="button"
                                class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                                onclick="closeEditTaskModal()">
                                Cancel
                            </button>
                            <button type="submit"
                                class="inline-flex items-center gap-2 rounded-xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-sky-700">
                                <i class="bi bi-save2"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        // ------------------------
        // Time tracker
        // ------------------------
        let timer;
        let seconds = 0;
        let isRunning = false;

        const display = document.getElementById('time-display');
        const stateText = document.getElementById('tracker-state');
        const stateDot = document.getElementById('tracker-state-dot');

        function formatTime(sec) {
            const h = Math.floor(sec / 3600);
            const m = Math.floor((sec % 3600) / 60);
            const s = sec % 60;
            return `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
        }

        function updateTimeDisplay() {
            display.innerText = formatTime(seconds);
        }

        function setState(state) {
            stateText.innerText = state;

            stateDot.classList.remove('bg-slate-400', 'bg-emerald-500', 'bg-amber-500');
            if (state === 'Running') stateDot.classList.add('bg-emerald-500');
            else if (state === 'Paused') stateDot.classList.add('bg-amber-500');
            else stateDot.classList.add('bg-slate-400');
        }

        document.getElementById('start-btn').addEventListener('click', () => {
            if (!isRunning) {
                isRunning = true;
                setState('Running');
                timer = setInterval(() => {
                    seconds++;
                    updateTimeDisplay();
                }, 1000);
            }
        });

        document.getElementById('pause-btn').addEventListener('click', () => {
            if (isRunning) {
                isRunning = false;
                clearInterval(timer);
                setState('Paused');
            }
        });

        document.getElementById('reset-btn').addEventListener('click', () => {
            isRunning = false;
            clearInterval(timer);
            seconds = 0;
            updateTimeDisplay();
            setState('Idle');
        });

        updateTimeDisplay();
        setState('Idle');

        // ------------------------
        // Modal helpers
        // ------------------------
        function openEditTaskModal() {
            const modal = document.getElementById('editTaskModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(() => document.getElementById('edit_title')?.focus(), 50);
            document.body.classList.add('overflow-hidden');
        }

        function closeEditTaskModal() {
            const modal = document.getElementById('editTaskModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        document.addEventListener('click', (e) => {
            const modal = document.getElementById('editTaskModal');
            if (modal && !modal.classList.contains('hidden') && e.target === modal) closeEditTaskModal();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeEditTaskModal();
        });

        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', () => openEditTaskModal());
        @endif
    </script>
@endsection
