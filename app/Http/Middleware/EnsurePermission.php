<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePermission
{
    /**
     * Handle an incoming request.
     *
     * Usage:
     * - Per-route: ->middleware('ensure.permission:patient.store|patient.update')
     * - Global/auto: apply middleware to group WITHOUT params; it will check by route name.
     */
    public function handle(Request $request, Closure $next, ?string $abilities = null): Response
    {

        // Require login separately with 'auth' middleware. If not present, bail.
        $user = $request->user();
        if (!$user) {
            return $this->deny($request);
        }

        if (permissionExists(request()->route()->getName()) || $user->roles->contains('name', 'admin')) {
            return $next($request, $user);
        }

        abort(403, 'Forbidden');
    }

    /**
     * Consistent deny behavior for API vs Web.
     */
    protected function deny(Request $request): Response
    {
        if ($request->expectsJson()) {
            abort(403, 'Forbidden');
        }
        return redirect()
            ->route('login')
            ->with('error', 'You are not authorized to access that page.');
    }
}
