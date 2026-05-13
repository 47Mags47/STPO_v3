<?php

use App\Models\Base\File;
use App\Models\Base\FileStatus;
use App\Models\Base\UploadFile;
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
        Schema::create('base__file_statuses', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->string('name');
        });

        Schema::create('base__files', function (Blueprint $table) {
            $table->id();

            $table->string('disk')->default('public');
            $table->string('path');
            $table->string('name');
            $table->string('origin_name');

            $table->foreignId('upload_at')->nullable()->index();
            $table->foreignId('status_id')->nullable()->constrained(FileStatus::getTableName());

            $table->timestamps();
        });

        Schema::create('base__file_errors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')
                ->constrained(File::getTableName())
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('error');
        });

        Schema::create('base__file_uploads', function (Blueprint $table) {
            $table->id();

            $table->foreignId('file_id')->constrained(File::getTableName());
            $table->integer('totalChunks');

            $table->timestamps();
        });

        Schema::create('base__file_chunks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('file_id')->constrained(File::getTableName());

            $table->foreignId('upload_file_id')->constrained(UploadFile::getTableName());
            $table->boolean('uploaded')->default(false);
            $table->integer('npp');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('base__file_chunks');
        Schema::dropIfExists('base__file_uploads');
        Schema::dropIfExists('base__files');
        Schema::dropIfExists('base__file_statuses');
    }
};
