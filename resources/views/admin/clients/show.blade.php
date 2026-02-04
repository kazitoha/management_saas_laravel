@extends('admin.layout.app')

@section('title', $client->name)

@section('admin-content')
    <div class="min-h-[calc(100vh-4rem)] bg-gradient-to-br from-slate-50 via-white to-slate-100 py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Header --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-lg overflow-hidden">
                <div class="h-1 bg-gradient-to-r from-sky-600 to-sky-700"></div>

                <div class="p-5 sm:p-5">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        {{-- Left --}}
                        <div class="min-w-0">
                            <div class="flex items-start gap-3">
                                <div
                                    class="grid h-11 w-11 place-items-center rounded-2xl bg-sky-50 text-sky-700 ring-1 ring-sky-100">
                                    <i class="bi bi-person-vcard text-xl"></i>
                                </div>

                                <div class="min-w-0">
                                    <div class="text-xs font-semibold uppercase tracking-wider text-slate-400">Client</div>
                                    <h1 class="mt-0.5 truncate text-2xl font-bold text-slate-900 sm:text-3xl">
                                        {{ $client->name }}
                                    </h1>
                                    <p class="mt-1 text-sm text-slate-600">Client profile and linked projects.</p>

                                    {{-- Meta chips --}}
                                    <div class="mt-3 flex flex-wrap items-center gap-2 text-xs text-slate-500">
                                        @if (!empty($client->email))
                                            <span
                                                class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 ring-1 ring-slate-200">
                                                <i class="bi bi-envelope text-slate-500"></i>
                                                <span class="truncate max-w-[260px]">{{ $client->email }}</span>
                                            </span>
                                        @endif

                                        @if (!empty($client->phone))
                                            <span
                                                class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 ring-1 ring-slate-200">
                                                <i class="bi bi-telephone text-slate-500"></i>
                                                <span>{{ $client->phone }}</span>
                                            </span>
                                        @endif

                                        @if (!empty($client->company))
                                            <span
                                                class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 ring-1 ring-slate-200">
                                                <i class="bi bi-building text-slate-500"></i>
                                                <span class="truncate max-w-[220px]">{{ $client->company }}</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Right actions --}}
                        <div class="flex flex-wrap items-center gap-2 sm:justify-end">
                            <a href="{{ route('clients.edit', $client) }}"
                                class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 active:scale-[0.99]">
                                <i class="bi bi-pencil-square"></i>
                                Edit
                            </a>

                            <a href="{{ route('clients.index') }}"
                                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 active:scale-[0.99]">
                                <i class="bi bi-arrow-left"></i>
                                Back
                            </a>
                        </div>
                    </div>

                    {{-- Stats --}}
                    <div class="mt-5 grid gap-3 sm:grid-cols-3">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50/60 p-4">
                            <div class="text-xs font-semibold uppercase tracking-wider text-slate-400">Projects</div>
                            <div class="mt-1 text-2xl font-bold text-slate-900">{{ $projects->count() }}</div>
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-slate-50/60 p-4">
                            <div class="text-xs font-semibold uppercase tracking-wider text-slate-400">Email</div>
                            <div class="mt-1 truncate text-sm font-semibold text-slate-900">
                                {{ $client->company ?? '—' }}
                            </div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50/60 p-4">
                            <div class="text-xs font-semibold uppercase tracking-wider text-slate-400">Email</div>
                            <div class="mt-1 truncate text-sm font-semibold text-slate-900">
                                {{ $client->email ?? '—' }}
                            </div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50/60 p-4">
                            <div class="text-xs font-semibold uppercase tracking-wider text-slate-400">Phone</div>
                            <div class="mt-1 truncate text-sm font-semibold text-slate-900">
                                {{ $client->phone ?? '—' }}
                            </div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50/60 p-4">
                            <div class="text-xs font-semibold uppercase tracking-wider text-slate-400">Address</div>
                            <div class="mt-1 truncate text-sm font-semibold text-slate-900">
                                {{ $client->address ?? '—' }}
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            {{-- Main grid --}}
            <div class="grid gap-5 lg:grid-cols-8">


                {{-- Right: projects --}}
                <div class="lg:col-span-3 space-y-4">
                    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                        <div class="border-b border-slate-100 bg-slate-50/60 px-5 py-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h2 class="text-sm font-semibold text-slate-900">Projects</h2>
                                    <p class="mt-1 text-xs text-slate-500">Projects linked to this client.</p>
                                </div>

                                <span
                                    class="inline-flex items-center rounded-full bg-white px-3 py-1 text-xs font-semibold text-slate-600 ring-1 ring-slate-200">
                                    {{ $projects->count() }} total
                                </span>
                            </div>
                        </div>

                        <div class="p-5 sm:p-6">
                            @if ($projects->isEmpty())
                                <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-6 text-center">
                                    <div
                                        class="mx-auto grid h-12 w-12 place-items-center rounded-2xl bg-white ring-1 ring-slate-200">
                                        <i class="bi bi-folder2-open text-slate-500 text-xl"></i>
                                    </div>
                                    <div class="mt-3 text-sm font-semibold text-slate-900">No linked projects</div>
                                    <div class="mt-1 text-sm text-slate-500">This client doesn’t have any projects yet.
                                    </div>
                                </div>
                            @else
                                <div class="space-y-3">
                                    @foreach ($projects as $project)
                                        <div
                                            class="group flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:shadow-md sm:flex-row sm:items-center sm:justify-between">
                                            <div class="min-w-0">
                                                <div class="flex items-center gap-2">
                                                    <span
                                                        class="grid h-9 w-9 place-items-center rounded-xl bg-sky-50 text-sky-700 ring-1 ring-sky-100">
                                                        <i class="bi bi-folder"></i>
                                                    </span>
                                                    <div class="min-w-0">
                                                        <div class="truncate text-sm font-semibold text-slate-900">
                                                            {{ $project->name }}
                                                        </div>
                                                        <div class="mt-0.5 text-xs text-slate-500">
                                                            Status:
                                                            <span class="font-semibold text-slate-700">
                                                                {{ ucwords(str_replace('_', ' ', $project->status ?? '—')) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('projects.show', $project) }}"
                                                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 active:scale-[0.99]">
                                                    <i class="bi bi-eye"></i>
                                                    View
                                                </a>

                                                <a href="{{ route('projects.tasks.index', $project) }}"
                                                    class="inline-flex items-center gap-2 rounded-xl bg-sky-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700 active:scale-[0.99]">
                                                    <i class="bi bi-kanban"></i>
                                                    Board
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
