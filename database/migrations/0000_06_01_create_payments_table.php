<?php

use App\Models\Administrate\Law;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('administrate__financing_types', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('sfr_fsd_code')->nullable();
            $table->string('asp_name')->nullable();
        });

        Schema::create('administrate__payments', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->string('name');
            $table->string('kbk');

            $table->foreignId('law_id')->constrained(Law::getTableName());

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('administrate__payments');
        Schema::dropIfExists('administrate__financing_types');
    }
};
