<?php

namespace App\Classes;

use App\Models\Administrate\Bank;
use App\Models\Administrate\Law;
use App\Models\Administrate\Payment;
use App\Models\Administrate\Template;
use App\Models\Base\Config;
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
    protected string $template_type = 'blade';

    protected ?int $delimiter = null;

    protected BankRaport $raport;
    protected Bank $bank;
    protected BankContract $contract;
    protected Event $event;
    protected Payment $payment;
    protected Law $law;
    protected Template $template;
    protected array $data = [];
    protected array $files = [];
    protected int $npp;
    protected array $config = [];

    protected LazyCollection|Collection $recipientChunks;

    public function __construct(BankRaport $raport)
    {
        parent::__construct();

        $this->config = Config::array('payments');

        $this->raport = BankRaport::whereKey($raport)
            ->with([
                'bank',
                'bank.payment_template',
                'bank.payment_contract',
                'event',
                'event.payment',
                'event.payment.law'
            ])
            ->get()
            ->first();

        $this->bank         = $this->raport->bank;
        $this->contract     = $this->raport->bank->payment_contract;
        $this->event        = $this->raport->event;
        $this->payment      = $this->raport->event->payment;
        $this->law          = $this->raport->event->payment->law;
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
            'raport'        => $this->raport,
            'payment'       => $this->payment,
            'npp'           => $this->npp,
            'law'           => $this->law,
            'config'        => $this->config,
        ];
    }

    public function getFileNPP(): int
    {
        return BankRaportFile::query()
            ->whereHas('raport', fn($query) => $query->where('bank_id', $this->bank->id)->where('event_id', $this->event->id))
            ->whereHas('raport.event', fn($query) => $query->whereBetween('in_date', [$this->event->in_date->startOfYear(), $this->event->in_date->endOfYear()]))
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
                'npp'           => $file->npp,
            ]);

            $this->writeFileContent($file, $data);
        }

        // HACK прописать в job генерацию файла. по завершению пихать в архив
        // HACK добавить удаление временных файлов после операции

        foreach ($this->files as $file) {
            $zip->addFile($file->getFullPath(), $file->origin_name);
        }

        $flag = $zip->close();

        return $flag;
    }

    public function writeFileContent(FileModel $file, array $data): void
    {
        $file_content = 'empty';
        $template_content = $this->template->getContent();
        $file_content = Blade::render($template_content, $data, true);
        $file_content = $this->afterTemplateRender($file_content, $data);
        $file_content = mb_convert_encoding($file_content, $this->encoding, 'UTF-8');
        $file->write($file_content);
    }

    public function getFileName(int $in_raport_npp): string
    {
        // HACK сделать разбивку на имя файла и расширение
        return $this->fileName . '_' . $in_raport_npp;
    }

    public function afterTemplateRender(string $content, array $data): string
    {
        return $content;
    }
}
