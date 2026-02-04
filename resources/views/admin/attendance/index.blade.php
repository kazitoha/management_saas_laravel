@extends('layouts.app')

@section('title', 'Attendance')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        {{-- Page header --}}
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3 bg-white mb-4 shadow-sm p-4 rounded-lg border border-slate-200">
            <div class="flex items-center gap-2">
                <i class="bi bi-geo-alt-fill text-sky-600 text-xl"></i>
                <h2 class="m-0 text-lg font-semibold text-slate-800">Attendance</h2>
            </div>
        </div>

        {{-- Main grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            {{-- Left: Today status / actions --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 h-full">
                    <div class="p-4">
                        <h5 class="text-base font-semibold text-slate-800 mb-3">Today's Status</h5>

                        @if ($todayRecord)
                            <p class="mb-1 text-sm">
                                <span class="font-semibold text-slate-700">Check-in:</span>
                                {{ $todayRecord->check_in_at->format('H:i') }}
                            </p>
                            @if ($todayRecord->check_out_at)
                                <p class="mb-1 text-sm">
                                    <span class="font-semibold text-slate-700">Check-out:</span>
                                    {{ $todayRecord->check_out_at->format('H:i') }}
                                </p>
                                <p class="mb-0 text-sm">
                                    <span class="font-semibold text-slate-700">Duration:</span>
                                    {{ $todayRecord->duration_human }}
                                </p>
                            @else
                                <p
                                    class="mt-1 text-xs text-amber-700 bg-amber-50 border border-amber-200 rounded px-3 py-2">
                                    Active session (not checked out)
                                </p>
                            @endif
                        @else
                            <p class="text-sm text-slate-500">No attendance yet today.</p>
                        @endif

                        <div class="my-3 border-t border-slate-200"></div>

                        @if ($todayRecord && $todayRecord->check_out_at)
                            <div
                                class="text-xs flex items-start gap-2 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded px-3 py-2">
                                <i class="bi bi-check2-circle mt-[1px]"></i>
                                <span>You have completed attendance for today.</span>
                            </div>
                        @else
                            @if (($todayRecord->late_minutes ?? 0) > 0)
                                <div
                                    class="mb-2 text-xs flex items-start gap-2 bg-amber-50 text-amber-800 border border-amber-200 rounded px-3 py-2">
                                    <i class="bi bi-exclamation-triangle-fill mt-[1px]"></i>
                                    <span>
                                        You checked in late by
                                        <span class="font-semibold">{{ $todayRecord->late_minutes }}</span>
                                        minute(s).
                                    </span>
                                </div>
                            @endif

                            {{-- Location status --}}
                            <div id="locStatus"
                                class="text-xs flex items-center gap-1 bg-amber-50 text-amber-800 border border-amber-200 rounded px-3 py-2 mb-2"
                                role="status">
                                <i class="bi bi-geo-alt mr-1"></i>
                                <span>Detecting your location… Please allow location permission in your browser.</span>
                            </div>

                            {{-- Attendance form --}}
                            <form id="attendanceForm" method="POST"
                                action="{{ $todayRecord && !$todayRecord->check_out_at ? route('portal.attendance.checkout') : route('portal.attendance.checkin') }}">
                                @csrf
                                <input type="hidden" name="lat" id="lat">
                                <input type="hidden" name="lng" id="lng">
                                <input type="hidden" name="address" id="address">

                                <div class="mb-2">
                                    <input
                                        class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500"
                                        type="text" name="notes" placeholder="Notes (optional)">
                                </div>

                                <div class="flex flex-col sm:flex-row gap-2">
                                    <button type="button"
                                        class="inline-flex items-center justify-center rounded border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 w-full sm:w-auto"
                                        id="retryLoc">
                                        <i class="bi bi-arrow-repeat mr-1"></i>
                                        Retry
                                    </button>

                                    <button type="submit"
                                        class="inline-flex items-center justify-center rounded bg-sky-600 px-4 py-2 text-xs font-medium text-white hover:bg-sky-700 disabled:opacity-50 disabled:cursor-not-allowed w-full sm:w-auto"
                                        id="attendanceBtn" disabled>
                                        <i
                                            class="bi {{ $todayRecord && !$todayRecord->check_out_at ? 'bi-box-arrow-right' : 'bi-box-arrow-in-right' }} mr-1"></i>
                                        {{ $todayRecord && !$todayRecord->check_out_at ? 'Check Out' : 'Check In' }}
                                    </button>
                                </div>

                                <p class="mt-2 text-[11px] leading-snug text-slate-500">
                                    Location is required. If blocked, enable location permission in your browser settings
                                    and tap retry.<br>
                                    On iOS Safari: <span class="font-semibold">Settings → Safari → Location →
                                        Allow</span>.<br>
                                    On Android Chrome:
                                    <span class="font-semibold">App Info → Permissions → Location → Allow</span>.
                                </p>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right: Recent records --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 h-full">
                    <div class="p-4">
                        <h5 class="text-base font-semibold text-slate-800 mb-3">Recent Records</h5>

                        <div class="overflow-x-auto">
                            <table class="min-w-full border-collapse text-xs sm:text-sm">
                                <thead>
                                    <tr class="bg-slate-50 text-slate-700">
                                        <th class="border border-slate-200 px-3 py-2 text-left font-semibold">Date</th>
                                        <th class="border border-slate-200 px-3 py-2 text-left font-semibold">Check-in</th>
                                        <th class="border border-slate-200 px-3 py-2 text-left font-semibold">Check-out</th>
                                        <th class="border border-slate-200 px-3 py-2 text-left font-semibold">Duration</th>
                                        <th class="border border-slate-200 px-3 py-2 text-left font-semibold">Location</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recent as $rec)
                                        <tr class="odd:bg-white even:bg-slate-50">
                                            <td class="border border-slate-200 px-3 py-2 whitespace-nowrap">
                                                {{ $rec->check_in_at->format('Y-m-d') }}
                                            </td>
                                            <td class="border border-slate-200 px-3 py-2 whitespace-nowrap">
                                                {{ $rec->check_in_at->format('H:i') }}
                                            </td>
                                            <td class="border border-slate-200 px-3 py-2 whitespace-nowrap">
                                                {{ $rec->check_out_at?->format('H:i') ?? '—' }}
                                            </td>
                                            <td class="border border-slate-200 px-3 py-2 whitespace-nowrap">
                                                {{ $rec->duration_human ?? '—' }}
                                            </td>
                                            <td class="border border-slate-200 px-3 py-2">
                                                @if ($rec->check_in_lat && $rec->check_in_lng)
                                                    <a href="https://maps.google.com/?q={{ $rec->check_in_lat }},{{ $rec->check_in_lng }}"
                                                        target="_blank" class="text-sky-600 hover:underline">
                                                        Open map
                                                    </a>
                                                @else
                                                    <span class="text-slate-400">—</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5"
                                                class="border border-slate-200 px-3 py-6 text-center text-slate-400 text-sm">
                                                No records
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const latEl = document.getElementById('lat');
            const lngEl = document.getElementById('lng');
            const btn = document.getElementById('attendanceBtn');
            const statusEl = document.getElementById('locStatus');
            const retryBtn = document.getElementById('retryLoc');
            const addrEl = document.getElementById('address');

            function setStatus(text, variant) {
                if (!statusEl) return;

                const base =
                    'text-xs mb-2 rounded-md border px-3 py-2 flex items-center gap-1';

                let color = '';
                switch (variant) {
                    case 'success':
                        color = ' bg-emerald-50 text-emerald-800 border-emerald-200';
                        break;
                    case 'warning':
                        color = ' bg-amber-50 text-amber-800 border-amber-200';
                        break;
                    case 'danger':
                        color = ' bg-rose-50 text-rose-800 border-rose-200';
                        break;
                    case 'info':
                    default:
                        color = ' bg-slate-50 text-slate-800 border-slate-200';
                        break;
                }

                statusEl.textContent = '';
                statusEl.className = base + color;

                const i = document.createElement('i');
                i.className = 'bi bi-geo-alt mr-1';
                statusEl.appendChild(i);
                statusEl.appendChild(document.createTextNode(text));
            }

            function enableIfReady(msg, variant) {
                const good = latEl.value && lngEl.value;
                if (good) {
                    btn?.removeAttribute('disabled');
                    if (msg) setStatus(msg, variant || 'success');
                } else {
                    btn?.setAttribute('disabled', 'disabled');
                }
            }

            function setCoords(pos, sourceLabel) {
                const {
                    latitude,
                    longitude,
                    accuracy
                } = pos.coords || {};
                if (typeof latitude === 'number' && typeof longitude === 'number') {
                    latEl.value = latitude.toFixed(7);
                    lngEl.value = longitude.toFixed(7);
                    const acc = typeof accuracy === 'number' ? Math.round(accuracy) + 'm' : 'unknown';
                    const note = sourceLabel ? ` (${sourceLabel}, ±${acc})` : ` (±${acc})`;
                    if (addrEl) addrEl.value = `auto${note}`;
                    enableIfReady('Location acquired' + note + '. You can proceed.', 'success');
                    return true;
                }
                return false;
            }

            function permissionsHint(err) {
                if (!err) return 'Could not get location.';
                if (err.code === err.PERMISSION_DENIED)
                    return 'Location permission denied. Please allow access and tap retry.';
                if (err.code === err.POSITION_UNAVAILABLE)
                    return 'Position unavailable. Move to open sky or enable GPS, then retry.';
                if (err.code === err.TIMEOUT)
                    return 'Timed out trying to get location. Retrying…';
                return 'Could not get location. Please check location settings and retry.';
            }

            async function askLocation() {
                if (!navigator.geolocation) {
                    setStatus('Geolocation not supported by this browser.', 'danger');
                    return;
                }

                // Stage 0: quick permission probe
                try {
                    if (navigator.permissions && navigator.permissions.query) {
                        const p = await navigator.permissions.query({
                            name: 'geolocation'
                        });
                        if (p.state === 'denied') {
                            setStatus('Location permission is blocked. Enable it in browser settings and tap retry.',
                                'danger');
                            return;
                        }
                    }
                } catch (_) {}

                // Strategy 1: High-accuracy single fix
                setStatus('Getting precise location…', 'warning');
                const one = await new Promise((resolve) => {
                    let settled = false;
                    const t = setTimeout(() => {
                        if (!settled) resolve({
                            ok: false,
                            err: {
                                code: 3
                            }
                        });
                    }, 13000);
                    navigator.geolocation.getCurrentPosition(
                        (pos) => {
                            settled = true;
                            clearTimeout(t);
                            resolve({
                                ok: true,
                                pos,
                                label: 'high-accuracy'
                            });
                        },
                        (err) => {
                            settled = true;
                            clearTimeout(t);
                            resolve({
                                ok: false,
                                err
                            });
                        }, {
                            enableHighAccuracy: true,
                            timeout: 12000,
                            maximumAge: 0
                        }
                    );
                });
                if (one.ok && setCoords(one.pos, one.label)) return;
                if (one.err) setStatus(permissionsHint(one.err), 'warning');

                // Strategy 2: Watch for a better fix briefly
                setStatus('Searching for GPS fix…', 'warning');
                const two = await new Promise((resolve) => {
                    if (!navigator.geolocation.watchPosition) return resolve({
                        ok: false,
                        err: {
                            code: 2
                        }
                    });
                    let done = false;
                    let id = null;
                    const limit = setTimeout(() => {
                        if (!done) {
                            done = true;
                            if (id !== null) navigator.geolocation.clearWatch(id);
                            resolve({
                                ok: false,
                                err: {
                                    code: 3
                                }
                            });
                        }
                    }, 12000);
                    try {
                        id = navigator.geolocation.watchPosition((pos) => {
                            if (done) return;
                            done = true;
                            clearTimeout(limit);
                            if (id !== null) navigator.geolocation.clearWatch(id);
                            resolve({
                                ok: true,
                                pos,
                                label: 'watch'
                            });
                        }, (err) => {
                            if (done) return;
                            done = true;
                            clearTimeout(limit);
                            if (id !== null) navigator.geolocation.clearWatch(id);
                            resolve({
                                ok: false,
                                err
                            });
                        }, {
                            enableHighAccuracy: true,
                            maximumAge: 0
                        });
                    } catch (e) {
                        clearTimeout(limit);
                        resolve({
                            ok: false,
                            err: e
                        });
                    }
                });
                if (two.ok && setCoords(two.pos, two.label)) return;
                if (two.err) setStatus(permissionsHint(two.err), 'warning');

                // Strategy 3: Low-accuracy with cached last known
                setStatus('Using last known location…', 'info');
                const three = await new Promise((resolve) => {
                    navigator.geolocation.getCurrentPosition(
                        (pos) => resolve({
                            ok: true,
                            pos,
                            label: 'low-accuracy'
                        }),
                        (err) => resolve({
                            ok: false,
                            err
                        }), {
                            enableHighAccuracy: false,
                            timeout: 8000,
                            maximumAge: 300000
                        }
                    );
                });
                if (three.ok && setCoords(three.pos, three.label)) return;
                if (three.err) setStatus(permissionsHint(three.err), 'warning');

                // Strategy 4: Low-accuracy watch briefly
                setStatus('Trying approximate location…', 'info');
                const four = await new Promise((resolve) => {
                    if (!navigator.geolocation.watchPosition) return resolve({
                        ok: false,
                        err: {
                            code: 2
                        }
                    });
                    let done = false;
                    let id = null;
                    const limit = setTimeout(() => {
                        if (!done) {
                            done = true;
                            if (id !== null) navigator.geolocation.clearWatch(id);
                            resolve({
                                ok: false,
                                err: {
                                    code: 3
                                }
                            });
                        }
                    }, 10000);
                    try {
                        id = navigator.geolocation.watchPosition((pos) => {
                            if (done) return;
                            done = true;
                            clearTimeout(limit);
                            if (id !== null) navigator.geolocation.clearWatch(id);
                            resolve({
                                ok: true,
                                pos,
                                label: 'approximate'
                            });
                        }, (err) => {
                            if (done) return;
                            done = true;
                            clearTimeout(limit);
                            if (id !== null) navigator.geolocation.clearWatch(id);
                            resolve({
                                ok: false,
                                err
                            });
                        }, {
                            enableHighAccuracy: false,
                            maximumAge: 300000
                        });
                    } catch (e) {
                        clearTimeout(limit);
                        resolve({
                            ok: false,
                            err: e
                        });
                    }
                });
                if (four.ok && setCoords(four.pos, four.label)) return;

                setStatus('Could not determine your location. Please move to an open area or enable GPS and tap retry.',
                    'danger');
                enableIfReady();
            }

            retryBtn?.addEventListener('click', () => {
                latEl.value = '';
                lngEl.value = '';
                btn?.setAttribute('disabled', 'disabled');
                askLocation();
            });

            document.addEventListener('DOMContentLoaded', askLocation);

            document.getElementById('attendanceForm')?.addEventListener('submit', (e) => {
                if (!latEl.value || !lngEl.value) {
                    e.preventDefault();
                    setStatus('Location is required. Please enable location permission and tap retry.', 'danger');
                }
            });
        </script>
    @endpush
@endsection
@extends('layouts.app')

@section('title', 'Attendance')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        {{-- Page header --}}
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3 bg-white mb-4 shadow-sm p-4 rounded-lg border border-slate-200">
            <div class="flex items-center gap-2">
                <i class="bi bi-geo-alt-fill text-sky-600 text-xl"></i>
                <h2 class="m-0 text-lg font-semibold text-slate-800">Attendance</h2>
            </div>
        </div>

        {{-- Main grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            {{-- Left: Today status / actions --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 h-full">
                    <div class="p-4">
                        <h5 class="text-base font-semibold text-slate-800 mb-3">Today's Status</h5>

                        @if ($todayRecord)
                            <p class="mb-1 text-sm">
                                <span class="font-semibold text-slate-700">Check-in:</span>
                                {{ $todayRecord->check_in_at->format('H:i') }}
                            </p>
                            @if ($todayRecord->check_out_at)
                                <p class="mb-1 text-sm">
                                    <span class="font-semibold text-slate-700">Check-out:</span>
                                    {{ $todayRecord->check_out_at->format('H:i') }}
                                </p>
                                <p class="mb-0 text-sm">
                                    <span class="font-semibold text-slate-700">Duration:</span>
                                    {{ $todayRecord->duration_human }}
                                </p>
                            @else
                                <p
                                    class="mt-1 text-xs text-amber-700 bg-amber-50 border border-amber-200 rounded px-3 py-2">
                                    Active session (not checked out)
                                </p>
                            @endif
                        @else
                            <p class="text-sm text-slate-500">No attendance yet today.</p>
                        @endif

                        <div class="my-3 border-t border-slate-200"></div>

                        @if ($todayRecord && $todayRecord->check_out_at)
                            <div
                                class="text-xs flex items-start gap-2 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded px-3 py-2">
                                <i class="bi bi-check2-circle mt-[1px]"></i>
                                <span>You have completed attendance for today.</span>
                            </div>
                        @else
                            @if (($todayRecord->late_minutes ?? 0) > 0)
                                <div
                                    class="mb-2 text-xs flex items-start gap-2 bg-amber-50 text-amber-800 border border-amber-200 rounded px-3 py-2">
                                    <i class="bi bi-exclamation-triangle-fill mt-[1px]"></i>
                                    <span>
                                        You checked in late by
                                        <span class="font-semibold">{{ $todayRecord->late_minutes }}</span>
                                        minute(s).
                                    </span>
                                </div>
                            @endif

                            {{-- Location status --}}
                            <div id="locStatus"
                                class="text-xs flex items-center gap-1 bg-amber-50 text-amber-800 border border-amber-200 rounded px-3 py-2 mb-2"
                                role="status">
                                <i class="bi bi-geo-alt mr-1"></i>
                                <span>Detecting your location… Please allow location permission in your browser.</span>
                            </div>

                            {{-- Attendance form --}}
                            <form id="attendanceForm" method="POST"
                                action="{{ $todayRecord && !$todayRecord->check_out_at ? route('portal.attendance.checkout') : route('portal.attendance.checkin') }}">
                                @csrf
                                <input type="hidden" name="lat" id="lat">
                                <input type="hidden" name="lng" id="lng">
                                <input type="hidden" name="address" id="address">

                                <div class="mb-2">
                                    <input
                                        class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500"
                                        type="text" name="notes" placeholder="Notes (optional)">
                                </div>

                                <div class="flex flex-col sm:flex-row gap-2">
                                    <button type="button"
                                        class="inline-flex items-center justify-center rounded border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 w-full sm:w-auto"
                                        id="retryLoc">
                                        <i class="bi bi-arrow-repeat mr-1"></i>
                                        Retry
                                    </button>

                                    <button type="submit"
                                        class="inline-flex items-center justify-center rounded bg-sky-600 px-4 py-2 text-xs font-medium text-white hover:bg-sky-700 disabled:opacity-50 disabled:cursor-not-allowed w-full sm:w-auto"
                                        id="attendanceBtn" disabled>
                                        <i
                                            class="bi {{ $todayRecord && !$todayRecord->check_out_at ? 'bi-box-arrow-right' : 'bi-box-arrow-in-right' }} mr-1"></i>
                                        {{ $todayRecord && !$todayRecord->check_out_at ? 'Check Out' : 'Check In' }}
                                    </button>
                                </div>

                                <p class="mt-2 text-[11px] leading-snug text-slate-500">
                                    Location is required. If blocked, enable location permission in your browser settings
                                    and tap retry.<br>
                                    On iOS Safari: <span class="font-semibold">Settings → Safari → Location →
                                        Allow</span>.<br>
                                    On Android Chrome:
                                    <span class="font-semibold">App Info → Permissions → Location → Allow</span>.
                                </p>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right: Recent records --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 h-full">
                    <div class="p-4">
                        <h5 class="text-base font-semibold text-slate-800 mb-3">Recent Records</h5>

                        <div class="overflow-x-auto">
                            <table class="min-w-full border-collapse text-xs sm:text-sm">
                                <thead>
                                    <tr class="bg-slate-50 text-slate-700">
                                        <th class="border border-slate-200 px-3 py-2 text-left font-semibold">Date</th>
                                        <th class="border border-slate-200 px-3 py-2 text-left font-semibold">Check-in</th>
                                        <th class="border border-slate-200 px-3 py-2 text-left font-semibold">Check-out
                                        </th>
                                        <th class="border border-slate-200 px-3 py-2 text-left font-semibold">Duration</th>
                                        <th class="border border-slate-200 px-3 py-2 text-left font-semibold">Location</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recent as $rec)
                                        <tr class="odd:bg-white even:bg-slate-50">
                                            <td class="border border-slate-200 px-3 py-2 whitespace-nowrap">
                                                {{ $rec->check_in_at->format('Y-m-d') }}
                                            </td>
                                            <td class="border border-slate-200 px-3 py-2 whitespace-nowrap">
                                                {{ $rec->check_in_at->format('H:i') }}
                                            </td>
                                            <td class="border border-slate-200 px-3 py-2 whitespace-nowrap">
                                                {{ $rec->check_out_at?->format('H:i') ?? '—' }}
                                            </td>
                                            <td class="border border-slate-200 px-3 py-2 whitespace-nowrap">
                                                {{ $rec->duration_human ?? '—' }}
                                            </td>
                                            <td class="border border-slate-200 px-3 py-2">
                                                @if ($rec->check_in_lat && $rec->check_in_lng)
                                                    <a href="https://maps.google.com/?q={{ $rec->check_in_lat }},{{ $rec->check_in_lng }}"
                                                        target="_blank" class="text-sky-600 hover:underline">
                                                        Open map
                                                    </a>
                                                @else
                                                    <span class="text-slate-400">—</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5"
                                                class="border border-slate-200 px-3 py-6 text-center text-slate-400 text-sm">
                                                No records
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const latEl = document.getElementById('lat');
            const lngEl = document.getElementById('lng');
            const btn = document.getElementById('attendanceBtn');
            const statusEl = document.getElementById('locStatus');
            const retryBtn = document.getElementById('retryLoc');
            const addrEl = document.getElementById('address');

            function setStatus(text, variant) {
                if (!statusEl) return;

                const base =
                    'text-xs mb-2 rounded-md border px-3 py-2 flex items-center gap-1';

                let color = '';
                switch (variant) {
                    case 'success':
                        color = ' bg-emerald-50 text-emerald-800 border-emerald-200';
                        break;
                    case 'warning':
                        color = ' bg-amber-50 text-amber-800 border-amber-200';
                        break;
                    case 'danger':
                        color = ' bg-rose-50 text-rose-800 border-rose-200';
                        break;
                    case 'info':
                    default:
                        color = ' bg-slate-50 text-slate-800 border-slate-200';
                        break;
                }

                statusEl.textContent = '';
                statusEl.className = base + color;

                const i = document.createElement('i');
                i.className = 'bi bi-geo-alt mr-1';
                statusEl.appendChild(i);
                statusEl.appendChild(document.createTextNode(text));
            }

            function enableIfReady(msg, variant) {
                const good = latEl.value && lngEl.value;
                if (good) {
                    btn?.removeAttribute('disabled');
                    if (msg) setStatus(msg, variant || 'success');
                } else {
                    btn?.setAttribute('disabled', 'disabled');
                }
            }

            function setCoords(pos, sourceLabel) {
                const {
                    latitude,
                    longitude,
                    accuracy
                } = pos.coords || {};
                if (typeof latitude === 'number' && typeof longitude === 'number') {
                    latEl.value = latitude.toFixed(7);
                    lngEl.value = longitude.toFixed(7);
                    const acc = typeof accuracy === 'number' ? Math.round(accuracy) + 'm' : 'unknown';
                    const note = sourceLabel ? ` (${sourceLabel}, ±${acc})` : ` (±${acc})`;
                    if (addrEl) addrEl.value = `auto${note}`;
                    enableIfReady('Location acquired' + note + '. You can proceed.', 'success');
                    return true;
                }
                return false;
            }

            function permissionsHint(err) {
                if (!err) return 'Could not get location.';
                if (err.code === err.PERMISSION_DENIED)
                    return 'Location permission denied. Please allow access and tap retry.';
                if (err.code === err.POSITION_UNAVAILABLE)
                    return 'Position unavailable. Move to open sky or enable GPS, then retry.';
                if (err.code === err.TIMEOUT)
                    return 'Timed out trying to get location. Retrying…';
                return 'Could not get location. Please check location settings and retry.';
            }

            async function askLocation() {
                if (!navigator.geolocation) {
                    setStatus('Geolocation not supported by this browser.', 'danger');
                    return;
                }

                // Stage 0: quick permission probe
                try {
                    if (navigator.permissions && navigator.permissions.query) {
                        const p = await navigator.permissions.query({
                            name: 'geolocation'
                        });
                        if (p.state === 'denied') {
                            setStatus('Location permission is blocked. Enable it in browser settings and tap retry.',
                                'danger');
                            return;
                        }
                    }
                } catch (_) {}

                // Strategy 1: High-accuracy single fix
                setStatus('Getting precise location…', 'warning');
                const one = await new Promise((resolve) => {
                    let settled = false;
                    const t = setTimeout(() => {
                        if (!settled) resolve({
                            ok: false,
                            err: {
                                code: 3
                            }
                        });
                    }, 13000);
                    navigator.geolocation.getCurrentPosition(
                        (pos) => {
                            settled = true;
                            clearTimeout(t);
                            resolve({
                                ok: true,
                                pos,
                                label: 'high-accuracy'
                            });
                        },
                        (err) => {
                            settled = true;
                            clearTimeout(t);
                            resolve({
                                ok: false,
                                err
                            });
                        }, {
                            enableHighAccuracy: true,
                            timeout: 12000,
                            maximumAge: 0
                        }
                    );
                });
                if (one.ok && setCoords(one.pos, one.label)) return;
                if (one.err) setStatus(permissionsHint(one.err), 'warning');

                // Strategy 2: Watch for a better fix briefly
                setStatus('Searching for GPS fix…', 'warning');
                const two = await new Promise((resolve) => {
                    if (!navigator.geolocation.watchPosition) return resolve({
                        ok: false,
                        err: {
                            code: 2
                        }
                    });
                    let done = false;
                    let id = null;
                    const limit = setTimeout(() => {
                        if (!done) {
                            done = true;
                            if (id !== null) navigator.geolocation.clearWatch(id);
                            resolve({
                                ok: false,
                                err: {
                                    code: 3
                                }
                            });
                        }
                    }, 12000);
                    try {
                        id = navigator.geolocation.watchPosition((pos) => {
                            if (done) return;
                            done = true;
                            clearTimeout(limit);
                            if (id !== null) navigator.geolocation.clearWatch(id);
                            resolve({
                                ok: true,
                                pos,
                                label: 'watch'
                            });
                        }, (err) => {
                            if (done) return;
                            done = true;
                            clearTimeout(limit);
                            if (id !== null) navigator.geolocation.clearWatch(id);
                            resolve({
                                ok: false,
                                err
                            });
                        }, {
                            enableHighAccuracy: true,
                            maximumAge: 0
                        });
                    } catch (e) {
                        clearTimeout(limit);
                        resolve({
                            ok: false,
                            err: e
                        });
                    }
                });
                if (two.ok && setCoords(two.pos, two.label)) return;
                if (two.err) setStatus(permissionsHint(two.err), 'warning');

                // Strategy 3: Low-accuracy with cached last known
                setStatus('Using last known location…', 'info');
                const three = await new Promise((resolve) => {
                    navigator.geolocation.getCurrentPosition(
                        (pos) => resolve({
                            ok: true,
                            pos,
                            label: 'low-accuracy'
                        }),
                        (err) => resolve({
                            ok: false,
                            err
                        }), {
                            enableHighAccuracy: false,
                            timeout: 8000,
                            maximumAge: 300000
                        }
                    );
                });
                if (three.ok && setCoords(three.pos, three.label)) return;
                if (three.err) setStatus(permissionsHint(three.err), 'warning');

                // Strategy 4: Low-accuracy watch briefly
                setStatus('Trying approximate location…', 'info');
                const four = await new Promise((resolve) => {
                    if (!navigator.geolocation.watchPosition) return resolve({
                        ok: false,
                        err: {
                            code: 2
                        }
                    });
                    let done = false;
                    let id = null;
                    const limit = setTimeout(() => {
                        if (!done) {
                            done = true;
                            if (id !== null) navigator.geolocation.clearWatch(id);
                            resolve({
                                ok: false,
                                err: {
                                    code: 3
                                }
                            });
                        }
                    }, 10000);
                    try {
                        id = navigator.geolocation.watchPosition((pos) => {
                            if (done) return;
                            done = true;
                            clearTimeout(limit);
                            if (id !== null) navigator.geolocation.clearWatch(id);
                            resolve({
                                ok: true,
                                pos,
                                label: 'approximate'
                            });
                        }, (err) => {
                            if (done) return;
                            done = true;
                            clearTimeout(limit);
                            if (id !== null) navigator.geolocation.clearWatch(id);
                            resolve({
                                ok: false,
                                err
                            });
                        }, {
                            enableHighAccuracy: false,
                            maximumAge: 300000
                        });
                    } catch (e) {
                        clearTimeout(limit);
                        resolve({
                            ok: false,
                            err: e
                        });
                    }
                });
                if (four.ok && setCoords(four.pos, four.label)) return;

                setStatus('Could not determine your location. Please move to an open area or enable GPS and tap retry.',
                    'danger');
                enableIfReady();
            }

            retryBtn?.addEventListener('click', () => {
                latEl.value = '';
                lngEl.value = '';
                btn?.setAttribute('disabled', 'disabled');
                askLocation();
            });

            document.addEventListener('DOMContentLoaded', askLocation);

            document.getElementById('attendanceForm')?.addEventListener('submit', (e) => {
                if (!latEl.value || !lngEl.value) {
                    e.preventDefault();
                    setStatus('Location is required. Please enable location permission and tap retry.', 'danger');
                }
            });
        </script>
    @endpush
@endsection
