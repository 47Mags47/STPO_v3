<?php

namespace App\Jobs\Payment;

use App\Models\Payment\BankRaport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class WriteBankRaportJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 300;

    public function __construct(public BankRaport $raport)
    {
        $this->onQueue('Payment');
    }

    public function handle(): void
    {
        $this->raport->setDisabled();
        $this->raport = $this->raport->fresh();

        $writer = new ($this->raport->bank->payment_template->writer)($this->raport);
        $writer->write();

        $this->raport->setStatus('ok');
        $this->raport->setDisabled(false);
    }
}
