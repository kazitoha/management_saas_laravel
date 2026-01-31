<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\BlockIP;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $ip  = $request->ip();
        $key = 'login_fail_ip:' . $ip;

        $isBlocked = BlockIP::query()
            ->where('ip_address', $ip)
            ->whereNotNull('blocked_at')
            ->exists();
        if ($isBlocked) {
            throw ValidationException::withMessages([
                'email' => 'This IP address is blocked. Please contact support.',
            ]);
        }

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->boolean('remember');


        // check auth based on mail and role guard

        if (Auth::guard('web')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            RateLimiter::clear($key); // reset failed attempts on success

            return redirect()->intended(route('dashboard'));
        }


        if (Auth::guard('superadmin')->attempt($credentials, $remember)) {

            $request->session()->regenerate();
            RateLimiter::clear($key); // reset failed attempts on success

            return redirect()->intended(route('superadmin.dashboard'));
        }


        // failed login: count attempts for 10 minutes
        RateLimiter::hit($key, 600); // 600 seconds = 10 minutes

        // if 3 or more fails within 10 minutes, store IP
        if (RateLimiter::attempts($key) >= 3) {
            BlockIP::updateOrCreate(
                ['ip_address' => $ip],
                [
                    'blocked_at' => now(),
                    'reason' => '3 failed login attempts within 10 minutes',
                ]
            );
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
