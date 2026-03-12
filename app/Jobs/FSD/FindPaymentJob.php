<?php

namespace App\Jobs\FSD;

use App\Models\FSD\SFRFile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class FindPaymentJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public SFRFile $file) {}

    public function handle(): void
    {
        $recipients = $this->file->recipients;
        $paymentQuery = $this->file->payments();

        $recipients->each(function($recipient) use ($paymentQuery){
            $paymentQuery->where('SNILS', $recipient->SNILS)->update(['recipient_id' => $recipient->id]);
        });
    }
}
