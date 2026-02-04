@extends('admin.layout.app')

@section('title', 'Edit Client')

@section('admin-content')
    <div class="min-h-[calc(100vh-4rem)] bg-gradient-to-br from-slate-50 via-white to-slate-100 py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Header --}}
            <div class="flex flex-col gap-3">
                <div class="flex items-center justify-between gap-4">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-sky-600"></span>
                            <div class="text-xs font-semibold uppercase tracking-wider text-slate-400">Clients</div>
                        </div>

                        <h1 class="mt-1 truncate text-3xl font-bold text-slate-900">Edit Client</h1>
                        <p class="mt-1 text-sm text-slate-600">
                            Update client details and keep your records organized.
                        </p>

                        {{-- Small meta row --}}
                        <div class="mt-3 flex flex-wrap items-center gap-2 text-xs text-slate-500">
                            <span
                                class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 ring-1 ring-slate-200">
                                <i class="bi bi-person text-slate-500"></i>
                                <span class="font-semibold text-slate-700">{{ $client->name }}</span>
                            </span>

                            @if (!empty($client->email))
                                <span
                                    class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 ring-1 ring-slate-200">
                                    <i class="bi bi-envelope text-slate-500"></i>
                                    <span class="truncate max-w-[220px]">{{ $client->email }}</span>
                                </span>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('clients.index') }}"
                        class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 active:scale-[0.99]">
                        <i class="bi bi-arrow-left"></i>
                        Back
                    </a>
                </div>

                <div class="text-xs text-slate-500">
                    Fields marked with <span class="font-semibold text-rose-600">*</span> are required.
                </div>
            </div>

            {{-- Card --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-lg">
                {{-- Accent bar --}}
                <div class="h-1 bg-gradient-to-r from-sky-600 to-sky-700"></div>

                <div class="p-6 sm:p-8">
                    {{-- Form header --}}
                    <div class="mb-6 flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-base font-semibold text-slate-900">Client Information</h2>
                            <p class="mt-1 text-sm text-slate-500">Make changes and click “Save Changes”.</p>
                        </div>

                        <span
                            class="hidden sm:inline-flex items-center gap-2 rounded-full bg-slate-50 px-3 py-1 text-xs font-semibold text-slate-600 ring-1 ring-slate-200">
                            <i class="bi bi-pencil-square text-slate-500"></i>
                            Editing
                        </span>
                    </div>

                    {{-- Validation summary --}}
                    @if ($errors->any())
                        <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-rose-900">
                            <div class="flex items-start gap-3">
                                <div
                                    class="mt-0.5 grid h-9 w-9 place-items-center rounded-xl bg-white ring-1 ring-rose-200">
                                    <i class="bi bi-exclamation-triangle text-rose-600"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-semibold">Please fix the following:</div>
                                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-rose-800">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('clients.update', $client) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Section --}}
                        <div class="flex items-center gap-2">
                            <span class="h-4 w-1 rounded-full bg-sky-600"></span>
                            <h3 class="text-sm font-semibold text-slate-900">Basic Details</h3>
                        </div>

                        {{-- Name --}}
                        <div>
                            <label for="name" class="mb-2 block text-sm font-semibold text-slate-800">
                                Name <span class="text-rose-600">*</span>
                            </label>
                            <div class="relative">
                                <span
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" name="name" id="name" value="{{ old('name', $client->name) }}"
                                    required placeholder="Client full name"
                                    class="w-full rounded-xl border bg-white pl-10 pr-3 py-2.5 text-sm text-slate-900 shadow-sm transition
                                    placeholder:text-slate-400 focus:outline-none focus:ring-2
                                    @error('name')
                                        border-rose-300 focus:border-rose-500 focus:ring-rose-500/20
                                    @else
                                        border-slate-200 focus:border-sky-500 focus:ring-sky-500/20
                                    @enderror">
                            </div>
                            @error('name')
                                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email + Phone --}}
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="email" class="mb-2 block text-sm font-semibold text-slate-800">Email</label>
                                <div class="relative">
                                    <span
                                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email', $client->email) }}" placeholder="name@email.com"
                                        class="w-full rounded-xl border bg-white pl-10 pr-3 py-2.5 text-sm text-slate-900 shadow-sm transition
                                        placeholder:text-slate-400 focus:outline-none focus:ring-2
                                        @error('email')
                                            border-rose-300 focus:border-rose-500 focus:ring-rose-500/20
                                        @else
                                            border-slate-200 focus:border-sky-500 focus:ring-sky-500/20
                                        @enderror">
                                </div>
                                @error('email')
                                    <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="mb-2 block text-sm font-semibold text-slate-800">Phone</label>
                                <div class="relative">
                                    <span
                                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <i class="bi bi-telephone"></i>
                                    </span>
                                    <input type="text" name="phone" id="phone"
                                        value="{{ old('phone', $client->phone) }}" placeholder="+880 1xxx-xxxxxx"
                                        class="w-full rounded-xl border bg-white pl-10 pr-3 py-2.5 text-sm text-slate-900 shadow-sm transition
                                        placeholder:text-slate-400 focus:outline-none focus:ring-2
                                        @error('phone')
                                            border-rose-300 focus:border-rose-500 focus:ring-rose-500/20
                                        @else
                                            border-slate-200 focus:border-sky-500 focus:ring-sky-500/20
                                        @enderror">
                                </div>
                                @error('phone')
                                    <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Company --}}
                        <div>
                            <label for="company" class="mb-2 block text-sm font-semibold text-slate-800">Company</label>
                            <div class="relative">
                                <span
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <i class="bi bi-building"></i>
                                </span>
                                <input type="text" name="company" id="company"
                                    value="{{ old('company', $client->company) }}" placeholder="Company or organization"
                                    class="w-full rounded-xl border bg-white pl-10 pr-3 py-2.5 text-sm text-slate-900 shadow-sm transition
                                    placeholder:text-slate-400 focus:outline-none focus:ring-2
                                    @error('company')
                                        border-rose-300 focus:border-rose-500 focus:ring-rose-500/20
                                    @else
                                        border-slate-200 focus:border-sky-500 focus:ring-sky-500/20
                                    @enderror">
                            </div>
                            @error('company')
                                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Address --}}
                        <div>
                            <label for="address" class="mb-2 block text-sm font-semibold text-slate-800">Address</label>
                            <div class="relative">
                                <span
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <i class="bi bi-geo-alt"></i>
                                </span>
                                <input type="text" name="address" id="address"
                                    value="{{ old('address', $client->address) }}" placeholder="Street, city, country"
                                    class="w-full rounded-xl border bg-white pl-10 pr-3 py-2.5 text-sm text-slate-900 shadow-sm transition
                                    placeholder:text-slate-400 focus:outline-none focus:ring-2
                                    @error('address')
                                        border-rose-300 focus:border-rose-500 focus:ring-rose-500/20
                                    @else
                                        border-slate-200 focus:border-sky-500 focus:ring-sky-500/20
                                    @enderror">
                            </div>
                            @error('address')
                                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Notes --}}
                        <div>
                            <label for="note" class="mb-2 block text-sm font-semibold text-slate-800">Notes</label>
                            <textarea name="note" id="note" rows="4"
                                placeholder="Any notes about this client (billing, preferences, etc.)"
                                class="w-full rounded-xl border bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm transition
                                placeholder:text-slate-400 focus:outline-none focus:ring-2
                                @error('note')
                                    border-rose-300 focus:border-rose-500 focus:ring-rose-500/20
                                @else
                                    border-slate-200 focus:border-sky-500 focus:ring-sky-500/20
                                @enderror">{{ old('note', $client->note) }}</textarea>
                            @error('note')
                                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Footer --}}
                        <div
                            class="flex flex-col-reverse gap-2 sm:flex-row sm:items-center sm:justify-end sm:gap-3 border-t border-slate-200 pt-5">
                            <a href="{{ route('clients.index') }}"
                                class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 active:scale-[0.99]">
                                Cancel
                            </a>

                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-sky-600 to-sky-700 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:from-sky-700 hover:to-sky-800 active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2">
                                <i class="bi bi-check2-circle mr-2"></i>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
