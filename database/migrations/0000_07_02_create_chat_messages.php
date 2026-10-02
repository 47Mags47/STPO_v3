<?php

use App\Models\Base\Chat;
use App\Models\Base\ChatMessage;
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

            $table->boolean('is_readed')->default(false);
            $table->boolean('is_system')->default(false);

            $table->foreignId('chat_id')->constrained(Chat::getTableName());
            $table->foreignId('sender_id')->nullable()->constrained(User::getTableName());

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('base__chat_attachments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('message_id')->constrained(ChatMessage::getTableName())->cascadeOnDelete();
            $table->foreignId('file_id')->constrained(File::getTableName());

            $table->timestamps();
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
