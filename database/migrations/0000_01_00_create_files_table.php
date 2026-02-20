<?php

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
        Schema::create('base__files', function (Blueprint $table) {
            $table->id();

            $table->string('disk')->default('public');
            $table->string('path');
            $table->string('name');
            $table->string('origin_name');
            $table->json('errors');

            $table->foreignId('upload_at')->nullable()->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('base__files');
    }
};
