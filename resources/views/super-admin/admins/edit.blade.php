@extends('super-admin.layout.app')

@section('admin-content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <div class="text-lg font-bold">Edit admin</div>
                    <div class="text-sm text-slate-500">Update company and admin information.</div>
                </div>
                <a href="{{ route('superadmin.admins.index') }}"
                    class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                    Back
                </a>
            </div>

            @if ($errors->any())
                <div class="mt-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    {{ $errors->first() }}
                </div>
            @endif
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <form class="space-y-4" method="POST" action="{{ route('superadmin.admins.update', $admin) }}">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-sm font-semibold text-slate-700">Company name</label>
                    <input type="text" name="company_name" value="{{ old('company_name', $admin->company?->name) }}"
                        class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm outline-none ring-blue-200 focus:border-blue-300 focus:ring-4"
                        required />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Company status</label>
                    <select name="company_status"
                        class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm outline-none ring-blue-200 focus:border-blue-300 focus:ring-4"
                        required>
                        <option value="active" @selected(old('company_status', $admin->company?->status) === 'active')>Active</option>
                        <option value="inactive" @selected(old('company_status', $admin->company?->status) === 'inactive')>Inactive</option>
                        <option value="pending" @selected(old('company_status', $admin->company?->status) === 'pending')>Pending</option>
                        <option value="demo" @selected(old('company_status', $admin->company?->status) === 'demo')>Demo</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700">Admin name</label>
                    <input type="text" name="name" value="{{ old('name', $admin->name) }}"
                        class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm outline-none ring-blue-200 focus:border-blue-300 focus:ring-4"
                        required />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $admin->email) }}"
                        class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm outline-none ring-blue-200 focus:border-blue-300 focus:ring-4"
                        required />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Admin status</label>
                    <select name="status"
                        class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm outline-none ring-blue-200 focus:border-blue-300 focus:ring-4"
                        required>
                        <option value="active" @selected(old('status', $admin->status) === 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $admin->status) === 'inactive')>Inactive</option>
                        <option value="pending" @selected(old('status', $admin->status) === 'pending')>Pending</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">New password</label>
                    <input type="password" name="password"
                        class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm outline-none ring-blue-200 focus:border-blue-300 focus:ring-4" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Confirm password</label>
                    <input type="password" name="password_confirmation"
                        class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm outline-none ring-blue-200 focus:border-blue-300 focus:ring-4" />
                </div>

                <div class="flex justify-end gap-2">
                    <button type="submit"
                        class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                        Save changes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
