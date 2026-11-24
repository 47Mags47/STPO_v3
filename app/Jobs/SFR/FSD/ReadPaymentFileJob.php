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

    const CHUNK_SIZE = 2000;

    /**
     * @var integer
     */
    private $paymentFileId;

    /**
     * @var paymentFile|null
     */
    private $paymentFile;

    /**
     * @var resource|null
     */
    private $paymentFileCursor = null;

    public function __construct(int $paymentFileId)
    {
        $this->onQueue('SFR-FSD');

        $this->paymentFileId = $paymentFileId;
    }

    public function middleware(): array
    {
        $paymentFile = PaymentFile::findOrFail($this->paymentFileId);

        return [
            (new WithoutOverlapping("file:" . $paymentFile->file_id))->shared()
        ];
    }

    public function handle(): void
    {
        $this->paymentFile = PaymentFile::findOrFail($this->paymentFileId);
        $this->paymentFile->setStatus('reading');

        $this->openFile();

        $count = 0;
        $lines = [];
        $jobs = [];
        while (($line = fgets($this->paymentFileCursor)) !== false) {
            // Проверка кодировки документа
            $converted = @mb_convert_encoding($line, 'UTF-8', 'CP-866');
            if ($converted === false) {
                $this->paymentFile->addError('Ошибка конвертации: ' . $line);
                Log::driver('check')->error('Ошибка конвертации: ' . $line);
                continue;
            }
            $line = trim($converted);

            if ($line === '')
                continue;

            $lines[] = $line;

            $count++;

            if ($count >= $this::CHUNK_SIZE) {
                $jobs[] = new ReadPaymentFileChunkJob($this->paymentFile, $lines);

                $count = 0;
                $lines = [];
            }
        }

        fclose($this->paymentFileCursor);

        if (!empty($lines))
            $jobs[] = new ReadPaymentFileChunkJob($this->paymentFile, $lines);

        $file = $this->paymentFile;

        Bus::batch($jobs)
            ->finally(function (Batch $batch) use ($file) {
                $file->setStatus('ok');
            })
            ->onQueue('SFR-FSD')
            ->dispatch();
    }

    private function openFile()
    {
        $path = $this->paymentFile->fullPath;

        if (!is_file($path)) {
            $this->paymentFile->setStatus('error');
            $this->paymentFile->addError('Ошибка чтения файла');
            throw new \RuntimeException('Файл не найден: ' . $path);
        }

        if (!is_readable($path)) {
            $this->paymentFile->setStatus('error');
            $this->paymentFile->addError('Ошибка чтения файла');
            throw new \RuntimeException('Файл недоступен для чтения: ' . $path);
        }

        $cursor = @fopen($path, 'rb');
        if ($cursor === false) {
            $this->paymentFile->addError('Ошибка чтения файла');
            throw new \RuntimeException('Не удалось открыть исходный файл: ' . $path);
        }
        $this->paymentFileCursor = $cursor;
    }
}
