<?php

namespace App\Jobs\Payment;

use App\Models\Payment\PaymentFile;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Bus;

class ReadpaymentFileJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 300;

    const CHUNK_SIZE = 1000;

    public function __construct(public PaymentFile $paymentFile)
    {
        $this->onQueue('Payment');
    }

    public function handle(): void
    {
        waitDisabledFile($this->paymentFile);
        $this->paymentFile->setStatus('reading');
        $this->paymentFile->setDisabled();
        $this->paymentFile = $this->paymentFile->fresh();

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
                if (preg_match("/^[0-9];[а-яА-Я ].*$/", clearString(mb_convert_encoding($line, 'UTF-8', 'CP-866'))) === 0) {
                    $this->paymentFile->addError('Неверная кодировка файла (ошибка первой строки)');
                    break;
                } else {
                    $isFirstLine = false;
                }
            }

            $count++;

            $lines[] = mb_convert_encoding($line, 'UTF-8', 'CP-866');

            if ($count >= $this::CHUNK_SIZE) {
                $jobs[] = new ReadPaymentFileChunkJob($this->paymentFile, $lines);

                $count = 0;
                $lines = [];
            }
        }

        $jobs[] = new ReadPaymentFileChunkJob($this->paymentFile, $lines);

        $file = $this->paymentFile->fresh();
        Bus::batch($jobs)->then(function (Batch $batch) use ($file) {
            $file->setStatus('ok');
            $file->setDisabled(false);
        })
            ->onQueue('Payment')
            ->dispatch();
    }
}
