<?php

use App\Models\File;
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

            $table->foreignId('file_id')->constrained(File::getTableName());

            $table->string('region_code', 3)->comment('Код региона из классификатора территориальных органов СФР');
            $table->integer('sign_code')->comment("Признак вида представления информации \n0 – полный региональный сегмент Федерального регистра; \n1 – данные об изменениях в региональном сегменте Федерального регистра; \n2 – запрос на граждан, имеющих право на получение социальной доплаты к пенсии; \n3 – ответ на граждан, имеющих право на получение социальной доплаты к пенсии)");
            $table->date('in_date')->comment('Дата формирования файла');
            $table->integer('npp_for_month')->comment('Порядковый номер представления информации в указанном месяце');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fsd__sfr_files');
    }
};
