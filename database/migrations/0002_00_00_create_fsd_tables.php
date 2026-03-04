<?php

use App\Models\File;
use App\Models\FSD\Recipient;
use App\Models\FSD\RecipientStatus;
use App\Models\FSD\SFRFile;
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

        Schema::create('fsd__recipient_statuses', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->string('name');

            $table->timestamps();
        });

        Schema::create('fsd__recipients', function (Blueprint $table) {
            $table->id();

            $table->string('division_code');
            $table->string('first_name');
            $table->string('last_name')->default('');
            $table->string('middle_name')->default('');
            $table->string('SNILS');

            $table->foreignId('file_id')->constrained(SFRFile::getTableName());
            $table->foreignId('status_id')->constrained(RecipientStatus::getTableName());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fsd__recipients');
        Schema::dropIfExists('fsd__recipient_statuses');
        Schema::dropIfExists('fsd__sfr_files');
    }
};
