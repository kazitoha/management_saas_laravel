<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Companies;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        $adminRole = Role::query()->where('name', 'admin')->first();

        $admins = $adminRole
            ? $adminRole->users()->with('company')->latest()->get()
            : collect();

        return view('super-admin.admins.index', [
            'admins' => $admins,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'company_status' => ['required', 'in:active,inactive,pending,demo'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'status' => ['required', 'in:active,inactive,pending'],
        ]);

        DB::transaction(function () use ($validated) {
            $company = Companies::create([
                'name' => $validated['company_name'],
                'status' => $validated['company_status'],
            ]);

            $user = User::create([
                'companies_id' => $company->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'status' => $validated['status'],
            ]);

            $adminRole = Role::firstOrCreate(['name' => 'admin']);
            $user->roles()->syncWithoutDetaching([$adminRole->id]);
        });

        return redirect()
            ->route('superadmin.admins.index')
            ->with('success', 'Admin account created.');
    }

    public function edit(User $user): View
    {
        $this->ensureAdmin($user);
        $user->load('company');

        return view('super-admin.admins.edit', [
            'admin' => $user,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $this->ensureAdmin($user);
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'company_status' => ['required', 'in:active,inactive,pending,demo'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'status' => ['required', 'in:active,inactive,pending'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        DB::transaction(function () use ($validated, $user) {
            $user->company?->update([
                'name' => $validated['company_name'],
                'status' => $validated['company_status'],
            ]);

            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'status' => $validated['status'],
                'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
            ]);
        });

        return redirect()
            ->route('superadmin.admins.index')
            ->with('success', 'Admin updated.');
    }

    public function updateStatus(Request $request, User $user): RedirectResponse
    {
        $this->ensureAdmin($user);
        $validated = $request->validate([
            'status' => ['required', 'in:active,inactive,pending'],
        ]);

        $user->update(['status' => $validated['status']]);

        return redirect()
            ->route('superadmin.admins.index')
            ->with('success', 'Admin status updated.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->ensureAdmin($user);
        DB::transaction(function () use ($user) {
            $company = $user->company;
            $user->roles()->detach();
            $user->delete();

            if ($company && $company->users()->count() === 0) {
                $company->delete();
            }
        });

        return redirect()
            ->route('superadmin.admins.index')
            ->with('success', 'Admin deleted.');
    }

    private function ensureAdmin(User $user): void
    {
        if (!$user->roles()->where('name', 'admin')->exists()) {
            abort(404);
        }
    }
}
