<?php

use App\Models\Administrate\Division;
use App\Models\Auth\Permission;
use App\Models\Auth\PermissionGroup;
use App\Models\Base\User;
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
        Schema::create('auth__permission_groups', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->string('name');

            $table->timestamps();
        });

        Schema::create('auth__permissions', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->string('name');
            $table->foreignId('group_id')->nullable()->constrained(PermissionGroup::getTableName());

            $table->timestamps();
        });

        Schema::create('auth__user_pivot_permission', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained(User::getTableName());
            $table->foreignId('permission_id')->constrained(Permission::getTableName());
            $table->foreignId('division_id')->nullable()->constrained(Division::getTableName());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auth__user_pivot_permission');
        Schema::dropIfExists('auth__permissions');
        Schema::dropIfExists('auth__permission_groups');
    }
};
