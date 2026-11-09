<?php

use App\Models\Administrate\Division;
use App\Models\Base\User;
use App\Models\Veteran\Date;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('veteran__dates', function (Blueprint $table) {
            $table->id();

            $table->date('in_date');
            $table->boolean('is_active')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('veteran__reports', function (Blueprint $table) {
            $table->id();

            $table->integer('all')->default(0);
            $table->integer('online')->default(0);
            $table->integer('MFC')->default(0);

            $table->foreignId('user_id')->constrained(User::getTableName());
            $table->foreignId('division_id')->constrained(Division::getTableName());
            $table->foreignId('date_id')->constrained(Date::getTableName());


            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('veteran__reports');
        Schema::dropIfExists('veteran__dates');
    }
};
