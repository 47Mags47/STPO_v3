<?php

namespace App\Jobs\FSD;

use App\Models\FSD\Payment;
use App\Models\FSD\PaymentFile;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ReadPaymentFileChunkJob implements ShouldQueue
{
    use Queueable, Batchable;

    public $timeout = 300;
    public $CSV_Separator = ';';

    public function __construct(
        public PaymentFile $paymentFile,
        public array $lines
    ) {
        $this->CSV_Separator = getCSVSeparator($lines[0]);
    }

    public function handle(): void
    {
        foreach ($this->lines as $line) {
            if (strlen(trim($line)) == 0)
                continue;

            if (!$this->checkValidLine($line))
                continue;

            $row = str_getcsv($line, $this->CSV_Separator);

            Payment::create([
                'last_name'         => $row[0],
                'first_name'        => $row[1],
                'middle_name'       => $row[2],
                'amount'            => $row[4],
                'SNILS'             => $row[5],
                'file_id'           => $this->paymentFile->id,
            ]);
        }
    }

    public function checkValidLine(string $line)
    {
        // Проверка строки
        $none_SILS_pattern = implode(PATTERNS('CSV_SEPARATOR'), [
            str_replace(['/'], '', PATTERNS('LAST_NAME')),
            str_replace(['/'], '', PATTERNS('FIRST_NAME')),
            str_replace(['/'], '', PATTERNS('MIDDLE_NAME')),
            str_replace(['/'], '', PATTERNS('DOT_DATE')),
            str_replace(['/'], '', PATTERNS('FLOAT')),
        ]) . '(?!' . PATTERNS('CSV_SEPARATOR') . '[0-9]{3}-[0-9]{3}-[0-9]{3} [0-9]{2})';

        if (preg_match('/^' . $none_SILS_pattern . '/u', $line)) {
            Log::driver('check')->info(clearString($line));

            $this->paymentFile->addError('Пропущен СНИЛС: "' . clearString($line) . '"');

            return false;
        }

        // Проверка паттерна строки
        $line_pattern = implode('\\' . $this->CSV_Separator, [
            str_replace(['/', '\\'], '', PATTERNS('LAST_NAME')),
            str_replace(['/', '\\'], '', PATTERNS('FIRST_NAME')),
            str_replace(['/', '\\'], '', PATTERNS('MIDDLE_NAME')),
            str_replace(['/', '\\'], '', PATTERNS('DOT_DATE')),
            str_replace(['/', '\\'], '', PATTERNS('FLOAT')),
            str_replace(['/', '\\'], '', PATTERNS('SNILS')),
        ]);

        if (!preg_match('/^' . $line_pattern . '/u', $line)) {
            $this->paymentFile->addError('Строка не соответсвует формату');

            return false;
        }

        return true;
    }
}
