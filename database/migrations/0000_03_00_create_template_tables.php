<?php

use App\Models\Base\File;
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
        Schema::create('administrate__templates', function (Blueprint $table) {
            $table->id();

            $table->string('description');
            $table->string('writer')->nullable();

            $table->foreignId('file_id')->constrained(File::getTableName());

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrate__templates');
    }
};
