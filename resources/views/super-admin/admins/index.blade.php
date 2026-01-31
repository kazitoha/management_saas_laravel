@extends('super-admin.layout.app')

@section('admin-content')
    <div class="space-y-6">

        {{-- Header --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-xl font-bold text-slate-900">Admins</h1>
                    <p class="mt-1 text-sm text-slate-500">Create and manage admin accounts.</p>
                </div>

                {{-- Quick stats (optional) --}}
                <div class="flex flex-wrap gap-2">
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2">
                        <div class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Total</div>
                        <div class="text-sm font-bold text-slate-900">{{ $admins->count() }}</div>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2">
                        <div class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Active</div>
                        <div class="text-sm font-bold text-slate-900">{{ $admins->where('status', 'active')->count() }}
                        </div>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2">
                        <div class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Pending</div>
                        <div class="text-sm font-bold text-slate-900">{{ $admins->where('status', 'pending')->count() }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Alerts --}}
            @if (session('success'))
                <div class="mt-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                    {{ $errors->first() }}
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            {{-- Add admin --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-1">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm font-bold text-slate-900">Add admin</div>
                        <div class="mt-1 text-xs text-slate-500">Fill in details to create a new admin.</div>
                    </div>
                </div>

                <form class="mt-5 space-y-5" method="POST" action="{{ route('superadmin.admins.store') }}">
                    @csrf

                    {{-- Company section --}}
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="text-xs font-bold uppercase tracking-wide text-slate-600">Company</div>

                        <div class="mt-4 space-y-4">
                            <div>
                                <label class="text-sm font-semibold text-slate-700">Company name</label>
                                <input type="text" name="company_name" value="{{ old('company_name') }}"
                                    class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 outline-none ring-blue-200 focus:border-blue-300 focus:ring-4"
                                    placeholder="e.g. Acme Ltd" required />
                            </div>

                            <div>
                                <label class="text-sm font-semibold text-slate-700">Company status</label>
                                <select name="company_status"
                                    class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none ring-blue-200 focus:border-blue-300 focus:ring-4"
                                    required>
                                    <option value="active" @selected(old('company_status') === 'active')>Active</option>
                                    <option value="inactive" @selected(old('company_status') === 'inactive')>Inactive</option>
                                    <option value="pending" @selected(old('company_status', 'pending') === 'pending')>Pending</option>
                                    <option value="demo" @selected(old('company_status') === 'demo')>Demo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Admin section --}}
                    <div class="rounded-2xl border border-slate-200 bg-white p-4">
                        <div class="text-xs font-bold uppercase tracking-wide text-slate-600">Admin</div>

                        <div class="mt-4 space-y-4">
                            <div>
                                <label class="text-sm font-semibold text-slate-700">Admin name</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 outline-none ring-blue-200 focus:border-blue-300 focus:ring-4"
                                    placeholder="Full name" required />
                            </div>

                            <div>
                                <label class="text-sm font-semibold text-slate-700">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 outline-none ring-blue-200 focus:border-blue-300 focus:ring-4"
                                    placeholder="name@company.com" required />
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Password</label>
                                    <input type="password" name="password"
                                        class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 outline-none ring-blue-200 focus:border-blue-300 focus:ring-4"
                                        required />
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Confirm password</label>
                                    <input type="password" name="password_confirmation"
                                        class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 outline-none ring-blue-200 focus:border-blue-300 focus:ring-4"
                                        required />
                                </div>
                            </div>

                            <div>
                                <label class="text-sm font-semibold text-slate-700">Admin status</label>
                                <select name="status"
                                    class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 outline-none ring-blue-200 focus:border-blue-300 focus:ring-4"
                                    required>
                                    <option value="active" @selected(old('status') === 'active')>Active</option>
                                    <option value="inactive" @selected(old('status') === 'inactive')>Inactive</option>
                                    <option value="pending" @selected(old('status', 'pending') === 'pending')>Pending</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-300">
                        Create admin
                    </button>

                    <p class="text-xs text-slate-500">
                        Tip: Use <span class="font-semibold text-slate-700">Pending</span> if the admin should verify later.
                    </p>
                </form>
            </div>

            {{-- Admin list --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <div class="text-sm font-bold text-slate-900">Admin list</div>
                        <div class="mt-1 text-xs text-slate-500">Manage admins and access levels.</div>
                    </div>

                    {{-- Optional: quick filter placeholder --}}
                    <div class="flex items-center gap-2">
                        <div class="hidden sm:block text-xs text-slate-500">Actions are on the right</div>
                    </div>
                </div>

                <div class="mt-5 overflow-hidden rounded-2xl border border-slate-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="sticky top-0 bg-white">
                                <tr class="text-left text-xs uppercase tracking-wide text-slate-400">
                                    <th class="px-4 py-3">Company</th>
                                    <th class="px-4 py-3">Company status</th>
                                    <th class="px-4 py-3">Admin</th>
                                    <th class="px-4 py-3">Email</th>
                                    <th class="px-4 py-3">Admin status</th>
                                    <th class="px-4 py-3">Created</th>
                                    <th class="px-4 py-3 text-right">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @forelse ($admins as $admin)
                                    @php
                                        $companyStatus = $admin->company?->status ?? null;
                                        $adminStatus = $admin->status;
                                        $pill = fn($status) => match ($status) {
                                            'active' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'inactive' => 'bg-slate-100 text-slate-700 border-slate-200',
                                            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'demo' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                            default => 'bg-slate-100 text-slate-600 border-slate-200',
                                        };
                                    @endphp

                                    <tr class="bg-white hover:bg-slate-50">
                                        <td class="px-4 py-4">
                                            <div class="font-semibold text-slate-900">
                                                {{ $admin->company?->name ?? '—' }}
                                            </div>
                                        </td>

                                        <td class="px-4 py-4">
                                            <span
                                                class="inline-flex items-center rounded-full border px-2.5 py-1 text-xs font-semibold capitalize {{ $pill($companyStatus) }}">
                                                {{ $companyStatus ?? '—' }}
                                            </span>
                                        </td>

                                        <td class="px-4 py-4">
                                            <div class="font-semibold text-slate-900">{{ $admin->name }}</div>
                                        </td>

                                        <td class="px-4 py-4 text-slate-700">
                                            {{ $admin->email }}
                                        </td>

                                        <td class="px-4 py-4">
                                            <span
                                                class="inline-flex items-center rounded-full border px-2.5 py-1 text-xs font-semibold capitalize {{ $pill($adminStatus) }}">
                                                {{ $adminStatus }}
                                            </span>
                                        </td>

                                        <td class="px-4 py-4 text-xs text-slate-500">
                                            {{ $admin->created_at?->format('M j, Y') }}
                                        </td>

                                        <td class="px-4 py-4">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('superadmin.admins.edit', $admin) }}"
                                                    class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                                    Edit
                                                </a>

                                                <form method="POST"
                                                    action="{{ route('superadmin.admins.status', $admin) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status"
                                                        value="{{ $admin->status === 'active' ? 'inactive' : 'active' }}" />
                                                    <button type="submit"
                                                        class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                                        {{ $admin->status === 'active' ? 'Deactivate' : 'Activate' }}
                                                    </button>
                                                </form>

                                                <form method="POST"
                                                    action="{{ route('superadmin.admins.destroy', $admin) }}"
                                                    onsubmit="return confirm('Delete this admin?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-100">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12">
                                            <div class="flex flex-col items-center justify-center text-center">
                                                <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                                    <div class="text-sm font-semibold text-slate-900">No admins yet</div>
                                                    <div class="mt-1 text-xs text-slate-500">Create your first admin using
                                                        the form.</div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Optional footer note --}}
                <div class="mt-4 text-xs text-slate-500">
                    Showing <span class="font-semibold text-slate-700">{{ $admins->count() }}</span> admins.
                </div>
            </div>

        </div>
    </div>
@endsection
