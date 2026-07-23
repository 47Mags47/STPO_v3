<?php

use App\Models\Base\Chat;
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
        Schema::create('base__chat_subscribers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->constrained(Chat::getTableName());
            $table->foreignId('user_id')->constrained(User::getTableName());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('base__chat_subscribers');
    }
};
