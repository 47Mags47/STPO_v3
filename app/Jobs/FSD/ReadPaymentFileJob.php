<?php

namespace App\Jobs\FSD;

use App\Imports\FSD\PaymentImport;
use App\Models\FSD\PaymentFile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ReadPaymentFileJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public PaymentFile $paymentFile) {}

    public function handle(): void
    {
        (new PaymentImport($this->paymentFile))->import($this->paymentFile->getLocalPath(), $this->paymentFile->file->disk, \Maatwebsite\Excel\Excel::CSV);
    }
}
