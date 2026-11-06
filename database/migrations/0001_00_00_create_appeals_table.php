<?php

use App\Models\Appeal\Status;
use App\Models\Appeal\Theme;
use App\Models\Appeal\ThemeGroup;
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
        Schema::create('appeal__theme_groups', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->string('name');

            $table->timestamps();
        });

        Schema::create('appeal__themes', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->foreignId('group_id')->constrained(ThemeGroup::getTableName());

            $table->timestamps();
        });

        Schema::create('appeal__statuses', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->string('name');

            $table->timestamps();
        });

        Schema::create('appeal__appeals', function (Blueprint $table) {
            $table->id();

            $table->text('comment');

            $table->foreignId('chat_id')->constrained(Chat::getTableName());
            $table->foreignId('sender_id')->constrained(User::getTableName());
            $table->foreignId('worker_id')->nullable()->constrained(User::getTableName());
            $table->foreignId('theme_id')->constrained(Theme::getTableName());
            $table->foreignId('status_id')->constrained(Status::getTableName());

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appeal__appeals');
        Schema::dropIfExists('appeal__statuses');
        Schema::dropIfExists('appeal__themes');
        Schema::dropIfExists('appeal__theme_groups');
    }
};
