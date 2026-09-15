<?php

use App\Models\Administrate\Modul;
use App\Models\Administrate\ModulGroup;
use App\Models\Auth\Permission;
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
        Schema::create('administrate__modul_groups', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->string('name');

            $table->timestamps();
        });

        Schema::create('administrate__modules', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('route_name');

            $table->foreignId('group_id')->nullable()->constrained(ModulGroup::getTableName());

            $table->boolean('in_production')->default(false);

            $table->timestamps();
        });

        Schema::create('administrate__module_pivot_permission', function (Blueprint $table) {
            $table->id();

            $table->foreignId('modul_id')->nullable()->constrained(Modul::getTableName());
            $table->foreignId('permission_id')->nullable()->constrained(Permission::getTableName());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrate__modules');
        Schema::dropIfExists('administrate__modul_groups');
    }
};
