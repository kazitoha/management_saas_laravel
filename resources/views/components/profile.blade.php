@props([
    'user',
    'stats' => [],
    'activity' => [],
    'passwordUpdateRoute' => null, // route name or URL
    'profileEditRoute' => null, // route name or URL
    'securityRoute' => null, // route name or URL
    'activityRoute' => null, // route name or URL
])

@php
    $passwordAction = $passwordUpdateRoute
        ? (str_starts_with($passwordUpdateRoute, 'http')
            ? $passwordUpdateRoute
            : route($passwordUpdateRoute))
        : '#';
    $editUrl = $profileEditRoute
        ? (str_starts_with($profileEditRoute, 'http')
            ? $profileEditRoute
            : route($profileEditRoute))
        : null;
    $securityUrl = $securityRoute
        ? (str_starts_with($securityRoute, 'http')
            ? $securityRoute
            : route($securityRoute))
        : null;
    $activityUrl = $activityRoute
        ? (str_starts_with($activityRoute, 'http')
            ? $activityRoute
            : route($activityRoute))
        : null;
@endphp

<div class="space-y-6">
    {{-- Header --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <div class="h-14 w-14 overflow-hidden rounded-2xl bg-slate-100">
                    @if ($user?->avatar)
                        <img src="{{ $user->avatar }}" alt="Avatar" class="h-full w-full object-cover">
                    @else
                        <div class="flex h-full w-full items-center justify-center text-lg font-bold text-slate-600">
                            {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div>
                    <div class="text-lg font-bold text-slate-900">{{ $user?->name ?? 'N/A' }}</div>
                    <div class="text-sm text-slate-500">{{ $user?->email ?? 'N/A' }}</div>
                    <div class="mt-1 flex flex-wrap gap-2 text-xs text-slate-500">
                        <span class="rounded-full bg-slate-100 px-2 py-1">
                            {{ $user?->company?->name ?? 'No Company' }}
                        </span>
                        <span class="rounded-full bg-slate-100 px-2 py-1">
                            {{ $user?->roles?->first()?->name ?? 'No Role' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                @foreach ($stats as $s)
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-center">
                        <div class="text-xs font-semibold text-slate-400">{{ $s['label'] ?? '' }}</div>
                        <div class="mt-1 text-lg font-bold text-slate-900">{{ $s['value'] ?? 0 }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        {{-- Left --}}
        <div class="space-y-6 xl:col-span-2">
            {{-- Personal Information --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm font-bold text-slate-900">Personal Information</div>
                        <div class="text-xs text-slate-500">Manage your basic details</div>
                    </div>

                    @if ($editUrl)
                        <a href="{{ $editUrl }}"
                            class="rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            Edit
                        </a>
                    @endif
                </div>

                <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <div class="text-xs font-semibold text-slate-400">Full Name</div>
                        <div class="mt-1 text-sm font-semibold text-slate-900">{{ $user?->name ?? 'N/A' }}</div>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <div class="text-xs font-semibold text-slate-400">Email Address</div>
                        <div class="mt-1 text-sm font-semibold text-slate-900">{{ $user?->email ?? 'N/A' }}</div>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <div class="text-xs font-semibold text-slate-400">Company</div>
                        <div class="mt-1 text-sm font-semibold text-slate-900">{{ $user?->company?->name ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <div class="text-xs font-semibold text-slate-400">Role</div>
                        <div class="mt-1 text-sm font-semibold text-slate-900">
                            {{ $user?->roles?->first()?->name ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>

            {{-- Change Password --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div>
                    <div class="text-sm font-bold text-slate-900">Change Password</div>
                    <div class="text-xs text-slate-500">Use a strong password to keep your account secure.</div>
                </div>

                @if ($errors->any())
                    <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('status'))
                    <div
                        class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ $passwordAction }}" class="mt-5 space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="mb-1 block text-xs font-semibold text-slate-600">Current Password</label>
                        <input type="password" name="current_password" autocomplete="current-password"
                            class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm outline-none focus:border-slate-300 focus:ring-2 focus:ring-slate-200"
                            placeholder="Enter current password">
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-xs font-semibold text-slate-600">New Password</label>
                            <input type="password" name="password" autocomplete="new-password"
                                class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm outline-none focus:border-slate-300 focus:ring-2 focus:ring-slate-200"
                                placeholder="Enter new password">
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold text-slate-600">Confirm Password</label>
                            <input type="password" name="password_confirmation" autocomplete="new-password"
                                class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm outline-none focus:border-slate-300 focus:ring-2 focus:ring-slate-200"
                                placeholder="Confirm new password">
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 sm:w-auto">
                        Update Password
                    </button>
                </form>
            </div>
        </div>

        {{-- Right --}}
        <div class="space-y-6">
            {{-- Security --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="text-sm font-bold text-slate-900">Security</div>
                <div class="mt-2 text-sm text-slate-500">Quick overview of your account security.</div>

                <div class="mt-4 space-y-3">
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <div class="text-xs font-semibold text-slate-400">Two-Factor</div>
                        <div class="mt-1 text-sm font-semibold text-slate-900">Not enabled</div>
                    </div>
                </div>

                @if ($securityUrl)
                    <a href="{{ $securityUrl }}"
                        class="mt-4 block w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Security Settings
                    </a>
                @endif
            </div>

            {{-- Recent Activity --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="text-sm font-bold text-slate-900">Recent Activity</div>
                    @if ($activityUrl)
                        <a href="{{ $activityUrl }}"
                            class="text-xs font-semibold text-slate-600 hover:text-slate-900">
                            View all
                        </a>
                    @endif
                </div>

                <div class="mt-4 space-y-3 text-sm text-slate-600">
                    @forelse($activity as $item)
                        <div
                            class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                            <span class="font-medium text-slate-800">{{ $item['label'] ?? '' }}</span>
                            <span class="text-xs text-slate-500">{{ $item['time'] ?? '' }}</span>
                        </div>
                    @empty
                        <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500">
                            No recent activity.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
