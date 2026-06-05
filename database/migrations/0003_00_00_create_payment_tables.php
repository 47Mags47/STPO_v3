<?php

use App\Models\Payment\Payment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment__banks', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();
            $table->string('name');

            $table->timestamps();
        });

        Schema::create('payment__payments', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();
            $table->string('name')->unique();
            $table->string('kbk');

            $table->timestamps();
        });

        Schema::create('payment__events', function (Blueprint $table) {
            $table->id();

            $table->date('in_day');
            $table->foreignId('payment_id')->constrained(Payment::getTableName());

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment__events');
        Schema::dropIfExists('payment__payments');
        Schema::dropIfExists('payment__banks');
    }
};
