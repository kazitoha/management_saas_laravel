@extends('admin.layout.app')

@section('title')
    {{ $project->name }} Edit Project
@endsection

@section('admin-content')
    <div class="mx-auto max-w-4xl px-4 py-10">

        {{-- Page heading --}}
        <div class="mb-6 flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Project
                </p>
                <h2 class="text-2xl font-semibold text-slate-800">
                    Edit: {{ $project->name }}
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Update project details, dates, budget, and status.
                </p>
            </div>

            {{-- Status badge --}}
            <span
                class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-medium text-slate-600">
                <span
                    class="mr-1 h-2 w-2 rounded-full
                    @if ($project->status === 'completed') bg-emerald-500
                    @elseif($project->status === 'in_progress') bg-amber-500
                    @else bg-slate-400 @endif">
                </span>
                {{ ucwords(str_replace('_', ' ', $project->status)) }}
            </span>
        </div>

        {{-- Error summary --}}
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <p class="font-semibold">There were some problems with your submission:</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Card --}}
        <div class="rounded-2xl border border-slate-100 bg-white shadow-lg">
            <div class="border-b border-slate-100 px-6 py-4">
                <h3 class="text-sm font-semibold text-slate-700">Project information</h3>
            </div>

            <div class="px-6 py-6">
                <form action="{{ route('projects.update', $project->id) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div>
                        <label for="name" class="mb-1 block text-sm font-medium text-slate-700">
                            Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                            class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2 text-sm shadow-sm transition
                                   focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/40
                                   @error('name') border-red-500 focus:border-red-500 focus:ring-red-500/40 @enderror"
                            value="{{ old('name', $project->name) }}" required>
                        @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Client --}}
                    <div>
                        <label for="client_id" class="mb-1 block text-sm font-medium text-slate-700">
                            Client <span class="text-red-500">*</span>
                        </label>
                        <select name="client_id" id="client_id" required
                            class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2 text-sm shadow-sm transition
                                   focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/40
                                   @error('client_id') border-red-500 focus:border-red-500 focus:ring-red-500/40 @enderror">
                            <option value="" disabled {{ old('client_id', $project->client_id) ? '' : 'selected' }}>
                                Select client
                            </option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" @selected(old('client_id', $project->client_id) == $client->id)>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('client_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="mb-1 block text-sm font-medium text-slate-700">
                            Description
                        </label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2 text-sm shadow-sm transition
                                   focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/40
                                   @error('description') border-red-500 focus:border-red-500 focus:ring-red-500/40 @enderror">{{ old('description', $project->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Dates in 2-column layout --}}
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        {{-- Start Date --}}
                        <div>
                            <label for="start_date" class="mb-1 block text-sm font-medium text-slate-700">
                                Start Date
                            </label>
                            <input type="date" name="start_date" id="start_date"
                                class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2 text-sm shadow-sm transition
                                       focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/40
                                       @error('start_date') border-red-500 focus:border-red-500 focus:ring-red-500/40 @enderror"
                                value="{{ old('start_date', \Carbon\Carbon::parse($project->start_date)->format('Y-m-d')) }}">
                            @error('start_date')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- End Date --}}
                        <div>
                            <label for="end_date" class="mb-1 block text-sm font-medium text-slate-700">
                                End Date
                            </label>
                            <input type="date" name="end_date" id="end_date"
                                class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2 text-sm shadow-sm transition
                                       focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/40
                                       @error('end_date') border-red-500 focus:border-red-500 focus:ring-red-500/40 @enderror"
                                value="{{ old('end_date', \Carbon\Carbon::parse($project->end_date)->format('Y-m-d')) }}">
                            @error('end_date')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Status & Budget row --}}
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        {{-- Status --}}
                        <div>
                            <label for="status" class="mb-1 block text-sm font-medium text-slate-700">
                                Status
                            </label>
                            <select name="status" id="status"
                                class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2 text-sm shadow-sm transition
                                       focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/40
                                       @error('status') border-red-500 focus:border-red-500 focus:ring-red-500/40 @enderror">
                                <option value="not_started"
                                    {{ old('status', $project->status) == 'not_started' ? 'selected' : '' }}>
                                    Not Started
                                </option>
                                <option value="in_progress"
                                    {{ old('status', $project->status) == 'in_progress' ? 'selected' : '' }}>
                                    In Progress
                                </option>
                                <option value="completed"
                                    {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>
                                    Completed
                                </option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Budget --}}
                        <div>
                            <label for="budget" class="mb-1 block text-sm font-medium text-slate-700">
                                Budget
                            </label>
                            <div class="relative">
                                <span
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-xs text-slate-400">
                                    $
                                </span>
                                <input type="number" name="budget" id="budget" step="0.01"
                                    class="w-full rounded-md border border-slate-300 bg-slate-50 pl-7 pr-3 py-2 text-sm shadow-sm transition
                                           focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/40
                                           @error('budget') border-red-500 focus:border-red-500 focus:ring-red-500/40 @enderror"
                                    value="{{ old('budget', $project->budget) }}">
                            </div>
                            @error('budget')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="mt-6 flex items-center justify-end gap-3 border-t border-slate-100 pt-4">
                        <a href="{{ url()->previous() }}" class="text-sm font-medium text-slate-500 hover:text-slate-700">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm
                                   hover:bg-indigo-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">
                            Update Project
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
