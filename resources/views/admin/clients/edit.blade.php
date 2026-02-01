@extends('admin.layout.app')

@section('title', 'Edit Client')

@section('admin-content')
    <div class="mx-auto max-w-3xl px-4 py-6 sm:px-6 lg:px-8 space-y-6">

        {{-- Page header --}}
        <div class="flex flex-col gap-2">
            <div class="text-xs font-semibold uppercase tracking-wider text-slate-400">Clients</div>
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <h1 class="truncate text-2xl font-semibold text-slate-900">Edit Client</h1>
                    <p class="mt-1 text-sm text-slate-500">Update client details and keep your records organized.</p>
                </div>

                <a href="{{ route('clients.index') }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50">
                    <i class="bi bi-arrow-left"></i>
                    Back
                </a>
            </div>
        </div>

        {{-- Card --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            {{-- Card header --}}
            <div class="border-b border-slate-100 bg-slate-50/60 px-5 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-semibold text-slate-900">Client Information</h2>
                        <p class="mt-1 text-xs text-slate-500">Fields marked with <span class="text-rose-600">*</span> are
                            required.</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('clients.update', $client) }}" method="POST" class="p-5 sm:p-6 space-y-5">
                @csrf
                @method('PUT')

                {{-- Top validation errors --}}
                @if ($errors->any())
                    <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-rose-800">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 text-rose-600">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-semibold">Please fix the following:</div>
                                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Name --}}
                <div>
                    <label for="name" class="mb-1 block text-sm font-medium text-slate-700">
                        Name <span class="text-rose-600">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $client->name) }}" required
                        class="w-full rounded-xl border bg-white px-3 py-2 text-sm shadow-sm focus:ring-2
                              @error('name')
                                  border-rose-300 focus:border-rose-500 focus:ring-rose-500/20
                              @else
                                  border-slate-200 focus:border-sky-500 focus:ring-sky-500/20
                              @enderror">
                    @error('name')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email + Phone --}}
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $client->email) }}"
                            class="w-full rounded-xl border bg-white px-3 py-2 text-sm shadow-sm focus:ring-2
                                  @error('email')
                                      border-rose-300 focus:border-rose-500 focus:ring-rose-500/20
                                  @else
                                      border-slate-200 focus:border-sky-500 focus:ring-sky-500/20
                                  @enderror">
                        @error('email')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="mb-1 block text-sm font-medium text-slate-700">Phone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $client->phone) }}"
                            class="w-full rounded-xl border bg-white px-3 py-2 text-sm shadow-sm focus:ring-2
                                  @error('phone')
                                      border-rose-300 focus:border-rose-500 focus:ring-rose-500/20
                                  @else
                                      border-slate-200 focus:border-sky-500 focus:ring-sky-500/20
                                  @enderror">
                        @error('phone')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Company --}}
                <div>
                    <label for="company" class="mb-1 block text-sm font-medium text-slate-700">Company</label>
                    <input type="text" name="company" id="company" value="{{ old('company', $client->company) }}"
                        class="w-full rounded-xl border bg-white px-3 py-2 text-sm shadow-sm focus:ring-2
                              @error('company')
                                  border-rose-300 focus:border-rose-500 focus:ring-rose-500/20
                              @else
                                  border-slate-200 focus:border-sky-500 focus:ring-sky-500/20
                              @enderror">
                    @error('company')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Address --}}
                <div>
                    <label for="address" class="mb-1 block text-sm font-medium text-slate-700">Address</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $client->address) }}"
                        class="w-full rounded-xl border bg-white px-3 py-2 text-sm shadow-sm focus:ring-2
                              @error('address')
                                  border-rose-300 focus:border-rose-500 focus:ring-rose-500/20
                              @else
                                  border-slate-200 focus:border-sky-500 focus:ring-sky-500/20
                              @enderror">
                    @error('address')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Notes --}}
                <div>
                    <label for="note" class="mb-1 block text-sm font-medium text-slate-700">Notes</label>
                    <textarea name="note" id="note" rows="4"
                        class="w-full rounded-xl border bg-white px-3 py-2 text-sm shadow-sm focus:ring-2
                                 @error('note')
                                     border-rose-300 focus:border-rose-500 focus:ring-rose-500/20
                                 @else
                                     border-slate-200 focus:border-sky-500 focus:ring-sky-500/20
                                 @enderror">{{ old('note', $client->note) }}</textarea>
                    @error('note')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Footer --}}
                <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end sm:gap-3 border-t border-slate-100 pt-4">
                    <a href="{{ route('clients.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50">
                        Cancel
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700 active:scale-[0.99]">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
