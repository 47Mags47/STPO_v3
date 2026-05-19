<?php

namespace App\Jobs\FSD;

use App\Models\FSD\TransitFile;
use App\Models\FSD\TransitRecipient;
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

    public function __construct(public TransitFile $transitFile, public array $lines) {
        $this->onQueue('SFR-FSD-ReadTransitFile');
    }

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

            $snils = str_pad($row[0], 11, '0', STR_PAD_LEFT);

            TransitRecipient::create([
                'SNILS'             => $snils[0] . $snils[1] . $snils[2] . '-' . $snils[3] . $snils[4] . $snils[5] . '-' . $snils[6] . $snils[7] . $snils[8] . ' ' . $snils[9] . $snils[10],
                'date_start'        => Carbon::createFromTimestamp($row[1] + 8 * 60 * 60, config('app.timezone', null)),
                'date_end'          => Carbon::createFromTimestamp($row[2] + 8 * 60 * 60, config('app.timezone', null)),
                'wp_category_id'    => $row[3],
                'file_id'           => $this->transitFile->id,
            ]);
        }

        if (count($validationErrors) > 1) {
            Log::error(
                "\nПри чтении файла: " .
                    $this->transitFile->file->origin_name .
                    ' пропущены строки (ошибка валидации):'
            );

            foreach ($validationErrors as $line) {
                Log::error('"' . str_replace(["\r", "\r\n", "\n"], '', $line) . '"');
            }
        }
    }

    public function checkValidLine(string $line)
    {
        return true;
    }
}
