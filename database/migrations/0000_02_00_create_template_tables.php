<?php

use App\Models\File;
use App\Models\TemplateStyle;
use App\Models\TemplateType;
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
        Schema::create('base__template_styles', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->string('name');

            $table->timestamps();
        });

        Schema::create('base__template_types', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->string('name');

            $table->timestamps();
        });

        Schema::create('base__templates', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->foreignId('file_id')->constrained(File::getTableName());
            $table->foreignId('type_id')->constrained(TemplateType::getTableName());
            $table->foreignId('style_id')->constrained(TemplateStyle::getTableName());
            $table->integer('chunk')->nullable()->default(null);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('base__templates');
        Schema::dropIfExists('base__template_types');
        Schema::dropIfExists('base__template_styles');
    }
};
