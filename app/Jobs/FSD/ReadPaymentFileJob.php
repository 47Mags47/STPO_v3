<?php

namespace App\Jobs\FSD;

use App\Models\FSD\PaymentFile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class ReadPaymentFileJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 300;

    const CHUNK_SIZE = 1000;

    public function __construct(public PaymentFile $paymentFile) {}

    public function handle(): void
    {
        Log::info('Загрузка файла: ' . $this->paymentFile->file->origin_name);

        $file = fopen($this->paymentFile->getFullPath(), 'r');

        $count = 0;
        $lines = [];
        $jobs = [];
        while (!feof($file)) {
            $line = fgets($file);

            if (strlen(trim($line)) == 0)
                continue;

            if(preg_match("/^[а-яА-Я].*$/", mb_convert_encoding($line, 'UTF-8', 'CP-866')) === 0){
                $this->paymentFile->addError('Неверная кодировка'. $line);

                continue;
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

        Bus::batch($jobs)
            ->onQueue('SFR-FSD-ReadPaymentFile')
            ->dispatch();
    }
}
