<?php

use App\Models\Administrate\Division;
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
        Schema::create('base__user_pivot_division', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained(User::getTableName());
            $table->foreignId('division_id')->nullable()->constrained(Division::getTableName());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('base__user_pivot_division');
    }
};
