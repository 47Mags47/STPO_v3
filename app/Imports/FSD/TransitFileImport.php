<?php

namespace App\Imports\FSD;

use App\Models\FSD\TransitFile;
use App\Models\FSD\TransitRecipient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;
class TransitFileImport implements ShouldQueue, ToModel, WithBatchInserts, WithChunkReading, WithSkipDuplicates
{
    use Importable;

    public function __construct(public TransitFile $transitFile) {}

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 10000;
    }

    public function model(array $row)
    {
        $snils = str_pad($row[0], 11, '0', STR_PAD_LEFT);

        return new TransitRecipient([
            'SNILS'             => $snils[0] . $snils[1] . $snils[2] . '-' . $snils[3] . $snils[4] . $snils[5] . '-' . $snils[6] . $snils[7] . $snils[8] . ' ' . $snils[9] . $snils[10],
            'date_start'        => Carbon::createFromTimestamp($row[1] + 8 * 60 * 60, config('app.timezone', null)),
            'date_end'          => Carbon::createFromTimestamp($row[2] + 8 * 60 * 60, config('app.timezone', null)),
            'wp_category_id'    => $row[3],
            'file_id'           => $this->transitFile->id
        ]);
    }
}
