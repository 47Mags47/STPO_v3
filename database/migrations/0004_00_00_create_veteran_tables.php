<?php

use App\Models\Administrate\Division;
use App\Models\Base\User;
use App\Models\Veteran\Report;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('veteran__reports', function (Blueprint $table) {
            $table->id();

            $table->date('start_at');
            $table->boolean('is_active')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('veteran__records', function (Blueprint $table) {
            $table->id();

            $table->integer('amount')->default(0);
            $table->integer('online_form')->default(0);
            $table->integer('MFC')->default(0);

            $table->foreignId('user_id')->constrained(User::getTableName());
            $table->foreignId('division_id')->constrained(Division::getTableName());
            $table->foreignId('report_id')->constrained(Report::getTableName());


            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('veteran__records');
        Schema::dropIfExists('veteran__raports');
    }
};
