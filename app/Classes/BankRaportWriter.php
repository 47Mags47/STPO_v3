<?php

namespace App\Classes;

use App\Models\Administrate\Bank;
use App\Models\Administrate\Template;
use App\Models\Base\File;
use App\Models\Payment\BankContract;
use App\Models\Payment\Event;
use App\Models\Payment\PaymentFile;
use App\Models\Payment\BankRaport;
use App\Models\Payment\BankRaportFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use ZipArchive;

class BankRaportWriter extends Writer
{
    protected ?int $delimiter = null;
    protected ?string $encoding = 'UTF-8';

    protected BankRaport $raport;

    protected Bank $bank;
    protected BankContract $contract;

    protected Event $event;
    protected Template $template;

    protected Collection $recipients;
    protected Collection $files;

    public function __construct(BankRaport $raport)
    {
        parent::__construct();

        $this->raport = BankRaport::whereKey($raport)
            ->with([
                'bank',
                'bank.payment_template',
                'bank.payment_contract',
                'event'
            ])
            ->get()
            ->first();

        $this->bank = $this->raport->bank;
        $this->contract = $this->raport->bank->payment_contract;
        $this->event = $this->raport->event;
        $this->template = $this->raport->bank->payment_template;

        $this->recipients = PaymentFile::query()
            ->where('bank_id', $this->raport->bank_id)
            ->where('event_id', $this->raport->event_id)
            ->with('recipients')
            ->get()
            ->map(fn($file) => $file->recipients)
            ->collapse()
            ->chunk($this->delimiter ?? 999999, false);

        $files = [];
        $npp = $this->fileNPP();
        foreach ($this->recipients as $recipients) {
            $file = File::createChildren(BankRaportFile::class, [
                'raport_id'     => $this->raport->id,
                'npp'           => $npp,
                'origin_name'   => $this->fileName($npp),
            ]);
            $files[] = $file;
            $file->write(Blade::render($this->template->getContent(), $this->fileData($recipients)), $this->encoding);
            $npp++;
        }

        $this->files = collect($files);
    }

    public function fileNPP(): int
    {
        return BankRaportFile::query()
            ->whereHas('raport', fn($query) => $query->where('bank_id', $this->bank->id)->where('event_id', $this->event->id))
            ->whereHas('raport.event', fn($query) => $query->whereBetween('in_day', [$this->event->in_day->startOfYear(), $this->event->in_day->endOfYear()]))
            ->max('npp') + 1;
    }

    public function write(): bool
    {
        $zip = new ZipArchive();
        $zip->open($this->raport->getFullPath(), ZipArchive::CREATE);

        foreach ($this->files as $file) {
            $zip->addFile($file->getFullPath(), $file->origin_name);
        }

        $flag = $zip->close();

        foreach ($this->files as $file) {
            $file->delete();
        }

        return $flag;
    }

    public function fileName(int $npp): string
    {
        return $this->generateFileName();
    }

    public function fileData(Collection $recipients): array
    {
        return [];
    }
}
