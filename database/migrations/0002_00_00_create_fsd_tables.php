<?php

use App\Models\Administrate\FinancingType;
use App\Models\Base\File;
use App\Models\SFR\FSD\ASPPaymentCategory;
use App\Models\SFR\FSD\PaymentFile;
use App\Models\SFR\FSD\SFRFile;
use App\Models\SFR\FSD\SFRPaymentCategory;
use App\Models\SFR\FSD\TransitCategory;
use App\Models\SFR\FSD\TransitFile;
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
        Schema::create('sfr__fsd__sfr_files', function (Blueprint $table) {
            $table->id();

            $table->date('in_date');
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();

            $table->foreignId('file_id')->constrained(File::getTableName())
                ->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::create('sfr__fsd__result_files', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sfr_file_id')->constrained(SFRFile::getTableName())
                ->cascadeOnDelete();
            $table->foreignId('file_id')->constrained(File::getTableName())
                ->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::create('sfr__fsd__sfr_payment_categories', function (Blueprint $table) {
            $table->id();

            $table->string('pay_number');
            $table->string('name');

            $table->timestamps();
        });

        Schema::create('sfr__fsd__asp_payment_categories', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->foreignId('sfr_payment_category_id')->constrained(SFRPaymentCategory::getTableName());

            $table->timestamps();
        });

        Schema::create('sfr__fsd__payment_files', function (Blueprint $table) {
            $table->id();

            $table->date('in_date');

            $table->foreignId('file_id')->constrained(File::getTableName())
                ->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::create('sfr__fsd__payments', function (Blueprint $table) {
            $table->id();

            $table->string('first_name')->nullable()->default(null);
            $table->string('last_name')->nullable()->default(null);
            $table->string('middle_name')->nullable()->default(null);

            $table->decimal('amount', 8, 2)->nullable()->default(null);
            $table->string('SNILS')->nullable()->default(null);

            $table->foreignId('asp_payment_category_id')->nullable()->constrained(ASPPaymentCategory::getTableName());
            $table->foreignId('financing_type_id')->nullable()->constrained(FinancingType::getTableName());
            $table->foreignId('file_id')->constrained(PaymentFile::getTableName())
                ->cascadeOnDelete();

            $table->index(['SNILS']);
        });

        Schema::create('sfr__fsd__transit_categories', function (Blueprint $table) {
            $table->id();

            $table->integer('wp_category_id')->nullable();
            $table->string('name');

            $table->timestamps();
        });

        Schema::create('sfr__fsd__transit_equivalents', function (Blueprint $table) {
            $table->id();

            $table->decimal('equivalent', 8, 2);
            $table->date('date_start')->index();
            $table->date('date_end')->nullable()->index();

            $table->foreignId('category_id')->constrained(TransitCategory::getTableName());

            $table->timestamps();
        });

        Schema::create('sfr__fsd__transit_files', function (Blueprint $table) {
            $table->id();

            $table->date('date_start')->index();
            $table->date('date_end')->index();

            $table->foreignId('file_id')->constrained(File::getTableName())
                ->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::create('sfr__fsd__transit_recipients', function (Blueprint $table) {
            $table->id();

            $table->string('SNILS');
            $table->date('date_start')->index();
            $table->date('date_end')->index();

            $table->foreignId('wp_category_id')->constrained(TransitCategory::getTableName());
            $table->foreignId('file_id')->constrained(TransitFile::getTableName())
                ->cascadeOnDelete();

            $table->timestamps();

            $table->index(['SNILS']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sfr__fsd__transit_recipients');
        Schema::dropIfExists('sfr__fsd__transit_files');
        Schema::dropIfExists('sfr__fsd__transit_equivalents');
        Schema::dropIfExists('sfr__fsd__transit_categories');
        Schema::dropIfExists('sfr__fsd__payments');
        Schema::dropIfExists('sfr__fsd__payment_files');
        Schema::dropIfExists('sfr__fsd__asp_payment_categories');
        Schema::dropIfExists('sfr__fsd__sfr_payment_categories');
        Schema::dropIfExists('sfr__fsd__result_files');
        Schema::dropIfExists('sfr__fsd__sfr_files');
    }
};
