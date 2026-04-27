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

    const LAST_NAME_PATTERN         = "/[а-яА-ЯёЁ -]{0,255}/";
    const FIRST_NAME_PATTERN        = "/[а-яА-ЯёЁ -]{1,255}/";
    const MIDDLE_NAME_PATTERN       = "/[а-яА-ЯёЁ -]{0,255}/";
    const DATE_PATTERN              = "/[0-9]{2}\.[0-9]{2}\.[0-9]{4}/";
    const SNILS_PATTERN             = "/[0-9]{3}-[0-9]{3}-[0-9]{3} [0-9]{2}/";
    const AMOUNT_PATTERN            = "/[0-9]{1,6}\.[0-9]{2}/";

    const CSV_SEPARATOR             = ';';

    public function __construct(public PaymentFile $paymentFile, public array $lines) {}

    public function handle(): void
    {
        $validationErrors = [];
        foreach ($this->lines as $line) {
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
                'При чтении файла: ' .
                    $this->paymentFile->file->origin_name .
                    " пропущены строки (ошибка валидации): \n"
            );

            foreach ($validationErrors as $line) {
                Log::error('"' . str_replace(['\r', '\r\n'], '', $line) . '"');
            }
        }

    }

    public function checkValidLine(string $line)
    {
        $line_pattern = implode('\\' . self::CSV_SEPARATOR, [
            str_replace(['/', '\\'], '', self::LAST_NAME_PATTERN),
            str_replace(['/', '\\'], '', self::FIRST_NAME_PATTERN),
            str_replace(['/', '\\'], '', self::MIDDLE_NAME_PATTERN),
            str_replace(['/', '\\'], '', self::DATE_PATTERN),
            str_replace(['/', '\\'], '', self::AMOUNT_PATTERN),
            str_replace(['/', '\\'], '', self::SNILS_PATTERN),
        ]);

        // Log::info((int) preg_match('/' . $line_pattern . '/u', $line));
        // Log::info('"' . $line_pattern . '"');
        // Log::info('"' . $line . '"');


        if (!preg_match('/' . $line_pattern . '/u', $line))
            return false;

        return true;
    }
}
