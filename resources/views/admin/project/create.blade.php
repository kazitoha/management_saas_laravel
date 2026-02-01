@extends('admin.layout.app')

@section('title', 'Create Project')

@section('admin-content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-2">
                    <div class="h-1 w-1.5 bg-sky-600 rounded-full"></div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Create New Project</h1>
                </div>
                <p class="text-slate-600 text-sm sm:text-base">Set up a new project by filling in the details below</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
                <!-- Form Header Background -->
                <div class="bg-gradient-to-r from-sky-600 to-sky-700 h-1"></div>

                <div class="p-6 sm:p-8">
                    <form action="{{ route('projects.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Basic Information Section -->
                        <div class="space-y-5">
                            <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                                <span class="w-1 h-4 bg-sky-600 rounded-full"></span>
                                Basic Information
                            </h3>

                            {{-- Name --}}
                            <div>
                                <label for="name" class="block text-sm font-medium text-slate-800 mb-2">
                                    Project Name <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" placeholder="Enter project name"
                                    value="{{ old('name') }}" required
                                    class="block w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 placeholder-slate-500 transition-colors shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500 focus:ring-opacity-20">
                                @error('name')
                                    <p class="mt-1.5 text-xs text-rose-600 flex items-center gap-1"><svg class="w-3 h-3"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" />
                                        </svg> {{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Client --}}
                            <div>
                                <label for="client_id" class="block text-sm font-medium text-slate-800 mb-2">
                                    Client <span class="text-rose-500">*</span>
                                </label>
                                <select name="client_id" id="client_id" required
                                    class="block w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 transition-colors shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500 focus:ring-opacity-20 appearance-none"
                                    style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 20 20%22%3E%3Cpath stroke=%22%236b7280%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22m6 8 4 4 4-4%22/%3E%3C/svg%3E'); background-position: right 0.5rem center; background-repeat: no-repeat; background-size: 1.5em 1.5em; padding-right: 2.5rem;">
                                    <option value="" disabled {{ old('client_id') ? '' : 'selected' }}>Select a client
                                    </option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}" @selected(old('client_id') == $client->id)>
                                            {{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <p class="mt-1.5 text-xs text-rose-600 flex items-center gap-1"><svg class="w-3 h-3"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" />
                                        </svg> {{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div>
                                <label for="description" class="block text-sm font-medium text-slate-800 mb-2">
                                    Description
                                </label>
                                <textarea name="description" id="description" rows="4" placeholder="Add project details, objectives, or notes..."
                                    class="block w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 placeholder-slate-500 transition-colors shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500 focus:ring-opacity-20 resize-none">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1.5 text-xs text-rose-600 flex items-center gap-1"><svg class="w-3 h-3"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" />
                                        </svg> {{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Timeline Section -->
                        <div class="space-y-5 pt-2">
                            <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                                <span class="w-1 h-4 bg-sky-600 rounded-full"></span>
                                Timeline
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-slate-800 mb-2">
                                        Start Date
                                    </label>
                                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                        class="block w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 transition-colors shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500 focus:ring-opacity-20">
                                    @error('start_date')
                                        <p class="mt-1.5 text-xs text-rose-600 flex items-center gap-1"><svg class="w-3 h-3"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" />
                                            </svg> {{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-slate-800 mb-2">
                                        End Date
                                    </label>
                                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                                        class="block w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 transition-colors shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500 focus:ring-opacity-20">
                                    @error('end_date')
                                        <p class="mt-1.5 text-xs text-rose-600 flex items-center gap-1"><svg class="w-3 h-3"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" />
                                            </svg> {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Project Details Section -->
                        <div class="space-y-5 pt-2">
                            <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                                <span class="w-1 h-4 bg-sky-600 rounded-full"></span>
                                Project Details
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-slate-800 mb-2">
                                        Status <span class="text-rose-500">*</span>
                                    </label>
                                    <select name="status" id="status" required
                                        class="block w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 transition-colors shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500 focus:ring-opacity-20 appearance-none"
                                        style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 20 20%22%3E%3Cpath stroke=%22%236b7280%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22m6 8 4 4 4-4%22/%3E%3C/svg%3E'); background-position: right 0.5rem center; background-repeat: no-repeat; background-size: 1.5em 1.5em; padding-right: 2.5rem;">
                                        <option value="not_started"
                                            {{ old('status') === 'not_started' ? 'selected' : '' }}>
                                            Not Started
                                        </option>
                                        <option value="in_progress"
                                            {{ old('status') === 'in_progress' ? 'selected' : '' }}>
                                            In Progress
                                        </option>
                                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>
                                            Completed
                                        </option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1.5 text-xs text-rose-600 flex items-center gap-1"><svg class="w-3 h-3"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" />
                                            </svg> {{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="budget" class="block text-sm font-medium text-slate-800 mb-2">
                                        Budget
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-2.5 text-slate-600 text-sm">$</span>
                                        <input type="number" name="budget" id="budget" step="0.01"
                                            placeholder="0.00" value="{{ old('budget') }}"
                                            class="block w-full rounded-lg border border-slate-300 bg-white pl-7 pr-4 py-2.5 text-sm text-slate-900 placeholder-slate-500 transition-colors shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500 focus:ring-opacity-20">
                                    </div>
                                    @error('budget')
                                        <p class="mt-1.5 text-xs text-rose-600 flex items-center gap-1"><svg class="w-3 h-3"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" />
                                            </svg> {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="pt-6 flex flex-col sm:flex-row items-center gap-3 border-t border-slate-200">
                            <button type="submit"
                                class="inline-flex items-center justify-center w-full sm:w-auto rounded-lg bg-gradient-to-r from-sky-600 to-sky-700 px-6 py-2.5 text-sm font-semibold text-white shadow-md hover:shadow-lg hover:from-sky-700 hover:to-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                </svg>
                                Create Project
                            </button>

                            <a href="{{ route('projects.index') }}"
                                class="inline-flex items-center justify-center w-full sm:w-auto rounded-lg border border-slate-300 bg-white px-6 py-2.5 text-sm font-medium text-slate-700 shadow-sm hover:shadow-md hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
