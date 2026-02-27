<?php

use App\Models\Appeal\Appeal;
use App\Models\Appeal\Message;
use App\Models\Appeal\Status;
use App\Models\Appeal\Them;
use App\Models\Appeal\ThemGroup;
use App\Models\File;
use App\Models\User;
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

            $table->string('office');
            $table->string('comment');

            $table->foreignId('sender_id')->constrained(User::getTableName());
            $table->foreignId('them_id')->constrained(Them::getTableName());
            $table->foreignId('status_id')->constrained(Status::getTableName());

            $table->timestamps();
        });

        Schema::create('appeal__messages', function (Blueprint $table) {
            $table->id();

            $table->text('message');
            $table->boolean('readed');
            $table->foreignId('appeal_id')->constrained(Appeal::getTableName());
            $table->foreignId('sender_id')->constrained(User::getTableName());

            $table->timestamps();
        });

        Schema::create('appeal__message_files', function (Blueprint $table) {
            $table->id();

            $table->foreignId('message_id')->constrained(Message::getTableName());
            $table->foreignId('file_id')->constrained(File::getTableName());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appeal__message_files');
        Schema::dropIfExists('appeal__messages');
        Schema::dropIfExists('appeal__appeals');
        Schema::dropIfExists('appeal__statuses');
        Schema::dropIfExists('appeal__thems');
        Schema::dropIfExists('appeal__them_groups');
    }
};
