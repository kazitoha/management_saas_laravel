@extends('admin.layout.app')

@section('title', 'Clients')

@section('admin-content')
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 space-y-6">

        {{-- Header --}}
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="bg-gradient-to-b from-slate-50 to-white p-5 sm:p-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div class="space-y-1">
                        <div class="text-xs font-semibold uppercase tracking-wider text-slate-400">Clients</div>
                        <h1 class="text-2xl sm:text-3xl font-semibold text-slate-900 leading-tight">Client Directory</h1>
                        <p class="text-sm text-slate-500">Manage your clients and access their details quickly.</p>
                    </div>

                    <a href="{{ route('clients.create') }}"
                        class="inline-flex items-center gap-2 rounded-2xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm
                          hover:bg-sky-700 active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-sky-500/30">
                        <i class="bi bi-person-plus text-base"></i>
                        Add Client
                    </a>
                </div>
            </div>


        </div>

        {{-- Table card --}}
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            {{-- Toolbar --}}
            <div class="border-b border-slate-100 bg-white px-5 py-4">
                <form method="GET" action="{{ route('clients.index') }}"
                    class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="relative w-full sm:max-w-md">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                            <i class="bi bi-search"></i>
                        </span>

                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="Search by name, email, company..."
                            class="w-full rounded-2xl border border-slate-200 bg-white pl-10 pr-3 py-2.5 text-sm text-slate-900 shadow-sm
                                  focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20">
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm
                                   hover:bg-slate-800 active:scale-[0.99]">
                            <i class="bi bi-funnel"></i>
                            Search
                        </button>

                        @if (request('q'))
                            <a href="{{ route('clients.index') }}"
                                class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm
                                  hover:bg-slate-50">
                                <i class="bi bi-x-circle"></i>
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead
                        class="sticky top-0 z-10 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-5 py-3">Client</th>
                            <th class="px-5 py-3">Company</th>
                            <th class="px-5 py-3">Email</th>
                            <th class="px-5 py-3">Phone</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($clients as $client)
                            @php
                                $initial = \Illuminate\Support\Str::of($client->name ?? 'C')
                                    ->substr(0, 1)
                                    ->upper();
                            @endphp

                            <tr class="group hover:bg-slate-50/70">
                                {{-- Client --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="h-10 w-10 rounded-2xl bg-sky-50 text-sky-700 ring-1 ring-sky-100 flex items-center justify-center font-bold">
                                            {{ $initial }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="truncate font-semibold text-slate-900">{{ $client->name }}</div>
                                            <div class="truncate text-xs text-slate-500">
                                                ID: {{ $client->id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Company --}}
                                <td class="px-5 py-4">
                                    <span class="text-slate-700">{{ $client->company ?? '—' }}</span>
                                </td>

                                {{-- Email --}}
                                <td class="px-5 py-4">
                                    @if ($client->email)
                                        <a href="mailto:{{ $client->email }}"
                                            class="text-slate-700 hover:text-sky-700 hover:underline">
                                            {{ $client->email }}
                                        </a>
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </td>

                                {{-- Phone --}}
                                <td class="px-5 py-4">
                                    <span class="text-slate-700">{{ $client->phone ?? '—' }}</span>
                                </td>

                                {{-- Actions --}}
                                <td class="px-5 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('clients.show', $client) }}"
                                            class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 shadow-sm
                                              hover:bg-slate-50">
                                            <i class="bi bi-eye"></i>
                                            View
                                        </a>

                                        <a href="{{ route('clients.edit', $client) }}"
                                            class="inline-flex items-center gap-2 rounded-xl border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-800 shadow-sm
                                              hover:bg-amber-100">
                                            <i class="bi bi-pencil"></i>
                                            Edit
                                        </a>

                                        <form action="{{ route('clients.destroy', $client) }}" method="POST"
                                            onsubmit="return confirm('Delete this client?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-2 rounded-xl border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-700 shadow-sm
                                                       hover:bg-rose-100">
                                                <i class="bi bi-trash"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-12 text-center">
                                    <div class="mx-auto max-w-md space-y-2">
                                        <div
                                            class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-500">
                                            <i class="bi bi-people text-xl"></i>
                                        </div>
                                        <div class="text-sm font-semibold text-slate-900">No clients found</div>
                                        <div class="text-sm text-slate-500">
                                            Try adjusting your search or add a new client.
                                        </div>
                                        <div class="pt-2">
                                            <a href="{{ route('clients.create') }}"
                                                class="inline-flex items-center gap-2 rounded-2xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-sky-700">
                                                <i class="bi bi-person-plus"></i>
                                                Add Client
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="border-t border-slate-100 bg-white px-5 py-4">
                {{ $clients->links() }}
            </div>
        </div>
    </div>
@endsection
