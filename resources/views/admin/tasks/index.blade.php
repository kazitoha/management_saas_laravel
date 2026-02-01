@extends('admin.layout.app')

@section('title', $project->name . ' - Tasks')

@section('admin-content')
    <style>
        .kanban-item.invisible {
            opacity: 0.4;
        }
    </style>

    @php
        $totalTasks =
            ($tasks['to_do'] ?? collect())->count() +
            ($tasks['in_progress'] ?? collect())->count() +
            ($tasks['completed'] ?? collect())->count();
        $completedTasks = ($tasks['completed'] ?? collect())->count();
        $progress = $totalTasks ? round(($completedTasks / $totalTasks) * 100) : 0;
    @endphp

    <div class="mx-auto max-w-6xl space-y-4 px-4 py-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div
            class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="text-xs font-semibold uppercase tracking-wide text-slate-400">Project Tasks</div>
                <h2 class="text-xl font-semibold text-slate-800">{{ $project->name }}</h2>
                <p class="text-sm text-slate-500">Drag tasks between columns or update status.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('projects.show', $project) }}"
                    class="inline-flex items-center rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                    Back to Project
                </a>
                <a href="{{ route('projects.index') }}"
                    class="inline-flex items-center rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                    All Projects
                </a>
            </div>
        </div>

        {{-- Summary --}}
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="text-xs uppercase text-slate-400">Total Tasks</div>
                <div class="text-2xl font-semibold text-slate-800">{{ $totalTasks }}</div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="text-xs uppercase text-slate-400">Completed</div>
                <div class="text-2xl font-semibold text-emerald-600">{{ $completedTasks }}</div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="text-xs uppercase text-slate-400">Progress</div>
                <div class="text-2xl font-semibold text-slate-800">{{ $progress }}%</div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="text-xs uppercase text-slate-400">Team Members</div>
                <div class="text-2xl font-semibold text-slate-800">{{ $users->count() }}</div>
            </div>
        </div>

        {{-- Success message --}}
        @if (session('success'))
            <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        {{-- Kanban columns --}}
        <div class="grid gap-4 md:grid-cols-3">
            {{-- To Do --}}
            <div class="bg-slate-50 rounded-lg border border-slate-200 flex flex-col">
                <div class="flex justify-between items-center bg-sky-600 text-white px-3 py-2 rounded-t-lg shadow-sm gap-2">
                    <h4 class="text-sm font-semibold m-0">To Do</h4>
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-md bg-white text-sky-700 text-sm font-semibold w-8 h-8 hover:bg-slate-100"
                        onclick="openCreateTaskModal('to_do')">
                        +
                    </button>
                </div>

                <div class="kanban-list flex-1 bg-slate-100 rounded-b-lg p-3 space-y-3 min-h-[400px]" id="to_do">
                    @foreach ($tasks['to_do'] ?? [] as $task)
                        <div class="kanban-item bg-white border border-slate-200 rounded-md shadow-sm p-3"
                            data-id="{{ $task->id }}" draggable="true">
                            <div class="flex justify-between items-start gap-2 mb-1">
                                <h5 class="text-sm font-semibold text-slate-800">
                                    {{ $task->title }}
                                </h5>
                                <span
                                    class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-medium
                                    {{ $task->priority == 'low' ? 'bg-emerald-100 text-emerald-800' : ($task->priority == 'medium' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }}">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </div>

                            <p class="text-xs text-slate-600 mb-2">
                                {{ $task->description }}
                            </p>

                            <a href="{{ route('tasks.show', $task->id) }}"
                                class="inline-flex items-center rounded-md border border-sky-500 text-sky-600 bg-white px-2 py-1 text-xs hover:bg-sky-50"
                                title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- In Progress --}}
            <div class="bg-slate-50 rounded-lg border border-slate-200 flex flex-col">
                <div
                    class="flex justify-between items-center bg-amber-400 text-slate-900 px-3 py-2 rounded-t-lg shadow-sm gap-2">
                    <h4 class="text-sm font-semibold m-0">In Progress</h4>
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-md bg-white text-amber-700 text-sm font-semibold w-8 h-8 hover:bg-slate-100"
                        onclick="openCreateTaskModal('in_progress')">
                        +
                    </button>
                </div>

                <div class="kanban-list flex-1 bg-slate-100 rounded-b-lg p-3 space-y-3 min-h-[400px]" id="in_progress">
                    @foreach ($tasks['in_progress'] ?? [] as $task)
                        <div class="kanban-item bg-white border border-slate-200 rounded-md shadow-sm p-3"
                            data-id="{{ $task->id }}" draggable="true">
                            <div class="flex justify-between items-start gap-2 mb-1">
                                <h5 class="text-sm font-semibold text-slate-800">
                                    {{ $task->title }}
                                </h5>
                            </div>

                            <p class="text-xs text-slate-600 mb-2">
                                {{ $task->description }}
                            </p>

                            <a href="{{ route('tasks.show', $task->id) }}"
                                class="inline-flex items-center rounded-md border border-amber-400 text-amber-700 bg-amber-50 px-2 py-1 text-xs hover:bg-amber-100"
                                title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Completed --}}
            <div class="bg-slate-50 rounded-lg border border-slate-200 flex flex-col">
                <div
                    class="flex justify-between items-center bg-emerald-600 text-white px-3 py-2 rounded-t-lg shadow-sm gap-2">
                    <h4 class="text-sm font-semibold m-0">Completed</h4>
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-md bg-white text-emerald-700 text-sm font-semibold w-8 h-8 hover:bg-slate-100"
                        onclick="openCreateTaskModal('completed')">
                        +
                    </button>
                </div>

                <div class="kanban-list flex-1 bg-slate-100 rounded-b-lg p-3 space-y-3 min-h-[400px]" id="completed">
                    @foreach ($tasks['completed'] ?? [] as $task)
                        <div class="kanban-item bg-white border border-slate-200 rounded-md shadow-sm p-3"
                            data-id="{{ $task->id }}" draggable="true">
                            <div class="flex justify-between items-start gap-2 mb-1">
                                <h5 class="text-sm font-semibold text-slate-800">
                                    {{ $task->title }}
                                </h5>
                            </div>

                            <p class="text-xs text-slate-600 mb-2">
                                {{ $task->description }}
                            </p>

                            <a href="{{ route('tasks.show', $task->id) }}"
                                class="inline-flex items-center rounded-md border border-emerald-500 text-emerald-600 bg-emerald-50 px-2 py-1 text-xs hover:bg-emerald-100"
                                title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Create Task Modal (Tailwind dialog) --}}
        <dialog id="createTaskModal"
            class="rounded-lg p-0 shadow-xl backdrop:bg-black/30 backdrop:backdrop-blur-sm w-full max-w-md">
            <form action="{{ route('projects.tasks.store', $project->id) }}" method="POST"
                class="bg-white rounded-lg overflow-hidden w-full">
                @csrf

                <div class="px-4 py-3 border-b border-slate-200 flex items-center justify-between">
                    <h5 class="text-base font-semibold text-slate-800">Create Task</h5>
                    <button type="button" class="text-slate-500 hover:text-slate-700"
                        onclick="document.getElementById('createTaskModal').close()">
                        ✕
                    </button>
                </div>

                <div class="px-4 py-4 space-y-3 text-sm">
                    {{-- Title --}}
                    <div>
                        <label for="title" class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                        <input type="text" name="title" id="title"
                            class="block w-full rounded-md border border-slate-300 px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500"
                            required>
                        @error('title')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="block w-full rounded-md border border-slate-300 px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500"></textarea>
                        @error('description')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Due date --}}
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-slate-700 mb-1">Due Date</label>
                        <input type="date" name="due_date" id="due_date"
                            class="block w-full rounded-md border border-slate-300 px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                        @error('due_date')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Priority --}}
                    <div>
                        <label for="priority" class="block text-sm font-medium text-slate-700 mb-1">Priority</label>
                        <select name="priority" id="priority"
                            class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500"
                            required>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                        @error('priority')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Assign To --}}
                    <div>
                        <label for="assigned_to" class="block text-sm font-medium text-slate-700 mb-1">Assign To</label>
                        <select name="assigned_to" id="assigned_to"
                            class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                            <option value="{{ auth()->user()->id }}">Self</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('assigned_to')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <input type="hidden" name="status" id="task_status">
                </div>

                <div class="px-4 py-3 border-t border-slate-200 flex justify-end gap-2">
                    <button type="button"
                        class="px-3 py-2 text-sm rounded-md border border-slate-300 text-slate-700 bg-white hover:bg-slate-50"
                        onclick="document.getElementById('createTaskModal').close()">
                        Close
                    </button>
                    <button type="submit"
                        class="px-3 py-2 text-sm rounded-md border border-sky-500 text-sky-600 bg-sky-50 hover:bg-sky-100">
                        Create Task
                    </button>
                </div>
            </form>
        </dialog>
    </div>

    <script>
        function openCreateTaskModal(status) {
            const modal = document.getElementById('createTaskModal');
            const statusInput = document.getElementById('task_status');
            if (statusInput) statusInput.value = status;
            if (modal && typeof modal.showModal === 'function') {
                modal.showModal();
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const kanbanItems = document.querySelectorAll('.kanban-item');
            const kanbanLists = document.querySelectorAll('.kanban-list');

            kanbanItems.forEach(item => {
                item.addEventListener('dragstart', handleDragStart);
                item.addEventListener('dragend', handleDragEnd);
            });

            kanbanLists.forEach(list => {
                list.addEventListener('dragover', handleDragOver);
                list.addEventListener('drop', handleDrop);
            });

            function handleDragStart(e) {
                e.dataTransfer.setData('text/plain', e.target.dataset.id);
                setTimeout(() => {
                    e.target.classList.add('invisible');
                }, 0);
            }

            function handleDragEnd(e) {
                e.target.classList.remove('invisible');
            }

            function handleDragOver(e) {
                e.preventDefault();
            }

            function handleDrop(e) {
                e.preventDefault();
                const id = e.dataTransfer.getData('text');
                const draggableElement = document.querySelector(`.kanban-item[data-id='${id}']`);
                const dropzone = e.target.closest('.kanban-list');
                if (!dropzone || !draggableElement) return;

                dropzone.appendChild(draggableElement);
                const status = dropzone.id;
                updateTaskStatus(id, status);
            }

            function updateTaskStatus(id, status) {
                fetch(`/tasks/${id}/status`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            status
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to update task status');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Task status updated:', data);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        });
    </script>
@endsection
