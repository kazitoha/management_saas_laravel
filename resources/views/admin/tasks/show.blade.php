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

    <div class="mx-auto max-w-5xl space-y-4 px-4 py-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="p-4 sm:p-5">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    {{-- Left --}}
                    <div class="min-w-0">
                        <div class="flex items-start gap-3">
                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-sky-50 ring-1 ring-sky-100">
                                <i class="bi bi-check2-square text-sky-600 text-xl"></i>
                            </div>

                            <div class="min-w-0">
                                <div class="text-xs font-semibold uppercase tracking-wider text-slate-400">Task</div>
                                <h2 class="mt-0.5 truncate text-xl font-semibold text-slate-900 sm:text-2xl">
                                    {{ $task->title }}
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    Project:
                                    @if ($task->project)
                                        <a href="{{ route('projects.show', $task->project) }}"
                                            class="font-medium text-sky-600 hover:text-sky-700 hover:underline">
                                            {{ $task->project->name }}
                                        </a>
                                    @else
                                        —
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Right --}}
                    <div class="flex flex-wrap items-center gap-2 sm:justify-end">
                        {{-- Status + Priority --}}
                        <div class="flex flex-wrap items-center gap-2">
                            @include('partials.status-badge', ['status' => $task->status])

                            <span
                                class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-1 text-[11px] font-semibold {{ $priorityBadge }}">
                                <span
                                    class="h-1.5 w-1.5 rounded-full
                            {{ $task->priority === 'high' ? 'bg-rose-500' : ($task->priority === 'medium' ? 'bg-amber-500' : 'bg-slate-400') }}"></span>
                                {{ $priorityLabel }}
                            </span>
                        </div>

                        {{-- Divider (desktop) --}}
                        <div class="hidden h-6 w-px bg-slate-200 sm:block"></div>

                        {{-- Actions --}}
                        @if (!$task->assigned_to)
                            <form action="{{ route('tasks.assignToMe', $task) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-lg border border-sky-200 bg-sky-50 px-3 py-2 text-sm font-semibold text-sky-700 hover:bg-sky-100">
                                    <i class="bi bi-person-check"></i>
                                    Assign to me
                                </button>
                            </form>
                        @endif

                        <button type="button"
                            class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-800"
                            onclick="openEditTaskModal()">
                            <i class="bi bi-pencil-square"></i>
                            Edit
                        </button>

                        <a href="{{ route('projects.tasks.index', $task->project_id) }}"
                            class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50">
                            <i class="bi bi-arrow-left"></i>
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>



        {{-- Main grid --}}
        <div class="grid gap-4 lg:grid-cols-5">
            {{-- Left --}}
            <div class="space-y-4 lg:col-span-3">
                {{-- Details --}}
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
                                <div class="font-semibold text-slate-800">
                                    {{ ucwords(str_replace('_', ' ', $task->status)) }}
                                </div>
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

                {{-- Checklist --}}
                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 px-4 py-3">
                        <h3 class="text-sm font-semibold text-slate-700">Checklist</h3>
                    </div>

                    <div class="space-y-3 p-4">
                        <form action="{{ route('tasks.checklist.store', $task) }}" method="POST"
                            class="flex flex-col gap-2 sm:flex-row">
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
                                    <li
                                        class="flex items-center justify-between rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">
                                        <form action="{{ route('tasks.checklist.toggle', $item) }}" method="POST"
                                            class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="h-4 w-4 rounded border border-slate-300 {{ $item->is_completed ? 'bg-emerald-500 border-emerald-500' : 'bg-white' }}">
                                                <span class="sr-only">Toggle</span>
                                            </button>
                                            <span
                                                class="text-sm {{ $item->is_completed ? 'line-through text-slate-400' : 'text-slate-700' }}">
                                                {{ $item->title }}
                                            </span>
                                        </form>

                                        <form action="{{ route('tasks.checklist.destroy', $item) }}" method="POST"
                                            onsubmit="return confirm('Delete this item?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center rounded-md border border-rose-400 bg-rose-50 px-2.5 py-1.5 text-xs text-rose-600 hover:bg-rose-100">
                                                Delete
                                            </button>
                                        </form>

                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right --}}
            <div class="space-y-4 lg:col-span-2">
                {{-- Summary --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="text-xs uppercase text-slate-400">Task Summary</div>
                    <div class="mt-2 text-sm text-slate-600">
                        <p><span class="font-semibold text-slate-800">Project:</span> {{ $task->project?->name ?? '—' }}
                        </p>
                        <p><span class="font-semibold text-slate-800">Assignee:</span>
                            {{ $task->user?->name ?? 'Unassigned' }}</p>
                        <p><span class="font-semibold text-slate-800">Due:</span> {{ $dueLabel }}</p>
                    </div>
                </div>

                {{-- Quick Status --}}
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

                {{-- Danger Zone --}}
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

            </div>
        </div>
    </div>


    <div id="editTaskModal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/30 backdrop-blur-sm p-4">
        <div class="w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-xl">
            <div class="flex items-center justify-between border-b border-slate-100 px-4 py-3">
                <h3 class="text-sm font-semibold text-slate-700">Edit Task</h3>
                <button type="button" class="text-slate-500 hover:text-slate-700"
                    onclick="closeEditTaskModal()">✕</button>
            </div>

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="m-4 rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-4 p-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="edit_title" class="mb-1 block text-sm font-medium text-slate-700">Title</label>
                    <input type="text" name="title" id="edit_title" value="{{ old('title', $task->title) }}"
                        required
                        class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30">
                </div>

                <div>
                    <label for="edit_description"
                        class="mb-1 block text-sm font-medium text-slate-700">Description</label>
                    <textarea name="description" id="edit_description" rows="3"
                        class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30">{{ old('description', $task->description) }}</textarea>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="edit_due_date" class="mb-1 block text-sm font-medium text-slate-700">Due
                            Date</label>
                        <input type="date" name="due_date" id="edit_due_date"
                            value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}"
                            class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30">
                    </div>

                    <div>
                        <label for="edit_priority" class="mb-1 block text-sm font-medium text-slate-700">Priority</label>
                        <select name="priority" id="edit_priority" required
                            class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30">
                            <option value="low" @selected(old('priority', $task->priority) === 'low')>Low</option>
                            <option value="medium" @selected(old('priority', $task->priority) === 'medium')>Medium</option>
                            <option value="high" @selected(old('priority', $task->priority) === 'high')>High</option>
                        </select>
                    </div>

                    <div>
                        <label for="edit_status" class="mb-1 block text-sm font-medium text-slate-700">Status</label>
                        <select name="status" id="edit_status" required
                            class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30">
                            <option value="to_do" @selected(old('status', $task->status) === 'to_do')>To Do</option>
                            <option value="in_progress" @selected(old('status', $task->status) === 'in_progress')>In Progress</option>
                            <option value="completed" @selected(old('status', $task->status) === 'completed')>Completed</option>
                        </select>
                    </div>

                    <div>
                        <label for="edit_assigned_to" class="mb-1 block text-sm font-medium text-slate-700">Assign
                            To</label>
                        <select name="assigned_to" id="edit_assigned_to"
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

                <div class="flex justify-end gap-2 border-t border-slate-100 pt-4">
                    <button type="button"
                        class="inline-flex items-center rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                        onclick="closeEditTaskModal()">
                        Cancel
                    </button>
                    <button type="submit"
                        class="inline-flex items-center rounded-md bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditTaskModal() {
            const modal = document.getElementById('editTaskModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditTaskModal() {
            const modal = document.getElementById('editTaskModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // close on backdrop click
        document.addEventListener('click', (e) => {
            const modal = document.getElementById('editTaskModal');
            if (!modal) return;
            if (!modal.classList.contains('hidden') && e.target === modal) closeEditTaskModal();
        });

        // close on ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeEditTaskModal();
        });

        // auto-open modal when validation fails
        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', () => openEditTaskModal());
        @endif
    </script>

@endsection
