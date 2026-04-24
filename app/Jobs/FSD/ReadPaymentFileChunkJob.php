<?php

namespace App\Jobs\FSD;

use App\Models\FSD\Payment;
use App\Models\FSD\PaymentFile;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ReadPaymentFileChunkJob implements ShouldQueue
{
    use Queueable, Batchable;

    const LAST_NAME_PATTERN         = "/[а-яА-Я ]*/";
    const FIRST_NAME_PATTERN        = "/[а-яА-Я ]*/";
    const MIDDLE_NAME_PATTERN       = "/[а-яА-Я ]*/";
    const DATE_PATTERN              = "/[0-9]{2}\.[0-9]{2}\.[0-9]{4}/";
    const SNILS_PATTERN             = "/[0-9]{3}-[0-9]{3}-[0-9]{3} [0-9]{2}/";
    const AMOUNT_PATTERN            = "/[0-9]{1,6}\.[0-9]{2}/";

    const CSV_SEPARATOR             = ';';

    public function __construct(public PaymentFile $paymentFile, public array $lines) {}

    public function handle(): void
    {
        foreach ($this->lines as $line) {
            if (!$this->checkValidLine($line))
                continue;

            $row = str_getcsv($line, self::CSV_SEPARATOR);

            Payment::create([
                'SNILS'             => $row[5],
                'amount'            => $row[4],
                'file_id'           => $this->paymentFile->id,
            ]);
        }
    }

    public function checkValidLine(string $line)
    {
        $line_pattern = implode(self::CSV_SEPARATOR, [
            str_replace(['/', '\\'], '', self::LAST_NAME_PATTERN),
            str_replace(['/', '\\'], '', self::FIRST_NAME_PATTERN),
            str_replace(['/', '\\'], '', self::MIDDLE_NAME_PATTERN),
            str_replace(['/', '\\'], '', self::DATE_PATTERN),
            str_replace(['/', '\\'], '', self::AMOUNT_PATTERN),
            str_replace(['/', '\\'], '', self::SNILS_PATTERN),
        ]);

        if (!preg_match('/' . $line_pattern . '/', $line))
            return false;

        return true;
    }
}
