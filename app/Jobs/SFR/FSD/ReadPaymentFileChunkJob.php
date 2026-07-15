<?php

namespace App\Jobs\SFR\FSD;

use App\Models\SFR\FSD\Payment;
use App\Models\SFR\FSD\PaymentFile;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ReadPaymentFileChunkJob implements ShouldQueue
{
    use Queueable, Batchable;

    public $timeout = 300;
    public $ROW_KEYS = [];
    const CSV_SEPARATOR = ';';

    public function __construct(
        public PaymentFile $paymentFile,
        public array $lines,
        public Collection $ASPPaymentCategories,
        public Collection $financingTypes
    ) {
        $this->onQueue('SFR-FSD');

        $this->ROW_KEYS = [
            'LAST_NAME'         => [
                'row_number' => 0,
                'pattern'       => PATTERNS('LAST_NAME'),
                'name'          => 'Фамилия',
            ],
            'FIRST_NAME'        => [
                'row_number' => 1,
                'pattern'       => PATTERNS('FIRST_NAME'),
                'name'          => 'Имя',
            ],
            'MIDDLE_NAME'       => [
                'row_number' => 2,
                'pattern'       => PATTERNS('MIDDLE_NAME'),
                'name'          => 'Отчество',
            ],
            'DATE_ROJD'         => [
                'row_number' => 3,
                'pattern'       => PATTERNS('DOT_DATE'),
                'name'          => 'Дата рождения',
            ],
            'SNILS'             => [
                'row_number' => 4,
                'pattern'       => PATTERNS('SNILS'),
                'name'          => 'СНИЛС',
            ],
            'AMOUNT'            => [
                'row_number' => 5,
                'pattern'       => PATTERNS('FLOAT'),
                'name'          => 'Сумма',
            ],
            'ASP_CATEGORY'      => [
                'row_number' => 6,
                'pattern'       => '.*',
                'name'          => 'Выплата',
            ],
            'FINANCING_TYPE'    => [
                'row_number' => 7,
                'pattern'       => '.*',
                'name'          => 'Тип финансирования',
            ],
        ];
    }

    public function handle(): void
    {
        foreach ($this->lines as $line) {
            if (strlen(trim($line)) == 0)
                continue;

            if (!$this->checkValidLine($line))
                continue;

            $row = str_getcsv($line, self::CSV_SEPARATOR);

            Payment::create([
                'last_name'                 => $row[$this->ROW_KEYS['LAST_NAME']['row_number']],
                'first_name'                => $row[$this->ROW_KEYS['FIRST_NAME']['row_number']],
                'middle_name'               => $row[$this->ROW_KEYS['MIDDLE_NAME']['row_number']],
                'SNILS'                     => $row[$this->ROW_KEYS['SNILS']['row_number']],
                'amount'                    => $row[$this->ROW_KEYS['AMOUNT']['row_number']],

                'asp_payment_category_id'   => $this->ASPPaymentCategories[$row[$this->ROW_KEYS['ASP_CATEGORY']['row_number']]]->id,
                'financing_type_id'         => $this->financingTypes[$row[$this->ROW_KEYS['FINANCING_TYPE']['row_number']]]->id,
                'file_id'                   => $this->paymentFile->id,
            ]);
        }
    }

    public function checkValidLine(string $line)
    {
        $row = str_getcsv($line, self::CSV_SEPARATOR);
        $flag = true;

        foreach ($this->ROW_KEYS as $key) {
            if (!preg_match('/' . $key['pattern'] . '/', $line)) {
                Log::driver('check')->info('Строка "'. clearString($row[$key['row_number']]) .'" не соответсвует паттерну '. $key['pattern']);
                $this->paymentFile->addError('Поле "'. $key['name'] .'" не соответсвует формату в cтроке ' . clearString($row[$key['row_number']]));

                $flag = false;
            }
        }

        // Проверка категории в АСП
        $ASPCategoryRow = $row[$this->ROW_KEYS['ASP_CATEGORY']['row_number']];
        if(!$this->ASPPaymentCategories->has($ASPCategoryRow)){
            Log::driver('check')->info('Не найдена категория выплаты "' . $ASPCategoryRow . '"');
            $this->paymentFile->addError('Не найдена категория выплаты "' . $ASPCategoryRow . '"');

            $flag = false;
        }

        // Проверка источника финансирования
        $financingTypeRow = $row[$this->ROW_KEYS['FINANCING_TYPE']['row_number']];
        if(!$this->financingTypes->has($financingTypeRow)){
            Log::driver('check')->info('Не найден источник финансирования "' . $financingTypeRow . '"');
            $this->paymentFile->addError('Не найден источник финансирования "' . $financingTypeRow . '"');

            $flag = false;
        }

        return $flag;
    }
}
