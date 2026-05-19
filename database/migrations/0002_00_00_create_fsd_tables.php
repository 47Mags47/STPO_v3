<?php

use App\Models\Base\File;
use App\Models\FSD\PaymentFile;
use App\Models\FSD\PaymentType;
use App\Models\FSD\TransitCategory;
use App\Models\FSD\TransitFile;
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
        Schema::create('fsd__sfr_files', function (Blueprint $table) {
            $table->id();

            $table->date('in_date');
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();

            $table->foreignId('file_id')->constrained(File::getTableName());

            $table->timestamps();
        });

        Schema::create('fsd__sfr_file_results', function (Blueprint $table) {
            $table->id();

            $table->foreignId('file_id')->constrained(File::getTableName())->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('fsd__payment_types', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('pay_code');
            $table->string('pay_number');
        });

        Schema::create('fsd__payment_files', function (Blueprint $table) {
            $table->id();

            $table->date('in_month');

            $table->foreignId('file_id')->constrained(File::getTableName());
            $table->foreignId('type_id')->constrained(PaymentType::getTableName());

            $table->timestamps();
        });

        Schema::create('fsd__payments', function (Blueprint $table) {
            $table->id();

            $table->decimal('amount', 8, 2)->nullable()->default(null);
            $table->string('SNILS')->nullable()->default(null);

            $table->string('first_name')->nullable()->default(null);
            $table->string('last_name')->nullable()->default(null);
            $table->string('middle_name')->nullable()->default(null);

            $table->foreignId('file_id')->constrained(PaymentFile::getTableName())->onDelete('cascade');

            $table->index(['file_id', 'SNILS', 'amount']);
        });

        Schema::create('fsd__transit_categories', function (Blueprint $table) {
            $table->id();

            $table->integer('wp_category_id')->nullable();
            $table->string('name');

            $table->timestamps();
        });

        Schema::create('fsd__transit_equivalents', function (Blueprint $table) {
            $table->id();

            $table->decimal('equivalent', 8, 2);
            $table->date('date_start')->index();
            $table->date('date_end')->nullable()->index();

            $table->foreignId('category_id')->constrained(TransitCategory::getTableName());

            $table->timestamps();
        });

        Schema::create('fsd__transit_files', function (Blueprint $table) {
            $table->id();

            $table->foreignId('file_id')->constrained(File::getTableName());
            $table->date('date_start')->index();
            $table->date('date_end')->index();

            $table->timestamps();
        });

        Schema::create('fsd__transit_recipients', function (Blueprint $table) {
            $table->id();

            $table->string('SNILS');
            $table->date('date_start')->index();
            $table->date('date_end')->index();

            $table->foreignId('wp_category_id')->default(1)->constrained(TransitCategory::getTableName());
            $table->foreignId('file_id')->constrained(TransitFile::getTableName())->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fsd__transit_equivalents');
        Schema::dropIfExists('fsd__transit_categories');
        Schema::dropIfExists('fsd__payments');
        Schema::dropIfExists('fsd__payment_files');
        Schema::dropIfExists('fsd__recipients');
        Schema::dropIfExists('fsd__recipient_statuses');
        Schema::dropIfExists('fsd__sfr_files');
    }
};
