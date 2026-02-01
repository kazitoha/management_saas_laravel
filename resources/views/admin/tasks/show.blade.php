@extends('admin.layout.app')

@section('title', $task->title)

@section('admin-content')
    @php
        $priorityLabel = ucfirst($task->priority);
        $priorityBadge = match ($task->priority) {
            'high' => 'bg-rose-100 text-rose-700 border-rose-200',
            'medium' => 'bg-amber-100 text-amber-700 border-amber-200',
            default => 'bg-slate-100 text-slate-700 border-slate-200',
        };
        $dueLabel = $task->due_date ? $task->due_date->format('Y-m-d') : '—';
        $isOverdue = $task->due_date && $task->due_date->isPast() && $task->status !== 'completed';
    @endphp

    <div class="max-w-5xl space-y-4">
        <div class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="text-xs font-semibold uppercase tracking-wide text-slate-400">Task</div>
                <h2 class="text-2xl font-semibold text-slate-800">{{ $task->title }}</h2>
                <p class="text-sm text-slate-500">
                    Project:
                    @if ($task->project)
                        <a href="{{ route('projects.show', $task->project) }}" class="text-sky-600 hover:underline">
                            {{ $task->project->name }}
                        </a>
                    @else
                        —
                    @endif
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                @include('partials.status-badge', ['status' => $task->status])
                <span class="inline-flex items-center rounded-full border px-2.5 py-1 text-[11px] font-semibold {{ $priorityBadge }}">
                    {{ $priorityLabel }}
                </span>
                @if (!$task->assigned_to)
                    <form action="{{ route('tasks.assignToMe', $task) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center rounded-md border border-sky-500 bg-white px-3 py-2 text-sm text-sky-600 hover:bg-sky-50">
                            Assign to me
                        </button>
                    </form>
                @endif
                <a href="{{ route('projects.tasks.index', $task->project_id) }}"
                    class="inline-flex items-center rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                    Back to Tasks
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-4 lg:grid-cols-5">
            <div class="space-y-4 lg:col-span-3">
                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 px-4 py-3">
                        <h3 class="text-sm font-semibold text-slate-700">Task Details</h3>
                    </div>

                    <div class="p-4 text-sm text-slate-600">
                        <div class="grid gap-3 sm:grid-cols-2">
                            <div>
                                <div class="text-xs uppercase text-slate-400">Assigned To</div>
                                <div class="font-semibold text-slate-800">{{ $task->user?->name ?? 'Unassigned' }}</div>
                            </div>
                            <div>
                                <div class="text-xs uppercase text-slate-400">Due Date</div>
                                <div class="font-semibold {{ $isOverdue ? 'text-rose-600' : 'text-slate-800' }}">
                                    {{ $dueLabel }}
                                </div>
                            </div>
                            <div>
                                <div class="text-xs uppercase text-slate-400">Priority</div>
                                <div class="font-semibold text-slate-800">{{ $priorityLabel }}</div>
                            </div>
                            <div>
                                <div class="text-xs uppercase text-slate-400">Status</div>
                                <div class="font-semibold text-slate-800">{{ ucwords(str_replace('_', ' ', $task->status)) }}</div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="text-xs uppercase text-slate-400">Description</div>
                            <div class="mt-1 text-slate-700">
                                {{ $task->description ?: 'No description provided.' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 px-4 py-3">
                        <h3 class="text-sm font-semibold text-slate-700">Checklist</h3>
                    </div>
                    <div class="p-4 space-y-3">
                        <form action="{{ route('tasks.checklist.store', $task) }}" method="POST" class="flex flex-col gap-2 sm:flex-row">
                            @csrf
                            <input type="text" name="title" placeholder="Add checklist item..." required
                                class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30">
                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-md border border-sky-500 bg-white px-4 py-2 text-sm font-medium text-sky-600 hover:bg-sky-50">
                                Add Item
                            </button>
                        </form>

                        @if ($task->checklistItems->isEmpty())
                            <p class="text-sm text-slate-500">No checklist items yet.</p>
                        @else
                            <ul class="space-y-2">
                                @foreach ($task->checklistItems as $item)
                                    <li class="flex items-center justify-between rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">
                                        <form action="{{ route('tasks.checklist.toggle', $item) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="h-4 w-4 rounded border border-slate-300 {{ $item->is_completed ? 'bg-emerald-500 border-emerald-500' : 'bg-white' }}">
                                                <span class="sr-only">Toggle</span>
                                            </button>
                                            <span class="text-sm {{ $item->is_completed ? 'line-through text-slate-400' : 'text-slate-700' }}">
                                                {{ $item->title }}
                                            </span>
                                        </form>
                                        @if ($canEditTask)
                                            <form action="{{ route('tasks.checklist.destroy', $item) }}" method="POST"
                                                onsubmit="return confirm('Delete this item?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center rounded-md border border-rose-400 bg-rose-50 px-2.5 py-1.5 text-xs text-rose-600 hover:bg-rose-100">
                                                    Delete
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

            <div class="space-y-4 lg:col-span-2">
                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="text-xs uppercase text-slate-400">Task Summary</div>
                    <div class="mt-2 text-sm text-slate-600">
                        <p><span class="font-semibold text-slate-800">Project:</span>
                            {{ $task->project?->name ?? '—' }}</p>
                        <p><span class="font-semibold text-slate-800">Assignee:</span>
                            {{ $task->user?->name ?? 'Unassigned' }}</p>
                        <p><span class="font-semibold text-slate-800">Due:</span> {{ $dueLabel }}</p>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="text-xs uppercase text-slate-400">Quick Status</div>
                    <form action="{{ route('tasks.updateStatus', $task) }}" method="POST" class="mt-2 space-y-2">
                        @csrf
                        @method('PATCH')
                        <select name="status"
                            class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30">
                            <option value="to_do" @selected($task->status === 'to_do')>To Do</option>
                            <option value="in_progress" @selected($task->status === 'in_progress')>In Progress</option>
                            <option value="completed" @selected($task->status === 'completed')>Completed</option>
                        </select>
                        <button type="submit"
                            class="inline-flex w-full items-center justify-center rounded-md bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">
                            Update Status
                        </button>
                    </form>
                </div>

                @if ($canEditTask)
                    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="text-xs uppercase text-slate-400">Danger Zone</div>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                            onsubmit="return confirm('Delete this task? This cannot be undone.');" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex w-full items-center justify-center rounded-md border border-rose-500 bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-700 hover:bg-rose-100">
                                Delete Task
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        @if ($canEditTask)
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 px-4 py-3">
                    <h3 class="text-sm font-semibold text-slate-700">Edit Task</h3>
                </div>
                <form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-4 p-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="title" class="mb-1 block text-sm font-medium text-slate-700">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}"
                            required
                            class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30">
                    </div>

                    <div>
                        <label for="description" class="mb-1 block text-sm font-medium text-slate-700">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30">{{ old('description', $task->description) }}</textarea>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="due_date" class="mb-1 block text-sm font-medium text-slate-700">Due Date</label>
                            <input type="date" name="due_date" id="due_date"
                                value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}"
                                class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30">
                        </div>
                        <div>
                            <label for="priority" class="mb-1 block text-sm font-medium text-slate-700">Priority</label>
                            <select name="priority" id="priority" required
                                class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30">
                                <option value="low" @selected(old('priority', $task->priority) === 'low')>Low</option>
                                <option value="medium" @selected(old('priority', $task->priority) === 'medium')>Medium</option>
                                <option value="high" @selected(old('priority', $task->priority) === 'high')>High</option>
                            </select>
                        </div>
                        <div>
                            <label for="status" class="mb-1 block text-sm font-medium text-slate-700">Status</label>
                            <select name="status" id="status" required
                                class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30">
                                <option value="to_do" @selected(old('status', $task->status) === 'to_do')>To Do</option>
                                <option value="in_progress" @selected(old('status', $task->status) === 'in_progress')>In Progress</option>
                                <option value="completed" @selected(old('status', $task->status) === 'completed')>Completed</option>
                            </select>
                        </div>
                        <div>
                            <label for="assigned_to" class="mb-1 block text-sm font-medium text-slate-700">Assign To</label>
                            <select name="assigned_to" id="assigned_to"
                                class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30">
                                <option value="">Unassigned</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('assigned_to', $task->assigned_to) == $user->id)>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center rounded-md bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
@endsection
