<?php

namespace App\Jobs\Payment;

use App\Models\Payment\PaymentFile;
use App\Models\Payment\RaportToBank;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;

class WriteRaportToBankJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 300;

    private Collection $recipients;

    public function __construct(public RaportToBank $raport)
    {
        $this->onQueue('Payment');

        $this->recipients = PaymentFile::query()
            ->where('bank_id', $this->raport->bank->id)
            ->where('event_id', $this->raport->event->id)
            ->with('recipients')
            ->get()
            ->map(fn($file) => $file->recipients)
            ->collapse();
    }

    public function handle(): void
    {
        $this->raport->setStatus('creating');
        $this->raport->setDisabled();
        $this->raport = $this->raport->fresh();

        $this->raport->write(Blade::render($this->raport->bank->payment_template->getContent(), $this->generateFileData()));

        $this->raport->setStatus('ok');
        $this->raport->setDisabled(false);
    }

    public function getNPP()
    {
        return RaportToBank::query()
            ->where('bank_id', $this->raport->bank->id)
            ->whereBetween('created_at', [
                $this->raport->event->in_day->startOfYear()->format('Y-m-d'),
                $this->raport->event->in_day->endOfYear()->format('Y-m-d')
            ])
            ->count() + 1;
    }

    public function generateFileData()
    {
        return [
            'bank' => [
                'contract' => $this->raport->bank->payment_contract
            ],
            'event' => $this->raport->event,
            'recipients' => [
                'data' => $this->recipients,
                'meta' => [
                    'count' => $this->recipients->count(),
                    'summ' => $this->recipients->sum('amount')
                ],
            ],
            'file' => [
                'npp' => $this->getNPP()
            ],
        ];
    }
}
