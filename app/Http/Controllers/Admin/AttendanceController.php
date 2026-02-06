<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\AttendanceRecord;
use Illuminate\Http\Request;
use Carbon\Carbon;


class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $todayRecord = AttendanceRecord::where('user_id', $user->id)
            ->whereDate('check_in_at', now()->toDateString())
            ->latest('check_in_at')
            ->first();

        $recent = AttendanceRecord::where('user_id', $user->id)
            ->latest('check_in_at')
            ->limit(10)
            ->get();

        return view('admin.attendance.index', compact('todayRecord', 'recent'));
    }

    public function checkIn(Request $request)
    {
        $data = $this->validateLocation($request, 'check in');
        $userId = $request->user()->id;

        // Lock latest record to prevent double-submit race
        $latest = AttendanceRecord::where('user_id', $userId)
            ->latest('check_in_at')
            ->lockForUpdate()
            ->first();

        // If already checked in (open)
        if ($latest && $latest->check_out_at === null) {
            abort(redirect()->back()->with('error', 'You already have an active attendance (checked in).'));
        }

        // Only one check-in per day
        $today = now()->toDateString();
        $todayExists = AttendanceRecord::where('user_id', $userId)
            ->whereDate('check_in_at', $today)
            ->exists();

        if ($todayExists) {
            abort(redirect()->back()->with('error', 'You have already checked in once today.'));
        }

        // Late minutes (simple)
        $late = $this->lateMinutes(now());

        AttendanceRecord::create([
            'user_id' => $userId,
            'check_in_at' => now(),
            'check_in_lat' => (float) $data['lat'],
            'check_in_lng' => (float) $data['lng'],
            'check_in_address' => $data['address'] ?? null,
            'notes' => $data['notes'] ?? null,
            'late_minutes' => $late,
            'company_id' => session('company_id'),
        ]);

        session()->flash(
            'success',
            $late > 0
                ? "Checked in successfully. You are late by {$late} minute(s)."
                : "Checked in successfully."
        );

        return back();
    }

    public function checkOut(Request $request)
    {
        $data = $this->validateLocation($request, 'check out');

        $userId = $request->user()->id;


        // Lock today's open attendance
        $open = AttendanceRecord::where('user_id', $userId)
            ->whereNull('check_out_at')
            ->whereDate('check_in_at', now()->toDateString())
            ->latest('check_in_at')
            ->lockForUpdate()
            ->first();

        // Lock today's close attendance

        $duration = \Carbon\Carbon::parse($open->check_in_at)->diffForHumans(now(), true);

        if (!$open) {
            abort(redirect()->back()->with('error', 'No active attendance to check out from.'));
        }

        $open->update([
            'check_out_at' => now(),
            'check_out_lat' => (float) $data['lat'],
            'check_out_lng' => (float) $data['lng'],
            'check_out_address' => $data['address'] ?? null,
            'notes' => ($data['notes'] ?? null) ?: $open->notes,
            'duration_minutes' => $duration,
        ]);

        session()->flash('success', 'Checked out successfully.');


        return back();
    }

    public function status(Request $request)
    {
        $user = $request->user();

        $todayRecord = AttendanceRecord::where('user_id', $user->id)
            ->whereDate('check_in_at', now()->toDateString())
            ->latest('check_in_at')
            ->first();

        return response()->json([
            'checked_in' => $todayRecord !== null,
            'checked_in_at' => $todayRecord?->check_in_at?->toIso8601String(),
            'checked_out_at' => $todayRecord?->check_out_at?->toIso8601String(),
            'late_minutes' => (int) ($todayRecord?->late_minutes ?? 0),
        ]);
    }

    // -------------------------
    // Helpers inside controller
    // -------------------------

    private function validateLocation(Request $request, string $actionLabel): array
    {
        return $request->validate([
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
            'address' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:255',
        ], [
            'lat.required' => "Location is required to {$actionLabel}. Please enable location permission.",
            'lng.required' => "Location is required to {$actionLabel}. Please enable location permission.",
        ]);
    }

    /**
     * SIMPLE late minutes:
     * - Start time: 09:00
     * - Grace: 10 minutes
     * Change these two values as you need.
     */
    private function lateMinutes($checkIn): int
    {
        $start = now()->copy()->setTime(9, 0, 0);
        $grace = 10;

        if ($checkIn->lte($start)) return 0;

        $diff = $start->diffInMinutes($checkIn);
        return max(0, $diff - $grace);
    }
}
