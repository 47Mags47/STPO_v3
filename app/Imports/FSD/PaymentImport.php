<?php

namespace App\Imports\FSD;

use App\Models\FSD\Payment;
use App\Models\FSD\PaymentFile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;
use Maatwebsite\Excel\Events\AfterBatch;
use Maatwebsite\Excel\Events\AfterChunk;
use Maatwebsite\Excel\Events\AfterImport;

class PaymentImport implements ShouldQueue, ToModel, WithBatchInserts, WithChunkReading, WithSkipDuplicates, WithEvents
{
    use Importable;

    public function __construct(public PaymentFile $paymentFile) {}

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function model(array $row)
    {
        return new Payment([
            'amount'        => $row[4],
            'SNILS'         => $row[5],
            'file_id'       => $this->paymentFile->id
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterBatch::class => function (AfterBatch $event) {
                $this->paymentFile->SFRFile->recipients->each(function ($recipient) {
                    $this->paymentFile
                        ->payments()
                        ->where('SNILS', $recipient->SNILS)
                        ->update(['recipient_id' => $recipient->id]);
                });
            },

        ];
    }
}
