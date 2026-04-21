<?php

use App\Models\Base\File;
use App\Models\FSD\PaymentFile;
use App\Models\FSD\PaymentType;
use App\Models\FSD\SFRFile;
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

            $table->string('region_code', 3)->comment('Код региона из классификатора территориальных органов СФР');
            $table->integer('sign_code')->comment("Признак вида представления информации \n0 – полный региональный сегмент Федерального регистра; \n1 – данные об изменениях в региональном сегменте Федерального регистра; \n2 – запрос на граждан, имеющих право на получение социальной доплаты к пенсии; \n3 – ответ на граждан, имеющих право на получение социальной доплаты к пенсии)");
            $table->date('in_date')->comment('Дата формирования файла');
            $table->integer('npp_for_month')->comment('Порядковый номер представления информации в указанном месяце');

            $table->foreignId('file_id')->constrained(File::getTableName());

            $table->timestamps();
        });

        Schema::create('fsd__sfr_file_results', function (Blueprint $table) {
            $table->id();

            $table->foreignId('file_id')->constrained(File::getTableName());

            $table->timestamps();
        });

        Schema::create('fsd__recipients', function (Blueprint $table) {
            $table->id();

            $table->string('SNILS');
            $table->date('birth');

            $table->date('date_start');
            $table->date('date_end');

            $table->foreignId('file_id')->constrained(SFRFile::getTableName());
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

            $table->decimal('amount', 8, 2);
            $table->string('SNILS');

            $table->foreignId('file_id')->constrained(PaymentFile::getTableName());
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
            $table->foreignId('file_id')->constrained(TransitFile::getTableName());

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
