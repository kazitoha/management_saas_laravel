<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('permissionExists')) {
    /**
     * Check if the current user has the given permission.
     */
    function permissionExists(string $permissionName): bool
    {
        $user = request()->user();
        if (!$user) {
            return false;
        }

        if ($user->roles?->contains('name', 'admin')) {
            return true;
        }

        $roleId = $user->roles?->first()?->id;
        if (!$roleId) {
            return false;
        }

        $permissionId = DB::table('permissions')->where('name', $permissionName)->value('id');
        if (!$permissionId) {
            return false;
        }

        return \App\Models\PermissionRole::where('permission_id', $permissionId)
            ->where('role_id', $roleId)
            ->exists();
    }
}
