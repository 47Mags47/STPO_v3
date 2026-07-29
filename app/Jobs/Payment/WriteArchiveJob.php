<?php

namespace App\Jobs\Payment;

use App\Models\Administrate\Bank;
use App\Models\Base\File;
use App\Models\Payment\Archive;
use App\Models\Payment\BankRaport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use ZipArchive;

class WriteArchiveJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 300;

    public function __construct(public Archive $archive) {
        $this->onQueue('Payment');
    }

    public function handle(): void
    {
        $this->archive->setDisabled();
        $this->archive = $this->archive->fresh();

        $bank_ids = $this->archive->event->paymentFiles()->get('bank_id')->pluck('bank_id')->unique();
        $banks = Bank::whereIn('id', $bank_ids)->get();

        $zip = new ZipArchive();
        $zip->open($this->archive->getFullPath(), ZipArchive::CREATE);

        foreach ($banks as $bank) {
            $raport = File::createChildren(BankRaport::class, [
                'bank_id' => $bank->id,
                'event_id' => $this->archive->event_id,
                'origin_name' => $bank->name . '.zip',
            ]);

            $writer = new ($bank->payment_template->writer)($raport);
            $writer->write();

            $zip->addFile($raport->getFullPath(), $raport->origin_name);
        }

        $zip->close();

        $this->archive->setStatus('ok');
        $this->archive->setDisabled(false);
    }
}
