<?php

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


if (! function_exists('encode')) {
    /**
     * Generate a random encryption key for use with Laravel's encryption services.
     */
    function encode(string $value, int $times = 2)
    {
        // return $value;
        // return Crypt::encryptString($value);
        for ($i = 1; $i <= $times; $i++) {
            $value = base64_encode($value);
        }
        return $value;
    }
}

if (! function_exists('decode')) {
    /**
     * Decrypt a value previously encrypted with the encode() helper.
     */
    function decode(string $value, int $times = 2): string
    {
        // return $value;
        // return Crypt::decryptString($value);
        for ($i = 1; $i <= $times; $i++) {
            $value = base64_decode($value);
        }
        return $value;
    }
}



// this is use for if you wan't to use id in model


function encode_safe(string $value, int $times = 1): string
{
    for ($i = 1; $i <= $times; $i++) {
        $value = rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
    return $value;
}


// this is use for if you wan't to use id in model


function decode_safe(string $value, int $times = 1): string
{
    for ($i = 1; $i <= $times; $i++) {
        $value = strtr($value, '-_', '+/');
        $pad = strlen($value) % 4;
        if ($pad) $value .= str_repeat('=', 4 - $pad);
        $value = base64_decode($value);
    }
    return $value;
}

if (! function_exists('adminNavItems')) {
    /**
     * Admin sidebar navigation definition.
     *
     * Keep this list in PHP (not config) so you can safely add dynamic pieces later
     * without breaking `php artisan config:cache`.
     */
    function adminNavItems(): array
    {
        return [
            [
                'label' => 'Dashboard',
                'icon' => 'home',
                'route' => 'dashboard',
                'patterns' => ['dashboard'],
                'accent' => 'bg-blue-50 text-blue-600',
            ],
            [
                'label' => 'Onboarding Forms',
                'icon' => 'clipboard',
                'route' => 'onboards.index',
                'patterns' => ['onboards.*'],
                'accent' => 'bg-orange-50 text-orange-600',
            ],
            [
                'label' => 'Patient',
                'icon' => 'users',
                'patterns' => ['patient.manage.*'],
                'accent' => 'bg-emerald-50 text-emerald-600',
                'children' => [
                    ['label' => 'Add Patient', 'route' => 'patient.manage.create'],
                    ['label' => 'Manage Patient', 'route' => 'patient.manage.index'],
                ],
            ],
            [
                'label' => 'Caregiver',
                'icon' => 'user-check',
                'patterns' => ['caregiver.manage.*'],
                'accent' => 'bg-lime-50 text-lime-700',
                'children' => [
                    ['label' => 'Add Caregiver', 'route' => 'caregiver.manage.create'],
                    ['label' => 'Manage Caregiver', 'route' => 'caregiver.manage.index'],
                ],
            ],
            [
                'label' => 'Consultant',
                'icon' => 'briefcase',
                'patterns' => ['consultant.*'],
                'accent' => 'bg-indigo-50 text-indigo-600',
                'children' => [
                    ['label' => 'Add Consultant', 'route' => 'consultant.create'],
                    ['label' => 'Manage Consultant', 'route' => 'consultant.index'],
                    ['label' => 'Consultant Types', 'route' => 'consultant.types.index'],
                    ['label' => 'Consultant Categories', 'route' => 'consultant.categories.index'],
                ],
            ],
            [
                'label' => 'Schedules',
                'icon' => 'clock',
                'route' => 'schedules.index',
                'patterns' => ['schedules.*'],
                'accent' => 'bg-sky-50 text-sky-600',
            ],
            [
                'label' => 'Pre invoice',
                'icon' => 'file-text',
                'patterns' => ['pre.invoice.*'],
                'accent' => 'bg-rose-50 text-rose-600',
                'children' => [
                    ['label' => 'Create Pre Invoice', 'route' => 'pre.invoice.create'],
                    ['label' => 'Manage Pre Invoice', 'route' => 'pre.invoice.index'],
                ],
            ],
            [
                'label' => 'Billing & Financials',
                'icon' => 'credit-card',
                'patterns' => ['patient.bill.*', 'caregiver-bill.*'],
                'accent' => 'bg-amber-50 text-amber-700',
                'children' => [
                    ['label' => 'Patient', 'route' => 'patient.bill.index'],
                    ['label' => 'Caregiver', 'route' => 'caregiver-bill.index'],
                ],
            ],
            [
                'label' => 'Inventory',
                'icon' => 'shopping-cart',
                'patterns' => ['inventory.*'],
                'accent' => 'bg-purple-50 text-purple-600',
                'children' => [
                    ['label' => 'Items', 'route' => 'inventory.items.index'],
                    ['label' => 'Add Item', 'route' => 'inventory.items.create'],
                    ['label' => 'Dispatched', 'route' => 'inventory.dispatched.index'],
                    ['label' => 'Dispatched Category', 'route' => 'inventory.dispatched.category.index'],
                ],
            ],
            [
                'label' => 'Add-on Services',
                'icon' => 'package',
                'patterns' => ['add-on-services.*'],
                'accent' => 'bg-teal-50 text-teal-700',
                'children' => [
                    ['label' => 'Manage Services', 'route' => 'add-on-services.index'],
                    ['label' => 'Categories', 'route' => 'add-on-services.categories.index'],
                    ['label' => 'Category Types', 'route' => 'add-on-services.categories.types.index'],
                ],
            ],
            [
                'label' => 'Settings',
                'icon' => 'settings',
                'patterns' => ['settings.*'],
                'accent' => 'bg-slate-100 text-slate-700',
                'children' => [
                    ['label' => 'Area Codes', 'route' => 'settings.area-codes.index'],
                    ['label' => 'Level Cares', 'route' => 'settings.level-cares.index'],
                    ['label' => 'Care Services', 'route' => 'settings.care-services.index'],
                    ['label' => 'Scope of Works', 'route' => 'settings.scope-of-works.index'],
                ],
            ],
            [
                'label' => 'Access Control',
                'icon' => 'shield',
                'patterns' => ['admin.roles.*', 'admin.permissions.*', 'admin.users.*'],
                'accent' => 'bg-cyan-50 text-cyan-700',
                'children' => [
                    ['label' => 'Roles', 'route' => 'admin.roles.index'],
                    ['label' => 'Permissions', 'route' => 'admin.permissions.index'],
                    ['label' => 'Users', 'route' => 'admin.users.index'],
                ],
            ],
            [
                'label' => 'Theme Management',
                'icon' => 'layout',
                'route' => 'theme.management.index',
                'patterns' => ['theme.management.*'],
                'accent' => 'bg-fuchsia-50 text-fuchsia-700',
            ],
            [
                'label' => 'Website Content',
                'icon' => 'globe',
                'patterns' => ['website.*'],
                'accent' => 'bg-green-50 text-green-700',
                'children' => [
                    ['label' => 'Contact', 'route' => 'website.contact'],
                    ['label' => 'Career', 'route' => 'website.careers'],
                ],
            ],
        ];
    }
}
