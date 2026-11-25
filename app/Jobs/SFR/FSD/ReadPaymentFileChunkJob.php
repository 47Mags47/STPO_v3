<?php

namespace App\Jobs\SFR\FSD;

use App\Models\Administrate\FinancingType;
use App\Models\SFR\FSD\ASPPaymentCategory;
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

    public $ROW_KEYS = [];
    public Collection $ASPPaymentCategories;
    public Collection $financingTypes;

    const CSV_SEPARATOR = ';';

    public function __construct(
        public PaymentFile $paymentFile,
        public array $lines
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

        $this->ASPPaymentCategories = ASPPaymentCategory::get(['id', 'name'])->groupBy('name')->map(fn($value) => $value[0]);
        $this->financingTypes = FinancingType::get(['id', 'asp_name'])->groupBy('asp_name')->map(fn($value) => $value[0]);
    }

    public function handle(): void
    {
        $errors = [];
        $batches = [];
        foreach ($this->lines as $line) {
            // Если строка заканчивается на ;, то удаляем его
            $line = rtrim($line, ';');

            $row = str_getcsv($line, self::CSV_SEPARATOR);

            $check_errors = $this->checkRow($row, $line);
            if (count($check_errors) > 0) {
                $errors = array_merge($errors, $check_errors);
                continue;
            }

            $data = [
                'last_name'                 => $row[$this->ROW_KEYS['LAST_NAME']['row_number']],
                'first_name'                => $row[$this->ROW_KEYS['FIRST_NAME']['row_number']],
                'SNILS'                     => $row[$this->ROW_KEYS['SNILS']['row_number']],
                'amount'                    => $row[$this->ROW_KEYS['AMOUNT']['row_number']],
                'file_in_date'              => $this->paymentFile->in_date,

                'asp_payment_category_id'   => $this->ASPPaymentCategories[$row[$this->ROW_KEYS['ASP_CATEGORY']['row_number']]]->id,
                'financing_type_id'         => $this->financingTypes[$row[$this->ROW_KEYS['FINANCING_TYPE']['row_number']]]->id,
            ];

            $data['hash'] = hash('sha256', implode('|', $data));
            $data['file_id'] = $this->paymentFile->id;
            $data['line'] = $line;

            $batches[$data['hash']] = $data;
        }

        // Проверяем, есть ли дубликаты
        $hashes = collect($batches)->pluck('hash');
        $duplicate_hashes = Payment::whereIn('hash', $hashes)->pluck('hash');

        foreach ($duplicate_hashes as $hash) {
            $errors[] = 'Попытка вставить дубликат записи: ' . $batches[$hash]['line'];
            Log::driver('check')->info('Попытка вставить дубликат записи', [
                'line' => $batches[$hash]['line'],
                'in_date' => $batches[$hash]['file_in_date']->format('Y-m-d'),
                'payment_file_id' => $this->paymentFile->id,
                'file_name' => $this->paymentFile->origin_name,
            ]);
            // unset($batches[$hash]);
        }
        if (count($errors) > 0)
            $this->paymentFile->addErrors($errors);

        $batches = array_map(function ($batch) {
            unset($batch['line']);
            return $batch;
        }, $batches);

        Payment::insertOrIgnore(array_values($batches));
    }

    public function checkRow(array $row, string $line): array
    {
        $errors = [];

        if (count($row) != count($this->ROW_KEYS)) {
            $errors[] = 'Неверное количество полей в строке: ' . $line;
            return $errors;
        }

        // Проверка полей
        foreach ($this->ROW_KEYS as $key) {
            if (!preg_match('/^' . $key['pattern'] . '$/u', $row[$key['row_number']]))
                $errors[] = 'Поле "' . $key['name'] . '" не соответсвует формату в строке: ' . $line;
        }

        // Проверка категории АСП
        $ASPCategoryRow = $row[$this->ROW_KEYS['ASP_CATEGORY']['row_number']];
        if (!$this->ASPPaymentCategories->has($ASPCategoryRow) or mb_strlen(trim($row[$this->ROW_KEYS['ASP_CATEGORY']['row_number']])) === 0)
            $errors[] = 'Не найдена категория выплаты "' . $ASPCategoryRow . '" в строке: ' . $line;

        // Проверка источника финансирования
        $financingTypeRow = $row[$this->ROW_KEYS['FINANCING_TYPE']['row_number']];
        if (!$this->financingTypes->has($financingTypeRow) or mb_strlen(trim($row[$this->ROW_KEYS['FINANCING_TYPE']['row_number']])) === 0)
            $errors[] = 'Не найден источник финансирования "' . $financingTypeRow . '" в строке: ' . $line;

        return $errors;
    }
}
