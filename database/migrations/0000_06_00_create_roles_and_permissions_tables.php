<?php

use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use App\Models\Division;
use App\Models\Modul;
use App\Models\User;
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
        Schema::create('auth__roles', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->string('name');

            $table->timestamps();
        });

        Schema::create('auth__permissions', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->string('name');

            $table->timestamps();
        });

        Schema::create('auth__roles_pivot_permissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('role_id')->constrained(Role::getTableName());
            $table->foreignId('permission_id')->constrained(Permission::getTableName());
        });

        Schema::create('auth__users_pivot_roles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained(Permission::getTableName());
            $table->foreignId('role_id')->constrained(Role::getTableName());

            $table->foreignId('division_id')->nullable()->constrained(Division::getTableName());
            $table->foreignId('modul_id')->nullable()->constrained(Modul::getTableName());
        });

        Schema::create('auth__users_pivot_permissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained(User::getTableName());
            $table->foreignId('permission_id')->constrained(Permission::getTableName());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auth__users_pivot_permissions');
        Schema::dropIfExists('auth__users_pivot_roles');
        Schema::dropIfExists('auth__roles_pivot_permissions');
        Schema::dropIfExists('auth__permissions');
        Schema::dropIfExists('auth__roles');
    }
};
