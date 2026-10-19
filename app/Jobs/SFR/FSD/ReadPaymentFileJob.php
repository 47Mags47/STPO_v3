<?php

namespace App\Jobs\SFR\FSD;

use App\Models\Administrate\FinancingType;
use App\Models\SFR\FSD\ASPPaymentCategory;
use App\Models\SFR\FSD\PaymentFile;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class ReadPaymentFileJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue;

    public $timeout = 999;

    const CHUNK_SIZE = 250;

    public function __construct(public PaymentFile $paymentFile)
    {
        $this->onQueue('SFR-FSD');
    }

    public function middleware(): array
    {
        return [
            (new WithoutOverlapping("file:" . $this->paymentFile->file_id))->shared()
        ];
    }

    public function handle(): void
    {
        waitDisabledFile($this->paymentFile);
        $this->paymentFile->setStatus('reading');
        $this->paymentFile->setDisabled();
        $this->paymentFile = $this->paymentFile->fresh();

        $ASPPaymentCategories = ASPPaymentCategory::get(['id', 'name'])->groupBy('name')->map(fn($value) => $value[0]);
        $financingTypes = FinancingType::get(['id', 'asp_name'])->groupBy('asp_name')->map(fn($value) => $value[0]);

        Log::driver('check')->info('Чтение файла: ' . $this->paymentFile->getLocalPath());

        $file = fopen($this->paymentFile->getFullPath(), 'r');

        $isFirstLine = true;
        $count = 0;
        $lines = [];
        $jobs = [];
        while (!feof($file)) {
            $line = fgets($file);

            if (strlen(trim($line)) == 0)
                continue;

            // Проверка кодировки документа
            if ($isFirstLine) {
                if (preg_match("/^[а-яА-Я ].*$/", clearString(mb_convert_encoding($line, 'UTF-8', 'CP-866'))) === 0) {
                    $this->paymentFile->addError('Неверная кодировка файла (ошибка первой строки)');
                    break;
                } else {
                    $isFirstLine = false;
                }
            }

            $count++;
            $lines[] = mb_convert_encoding($line, 'UTF-8', 'CP-866');

            if ($count >= $this::CHUNK_SIZE) {
                $jobs[] = new ReadPaymentFileChunkJob($this->paymentFile, $lines, $ASPPaymentCategories, $financingTypes);

                $count = 0;
                $lines = [];
            }
        }

        $jobs[] = new ReadPaymentFileChunkJob($this->paymentFile, $lines, $ASPPaymentCategories, $financingTypes);

        $file = $this->paymentFile->fresh();
        Bus::batch($jobs)
            ->then(function (Batch $batch) use ($file) {
                $file->setStatus('ok');
            })
            ->finally(function (Batch $batch) use ($file) {
                $file->setDisabled(false);
            })
            ->onQueue('SFR-FSD')
            ->dispatch();
    }
}
