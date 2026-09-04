<?php

namespace App\Jobs\Payment;

use App\Models\Payment\PaymentFile;
use App\Models\Payment\Recipient;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;
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
    ) {
        $this->onQueue('SFR-FSD');

        $this->ROW_KEYS = [
            'LAST_NAME'         => [
                'row_number' => 1,
                'pattern'       => PATTERNS('LAST_NAME'),
                'name'          => 'Фамилия',
            ],
            'FIRST_NAME'        => [
                'row_number' => 2,
                'pattern'       => PATTERNS('FIRST_NAME'),
                'name'          => 'Имя',
            ],
            'MIDDLE_NAME'       => [
                'row_number' => 3,
                'pattern'       => PATTERNS('MIDDLE_NAME'),
                'name'          => 'Отчество',
            ],
            'DATE_ROJD'         => [
                'row_number' => 4,
                'pattern'       => PATTERNS('DOT_DATE'),
                'name'          => 'Дата рождения',
            ],
            'SNILS'             => [
                'row_number' => 5,
                'pattern'       => PATTERNS('SNILS'),
                'name'          => 'СНИЛС',
            ],
            'ACCOUNT'             => [
                'row_number' => 6,
                'pattern'       => PATTERNS('ACCOUNT'),
                'name'          => 'Счет',
            ],
            'AMOUNT'            => [
                'row_number' => 7,
                'pattern'       => PATTERNS('FLOAT'),
                'name'          => 'Сумма',
            ],

            'P_SERIES'            => [
                'row_number' => 8,
                'pattern'       => "[0-9]{4}",
                'name'          => 'Паспорт серия',
            ],
            'P_NUMBER'            => [
                'row_number' => 9,
                'pattern'       => "[0-9]{6}",
                'name'          => 'Паспорт номер',
            ],
            'P_DATE'            => [
                'row_number' => 10,
                'pattern'       => PATTERNS('DOT_DATE'),
                'name'          => 'Паспорт дата выдачи',
            ],
            'P_DIV'            => [
                'row_number' => 11,
                'pattern'       => "[а-яА-ЯёЁ0-9 -\.\,]{0,255}",
                'name'          => 'Паспорт дата выдачи',
            ],
        ];
    }

    public function handle(): void
    {
        foreach ($this->lines as $line) {
            if (strlen(trim($line)) == 0)
                continue;

            $row = str_getcsv($line, self::CSV_SEPARATOR);

            if (!$this->checkValidLine($row))
                continue;

            Recipient::create([
                'file_id'                   => $this->paymentFile->id,

                'last_name'                 => $row[$this->ROW_KEYS['LAST_NAME']['row_number']],
                'first_name'                => $row[$this->ROW_KEYS['FIRST_NAME']['row_number']],
                'middle_name'               => $row[$this->ROW_KEYS['MIDDLE_NAME']['row_number']],
                'd_rojd'                    => Carbon::make($row[$this->ROW_KEYS['DATE_ROJD']['row_number']]),
                'SNILS'                     => $row[$this->ROW_KEYS['SNILS']['row_number']],
                'account'                   => $row[$this->ROW_KEYS['ACCOUNT']['row_number']],
                'amount'                    => $row[$this->ROW_KEYS['AMOUNT']['row_number']],
                'p_series'                  => $row[$this->ROW_KEYS['P_SERIES']['row_number']],
                'p_number'                  => $row[$this->ROW_KEYS['P_NUMBER']['row_number']],
                'p_date'                    => Carbon::make($row[$this->ROW_KEYS['P_DATE']['row_number']]),
                'p_div'                     => $row[$this->ROW_KEYS['P_DIV']['row_number']],
            ]);
        }
    }

    public function checkValidLine(array $row) {
        $flag = true;

        foreach ($this->ROW_KEYS as $key) {
            if (!preg_match('/' . $key['pattern'] . '/', $row[$key['row_number']])) {
                Log::driver('check')->info('Строка "'. clearString($row[$key['row_number']]) .'" не соответсвует паттерну '. $key['pattern']);
                $this->paymentFile->addError('Поле "'. $key['name'] .'" не соответсвует формату в cтроке ' . clearString($row[$key['row_number']]));
                $flag = false;
            }
        }

        return $flag;
    }
}
