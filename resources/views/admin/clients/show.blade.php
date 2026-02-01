@extends('admin.layout.app')

@section('title', $client->name)

@section('admin-content')
    <div class="max-w-4xl space-y-4">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="text-xs font-semibold uppercase tracking-wide text-slate-400">Client</div>
                <h2 class="text-2xl font-semibold text-slate-800">{{ $client->name }}</h2>
                <p class="text-sm text-slate-500">Client profile and linked projects.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('clients.edit', $client) }}"
                    class="inline-flex items-center rounded-md border border-amber-400 bg-amber-50 px-3 py-2 text-sm text-amber-700 hover:bg-amber-100">
                    Edit
                </a>
                <a href="{{ route('clients.index') }}"
                    class="inline-flex items-center rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                    Back to Clients
                </a>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-4 py-3">
                <h3 class="text-sm font-semibold text-slate-700">Client Details</h3>
            </div>
            <div class="grid gap-4 p-4 text-sm text-slate-600 sm:grid-cols-2">
                <div>
                    <div class="text-xs uppercase text-slate-400">Email</div>
                    <div class="font-semibold text-slate-800">{{ $client->email ?? '—' }}</div>
                </div>
                <div>
                    <div class="text-xs uppercase text-slate-400">Phone</div>
                    <div class="font-semibold text-slate-800">{{ $client->phone ?? '—' }}</div>
                </div>
                <div>
                    <div class="text-xs uppercase text-slate-400">Company</div>
                    <div class="font-semibold text-slate-800">{{ $client->company ?? '—' }}</div>
                </div>
                <div>
                    <div class="text-xs uppercase text-slate-400">Address</div>
                    <div class="font-semibold text-slate-800">{{ $client->address ?? '—' }}</div>
                </div>
                <div class="sm:col-span-2">
                    <div class="text-xs uppercase text-slate-400">Notes</div>
                    <div class="mt-1 text-slate-700">{{ $client->note ?? '—' }}</div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-4 py-3">
                <h3 class="text-sm font-semibold text-slate-700">Projects</h3>
            </div>
            <div class="p-4">
                @if ($projects->isEmpty())
                    <p class="text-sm text-slate-500">No projects linked to this client.</p>
                @else
                    <ul class="space-y-2 text-sm">
                        @foreach ($projects as $project)
                            <li class="flex items-center justify-between rounded-md border border-slate-200 bg-slate-50 px-3 py-2">
                                <span class="font-semibold text-slate-800">{{ $project->name }}</span>
                                <a href="{{ route('projects.show', $project) }}"
                                    class="inline-flex items-center rounded-md border border-slate-300 bg-white px-2.5 py-1.5 text-xs text-slate-700 hover:bg-slate-100">
                                    View
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection
