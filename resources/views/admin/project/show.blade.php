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
        $clientName = $project->client?->name ?? '—';
    @endphp

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4 space-y-4">
        {{-- Header --}}
        <div class="flex justify-between items-center bg-white shadow-sm p-4 rounded-lg border border-slate-200">
            <div class="flex items-center gap-2">
                <i class="bi bi-folder2-open text-sky-600 text-xl"></i>
                <h2 class="text-lg font-semibold text-slate-800 m-0">
                    {{ $project->name }}
                </h2>
            </div>

            @include('partials.status-badge', ['status' => $project->status])
        </div>

        {{-- Flash success --}}
        @if (session('success'))
            <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        {{-- Main Grid --}}
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-5">
            {{-- Left: Overview & Progress --}}
            <div class="lg:col-span-3 space-y-4">
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="p-4">
                        {{-- Overview --}}
                        <h5 class="text-sm font-semibold text-slate-800 mb-2">Overview</h5>
                        <p class="text-sm text-slate-500 mb-4">
                            {{ $project->description ?: 'No description provided for this project.' }}
                        </p>

                        {{-- Project Info --}}
                        <div class="grid grid-cols-1 gap-2 text-xs md:grid-cols-2">
                            {{-- Start Date --}}
                            <div class="p-2 rounded border border-slate-200 bg-slate-50">
                                <div class="mb-0.5 flex items-center gap-1 text-slate-500">
                                    <i class="bi bi-calendar-date text-slate-400"></i>
                                    <span>Start</span>
                                </div>
                                <div class="font-semibold text-slate-800">
                                    {{ $startDate }}
                                </div>
                            </div>

                            {{-- End Date --}}
                            <div class="p-2 rounded border border-slate-200 bg-slate-50">
                                <div class="mb-0.5 flex items-center gap-1 text-slate-500">
                                    <i class="bi bi-calendar2-event text-slate-400"></i>
                                    <span>End</span>
                                </div>
                                <div class="font-semibold text-slate-800">
                                    {{ $endDate }}
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="p-2 rounded border border-slate-200 bg-slate-50">
                                <div class="mb-0.5 flex items-center gap-1 text-slate-500">
                                    <i class="bi bi-flag text-slate-400"></i>
                                    <span>Status</span>
                                </div>
                                <div class="font-semibold text-slate-800">
                                    @include('partials.status-badge', ['status' => $project->status])
                                </div>
                            </div>

                            {{-- Client --}}
                            <div class="p-2 rounded border border-slate-200 bg-slate-50">
                                <div class="mb-0.5 flex items-center gap-1 text-slate-500">
                                    <i class="bi bi-briefcase text-slate-400"></i>
                                    <span>Client</span>
                                </div>
                                <div class="font-semibold text-slate-800">
                                    {{ $clientName }}
                                </div>
                            </div>

                            {{-- Budget --}}
                            <div class="p-2 rounded border border-slate-200 bg-slate-50">
                                <div class="mb-0.5 flex items-center gap-1 text-slate-500">
                                    <i class="bi bi-cash-coin text-slate-400"></i>
                                    <span>Budget</span>
                                </div>
                                <div class="font-semibold text-slate-800">
                                    {{ $budget }}
                                </div>
                            </div>
                        </div>

                        {{-- Progress --}}
                        <h5 class="mt-5 mb-2 text-sm font-semibold text-slate-800">Project Progress</h5>

                        <div class="mb-2 h-2 w-full overflow-hidden rounded-full bg-slate-200">
                            <div class="h-2 rounded-full bg-emerald-500" style="width: {{ $progress }}%;"></div>
                        </div>

                        <div class="mb-4 flex justify-between text-[11px] text-slate-500">
                            <span>{{ round($progress) }}% complete</span>
                            <span>{{ $completedTasks }} / {{ $totalTasks }} tasks</span>
                        </div>

                        {{-- Back Button --}}
                        <a href="{{ route('projects.index') }}"
                            class="inline-flex items-center rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                            Back to Projects
                        </a>
                    </div>
                </div>
            </div>



            {{-- Right: Team Members --}}
            <div class="lg:col-span-2 space-y-4">
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="p-4">
                        {{-- Header --}}
                        <div class="mb-3 flex items-center justify-between">
                            <h5 class="m-0 text-sm font-semibold text-slate-800">Team Members</h5>

                            {{-- Tailwind Modal --}}

                            <!-- Button -->
                            <button type="button"
                                class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700"
                                onclick="openModal('teamModal')">
                                <i class="bi bi-plus-circle"></i>
                            </button>

                            <!-- Modal -->
                            <div id="teamModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
                                <!-- Backdrop -->
                                <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"
                                    onclick="closeModal('teamModal')"></div>

                                <!-- Panel -->
                                <div
                                    class="relative w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-black/5">
                                    <!-- Header -->
                                    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                                        <h3 class="text-base font-semibold text-slate-900">Add Team Member</h3>
                                        <button type="button"
                                            class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-700"
                                            onclick="closeModal('teamModal')">
                                            ✕
                                        </button>
                                    </div>

                                    <!-- Body -->
                                    <div class="px-5 py-5">
                                        <form action="{{ route('projects.addMember') }}" method="POST" class="space-y-4">
                                            @csrf
                                            <div>
                                                <input type="hidden" name="project_id" value="{{ $project->id }}">
                                                <label class="block text-sm font-medium text-slate-700">Select user</label>
                                                <select name="user_id"
                                                    class="mt-1 block w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20">

                                                    <option value="">Select a user</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}
                                                            ({{ $user->email }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Footer -->
                                            <div class="flex items-center justify-end gap-2 border-t border-slate-100 pt-4">
                                                <button type="button"
                                                    class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50"
                                                    onclick="closeModal('teamModal')">
                                                    Cancel
                                                </button>

                                                <button type="submit"
                                                    class="rounded-xl bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700">
                                                    Add Member
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>




                        </div>

                        {{-- Members List --}}
                        @if ($teamMembers->isEmpty())
                            <p class="text-xs text-slate-500">
                                No team members added yet.
                            </p>
                        @else
                            <div class="space-y-2">
                                @foreach ($teamMembers as $user)
                                    <div
                                        class="flex items-center gap-3 rounded border border-slate-200 bg-white p-2 shadow-sm">
                                        {{-- Avatar --}}
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-xs font-semibold text-slate-700">
                                            {{ Str::of($user->name ?? 'U')->substr(0, 1)->upper() }}
                                        </div>

                                        {{-- Info --}}
                                        <div class="flex-1">
                                            <div class="text-sm font-semibold text-slate-800">
                                                {{ $user->name }}
                                            </div>
                                            <div class="text-xs text-slate-500">
                                                {{ $user->email }}
                                            </div>
                                        </div>

                                        {{-- Remove Button --}}

                                        <form method="POST" action="{{ route('projects.removeMember') }}"
                                            onsubmit="return confirm('Remove this member from the project?');">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">

                                            <button type="submit"
                                                class="inline-flex items-center justify-center rounded-md border border-rose-400 bg-rose-50 px-2.5 py-1.5 text-xs text-rose-600 hover:bg-rose-100">
                                                <i class="bi bi-person-dash"></i>
                                            </button>
                                        </form>

                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }

    // ESC close
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeModal('teamModal');
    });
</script>
