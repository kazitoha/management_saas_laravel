<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Companies;
use App\Models\Role;
use App\Models\SuperAdmin;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;



class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        // 1) Create/Update super admin (separate guard/table)
        SuperAdmin::updateOrCreate(
            ['email' => 'superadmin@mail.com'],
            [
                'name' => 'superadmin',
                'password' => Hash::make('1213141516'),
            ]
        );


        $company = Companies::updateOrCreate(
            ['name' => 'Default Company'],
            ['status' => 'active']
        );

        // 2) Create/Update admin user (web guard)
        $admin = User::updateOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'companies_id' => $company->id,
                'name' => 'admin',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'status' => 'active',
            ]
        );

        // 3) Create/Update roles for users table only
        $adminRole = Role::updateOrCreate(['name' => 'admin'], ['name' => 'admin']);

        // 4) Attach admin role to admin user (no duplicates)
        $admin->roles()->syncWithoutDetaching([$adminRole->id]);

        // 5) Grant all permissions to admin role (optional: keep if you want admin full access)
        $permissions = DB::table('permissions')->pluck('id')->all();

        if (!empty($permissions)) {
            foreach ($permissions as $pid) {
                DB::table('permission_roles')->updateOrInsert(
                    ['role_id' => $adminRole->id, 'permission_id' => $pid],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }
}
