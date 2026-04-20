<?php

namespace App\Jobs\FSD;

use App\Imports\FSD\PaymentImport;
use App\Models\FSD\PaymentFile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ReadPaymentFileJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public PaymentFile $paymentFile) {}

    public function handle(): void
    {
        Log::info('Загрузка файла: ' . $this->paymentFile->file->origin_name);

        (new PaymentImport($this->paymentFile))
            ->import($this->paymentFile->getLocalPath(), $this->paymentFile->file->disk, \Maatwebsite\Excel\Excel::CSV)
            ->onQueue('SFR-FSD-ReadPaymentFile')
            ->allOnQueue('SFR-FSD-ReadPaymentFile');
    }
}
