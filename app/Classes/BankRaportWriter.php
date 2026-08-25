<?php

namespace App\Classes;

use App\Models\Administrate\Bank;
use App\Models\Administrate\Template;
use App\Models\Base\File;
use App\Models\Payment\BankContract;
use App\Models\Payment\BankRaport;
use App\Models\Payment\BankRaportFile;
use App\Models\Payment\Event;
use App\Models\Payment\Recipient;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\LazyCollection;
use ZipArchive;

class BankRaportWriter extends FileWriter
{
    protected ?int $delimiter = null;

    protected BankRaport $raport;
    protected Bank $bank;
    protected BankContract $contract;
    protected Event $event;
    protected Template $template;
    protected array $data = [];
    protected array $files = [];
    protected int $npp;

    protected LazyCollection|Collection $recipientChunks;

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

        $this->bank         = $this->raport->bank;
        $this->contract     = $this->raport->bank->payment_contract;
        $this->event        = $this->raport->event;
        $this->template     = $this->raport->bank->payment_template;

        $this->npp = $this->getFileNPP();

        $this->recipientChunks = Recipient::query()
            ->whereHas(
                'paymentFile',
                fn($paymentFileQuery) =>
                $paymentFileQuery
                    ->where('bank_id', $this->bank->id)
                    ->where('event_id', $this->event->id)
            )
            ->lazy(1000);

        $this->recipientChunks = $this->delimiter !== null
            ? $this->recipientChunks->chunk($this->delimiter)
            : collect([$this->recipientChunks]);

        $this->data = [
            'bank'          => $this->bank,
            'contract'      => $this->contract,
            'event'         => $this->event,
            'division_name' => "ГОСУДАРСТВЕННОЕ КАЗЕННОЕ УЧРЕЖДЕНИЕ \"ЦЕНТР СОЦИАЛЬНЫХ ВЫПЛАТ И ИНФОРМАТИЗАЦИИ МИНИСТЕРСТВА СОЦИАЛЬНОЙ ЗАЩИТЫ НАСЕЛЕНИЯ КУЗБАССА\""
        ];
    }

    public function getFileNPP(): int
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

        foreach ($this->recipientChunks as $in_raport_npp => $recipients) {
            $file = File::createChildren(BankRaportFile::class, [
                'raport_id'     => $this->raport->id,
                'npp'           => $this->npp,
                'origin_name'   => $this->getFileName($in_raport_npp + 1)
            ]);
            $this->files[] = $file;

            $data = array_merge($this->data, [
                'recipients'    => $recipients,
                'npp'           => $file->npp
            ]);

            $template_content = $this->template->getContent();
            $file_content = Blade::render($template_content, $data);
            $file_content = mb_convert_encoding($file_content, $this->encoding, 'UTF-8');
            $file->write($file_content);
        }

        // HACK прописать в job генерацию файла. по завершению пихать в архив
        // HACK добавить удаление временных файлов после операции

        foreach ($this->files as $file) {
            $zip->addFile($file->getFullPath(), $file->origin_name);
        }

        $flag = $zip->close();

        return $flag;
    }

    public function getFileName(int $in_raport_npp): string {
        return $this->fileName . '_' . $in_raport_npp;
    }
}
