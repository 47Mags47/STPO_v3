<?php

use App\Models\Administrate\City;
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
        Schema::create('administrate__cities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('administrate__divisions', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();

            $table->foreignId('city_id')->constrained(City::getTableName())->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_cities');
        Schema::dropIfExists('administrate__divisions');
    }
};
