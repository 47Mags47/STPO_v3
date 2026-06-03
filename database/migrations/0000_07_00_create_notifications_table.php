<?php

use App\Models\Base\Notification;
use App\Models\Base\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('base__notifications_types', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
        });

        Schema::create('base__notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipient_id')->nullable()->constrained(User::getTableName());
            $table->foreignId('type_id')->constrained(Notification::getTableName());

            $table->text('message');
            $table->boolean('is_readed')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('base__notifications');
        Schema::dropIfExists('base__notifications_types');
    }
};
