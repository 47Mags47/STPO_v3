<?php

use App\Models\Administrate\Bank;
use App\Models\Administrate\Division;
use App\Models\Administrate\Payment;
use App\Models\Base\File;
use App\Models\Base\Template;
use App\Models\Payment\Event;
use App\Models\Payment\PaymentFile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment__bank_contracts', function (Blueprint $table) {
            $table->id();

            $table->string('number');
            $table->date('signed_at');

            $table->foreignId('bank_id')->constrained(Bank::getTableName());
            $table->foreignId('template_id')->constrained(Template::getTableName());

            $table->timestamps();
        });

        Schema::create('payment__events', function (Blueprint $table) {
            $table->id();

            $table->date('in_day');
            $table->foreignId('payment_id')->constrained(Payment::getTableName());

            $table->timestamps();
        });

        Schema::create('payment__payment_files', function (Blueprint $table) {
            $table->id();

            $table->foreignId('file_id')->constrained(File::getTableName());
            $table->foreignId('bank_id')->constrained(Bank::getTableName());
            $table->foreignId('event_id')->constrained(Event::getTableName());
            $table->foreignId('division_id')->constrained(Division::getTableName());

            $table->timestamps();
        });

        Schema::create('payment__recipients', function (Blueprint $table) {
            $table->id();

            $table
                ->foreignId('file_id')
                ->constrained(PaymentFile::getTableName())
                ->cascadeOnDelete();

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->date('d_rojd')->nullable();
            $table->string('SNILS')->nullable();
            $table->string('account')->nullable();
            $table->decimal('amount', 8, 2)->nullable();
            $table->string('p_series')->nullable();
            $table->string('p_number')->nullable();
            $table->date('p_date')->nullable();
            $table->text('p_div')->nullable();
        });

        Schema::create('payment__raports_to_bank', function (Blueprint $table) {
            $table->id();

            $table->foreignId('file_id')->constrained(File::getTableName());
            $table->foreignId('bank_id')->constrained(Bank::getTableName());
            $table->foreignId('event_id')->constrained(Event::getTableName());

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment__events');
    }
};
