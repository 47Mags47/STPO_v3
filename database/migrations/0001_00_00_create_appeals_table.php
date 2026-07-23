<?php

use App\Models\Appeal\Appeal;
use App\Models\Appeal\Status;
use App\Models\Appeal\Them;
use App\Models\Appeal\ThemGroup;
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
        Schema::create('appeal__them_groups', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->string('name');

            $table->timestamps();
        });

        Schema::create('appeal__thems', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->foreignId('group_id')->constrained(ThemGroup::getTableName());

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

            $table->string('comment');

            $table->foreignId('chat_id')->constrained(Chat::getTableName());
            $table->foreignId('sender_id')->constrained(User::getTableName());
            $table->foreignId('worker_id')->nullable()->constrained(User::getTableName());
            $table->foreignId('them_id')->constrained(Them::getTableName());
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
        Schema::dropIfExists('appeal__thems');
        Schema::dropIfExists('appeal__them_groups');
    }
};
