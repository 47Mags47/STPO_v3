<?php

use App\Models\Base\Chat;
use App\Models\Base\File;
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
            Schema::create('base__chat_messages', function (Blueprint $table) {
            $table->id();

            $table->text('message')->nullable()->default(null);
            $table->json('context')->nullable()->default(null);

            $table->boolean('readed')->default(false);

            $table->foreignId('sender_id')->constrained(User::getTableName());
            $table->foreignId('chat_id')->constrained(Chat::getTableName());
            $table->foreignId('file_id')->nullable()->default(null)->constrained(File::getTableName());

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('base__chat_messages');
    }
};
