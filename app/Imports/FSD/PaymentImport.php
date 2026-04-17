<?php

namespace App\Imports\FSD;

use App\Models\FSD\Payment;
use App\Models\FSD\PaymentFile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class PaymentImport implements ShouldQueue, ToModel, WithBatchInserts, WithChunkReading
{
    use Importable;

    public function __construct(public PaymentFile $paymentFile) {}

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 3000;
    }

    public function model(array $row)
    {
        return new Payment([
            'amount'        => $row[4],
            'SNILS'         => $row[5],
            'file_id'       => $this->paymentFile->id
        ]);
    }
}
