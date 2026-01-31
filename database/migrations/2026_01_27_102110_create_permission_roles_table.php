<?php

use App\Models\Permissions;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permission_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Permissions::class, 'permission_id')->constrained('permissions')->cascadeOnDelete();
            $table->foreignIdFor(Role::class, 'role_id')->constrained('roles')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_roles');
    }
};
