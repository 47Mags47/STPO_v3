<?php

namespace App\Jobs\SFR\FSD;

use App\Models\SFR\FSD\TransitFile;
use App\Models\SFR\FSD\TransitRecipient;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ReadTransitFileChunkJob implements ShouldQueue
{
    use Queueable, Batchable;

    public $timeout = 300;

    const CSV_SEPARATOR = ';';

    public function __construct(public TransitFile $transitFile, public array $lines)
    {
        $this->onQueue('SFR-FSD');
    }

    public function handle(): void
    {
        foreach ($this->lines as $line) {
            if (strlen(trim($line)) == 0)
                continue;

            if (!$this->checkValidLine($line))
                continue;

            $row = str_getcsv($line, self::CSV_SEPARATOR);

            $snils = str_pad($row[0], 11, '0', STR_PAD_LEFT);

            try {
                TransitRecipient::updateOrCreate(
                    [
                        'SNILS'             => $snils[0] . $snils[1] . $snils[2] . '-' . $snils[3] . $snils[4] . $snils[5] . '-' . $snils[6] . $snils[7] . $snils[8] . ' ' . $snils[9] . $snils[10],
                        'date_start'        => Carbon::createFromTimestamp($row[1] + 8 * 60 * 60, config('app.timezone', null))->startOfDay(),
                        'date_end'          => Carbon::createFromTimestamp($row[2] + 8 * 60 * 60, config('app.timezone', null))->startOfDay(),
                    ],
                    [
                        'wp_category_id'    => $row[3],
                        'file_id'           => $this->transitFile->id,
                    ]
                );
            } catch (\Throwable $th) {
                Log::error($th);
            }
        }
    }

    public function checkValidLine(string $line)
    {
        // Проверка паттерна строки
        $line_pattern = implode('\\' . self::CSV_SEPARATOR, [
            str_replace(['/', '\\'], '', PATTERNS('TIMESTAMP')),
            str_replace(['/', '\\'], '', PATTERNS('TIMESTAMP')),
            str_replace(['/', '\\'], '', PATTERNS('TIMESTAMP')),
            '[0-9]{1,2}'
        ]);

        if (!preg_match('/^' . $line_pattern . '/u', $line)) {
            $this->transitFile->addError('Строка "' . $line . '" не соответсвует формату');

            return false;
        }

        return true;
    }
}
