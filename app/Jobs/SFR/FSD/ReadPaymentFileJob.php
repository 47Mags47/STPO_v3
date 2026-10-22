<?php

namespace App\Jobs\SFR\FSD;

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
        $this->paymentFile->setStatus('reading');
        $this->paymentFile->setDisabled();
        $this->paymentFile = $this->paymentFile->fresh();

        Log::driver('check')->info('Чтение файла: ' . $this->paymentFile->getLocalPath());


        $path = $this->paymentFile->getFullPath();

        if (!is_readable($path)) {
            Log::driver('check')->error('Файл недоступен для чтения: ' . $path);
            $this->paymentFile->addError('Файл недоступен для чтения');
            $this->paymentFile->setStatus('error');
            $this->paymentFile->setDisabled(false);
            return;
        }

        $file = @fopen($path, 'r');
        if ($file === false) {
            Log::driver('check')->error('Не удалось открыть файл: ' . $path);
            $this->paymentFile->addError('Не удалось открыть файл');
            $this->paymentFile->setStatus('error');
            $this->paymentFile->setDisabled(false);
            return;
        }


        $count = 0;
        $lines = [];
        $jobs = [];
        while (($line = fgets($file)) !== false) {
            if (trim($line) === '') {
                continue;
            }

            // Проверка кодировки документа
            $converted = @mb_convert_encoding($line, 'UTF-8', 'CP-866');
            if ($converted === false) {
                $this->paymentFile->addError('Ошибка конвертации: ' . $line);
                Log::driver('check')->error('Ошибка конвертации: ' . $line);
                continue;
            }
            $line = $converted;

            $lines[] = mb_convert_encoding($line, 'UTF-8', 'CP-866');
            $count++;

            if ($count >= $this::CHUNK_SIZE) {
                $jobs[] = new ReadPaymentFileChunkJob($this->paymentFile, $lines);

                $count = 0;
                $lines = [];
            }
        }

        fclose($file);

        if (!empty($lines))
            $jobs[] = new ReadPaymentFileChunkJob($this->paymentFile, $lines);

        $file = $this->paymentFile;

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
