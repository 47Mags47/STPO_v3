<?php

use App\Models\Administrate\ModulGroup;
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
            $table->foreignId('group_id')->constrained(ModulGroup::getTableName());
            $table->foreignId('creator_id')->nullable()->constrained(User::getTableName());

            $table->timestamps();
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
