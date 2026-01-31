<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $skipExactRoutes = [
            'register.user',
            'register.store',
            'login',
            'login.post',
            'otp.login.form',
            'otp.send',
            'otp.verify',
            'password.request',
            'password.email',
            'password.reset',
            'admin.dashboard',
            // 'logout',
        ];

        $now = Carbon::now();
        $count = 0;

        $routes = collect(Route::getRoutes())->filter(function ($route) use ($skipExactRoutes) {
            $name = $route->getName();

            if (!$name) return false;

            // Skip only if it's in the exact skip list
            return !in_array($name, $skipExactRoutes);
        });

        foreach ($routes as $route) {
            $name = $route->getName();
            $label = $this->generateLabelFromRouteName($name);

            DB::table('permissions')->updateOrInsert(
                ['name' => $name],
                [
                    'label' => $label,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );

            $count++;
        }

        $this->command->info(" $count permissions seeded (skipped " . count($skipExactRoutes) . " exact routes).");
    }

    private function generateLabelFromRouteName(string $name): string
    {
        $name = str_replace(['.', '_'], '-', $name); // normalize
        $parts = explode('-', $name);

        $actionMap = [
            'index'   => 'View',
            'show'    => 'View',
            'view'    => 'View',
            'store'   => 'Create',
            'create'  => 'Create',
            'edit'    => 'Edit',
            'update'  => 'Edit',
            'destroy' => 'Delete',
            'delete'  => 'Delete',
        ];

        $action = array_pop($parts);
        $resource = implode(' ', $parts);

        $actionLabel = $actionMap[$action] ?? Str::title($action);
        $resourceLabel = Str::title(str_replace(['_', '-'], ' ', $resource));

        return "$actionLabel $resourceLabel";
    }
}
