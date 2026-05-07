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

    const CSV_SEPARATOR = ';';

    public function __construct(public PaymentFile $paymentFile, public array $lines) {}

    public function handle(): void
    {
        $validationErrors = [];
        foreach ($this->lines as $line) {
            if (strlen(trim($line)) == 0)
                continue;

            if (!$this->checkValidLine($line)) {
                $validationErrors[] = $line;
                continue;
            }

            $row = str_getcsv($line, self::CSV_SEPARATOR);

            Payment::create([
                'SNILS'             => $row[5],
                'amount'            => $row[4],
                'file_id'           => $this->paymentFile->id,
            ]);
        }

        if (count($validationErrors) > 1) {
            Log::error(
                "\nПри чтении файла: " .
                    $this->paymentFile->file->origin_name .
                    ' пропущены строки (ошибка валидации):'
            );

            foreach ($validationErrors as $line) {
                Log::error('"' . str_replace(["\r", "\r\n", "\n"], '', $line) . '"');
            }
        }
    }

    public function checkValidLine(string $line)
    {
        $line_pattern = implode('\\' . self::CSV_SEPARATOR, [
            str_replace(['/', '\\'], '', PATTERNS('LAST_NAME')),
            str_replace(['/', '\\'], '', PATTERNS('FIRST_NAME')),
            str_replace(['/', '\\'], '', PATTERNS('MIDDLE_NAME')),
            str_replace(['/', '\\'], '', PATTERNS('DOT_DATE')),
            str_replace(['/', '\\'], '', PATTERNS('FLOAT')),
            str_replace(['/', '\\'], '', PATTERNS('SNILS')),
        ]);

        if (!preg_match('/' . $line_pattern . '/u', $line)) {
            Log::driver('check')->info($line);
            return false;
        }


        return true;
    }
}
