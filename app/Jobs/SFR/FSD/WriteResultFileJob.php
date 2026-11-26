<?php

namespace App\Jobs\SFR\FSD;

use App\Models\SFR\FSD\ResultFile;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Bus;

class WriteResultFileJob implements ShouldQueue
{
    use Queueable, Batchable;

    public $timeout = 60;

    const CHUNK_SIZE = 5;

    public function __construct(public ResultFile $resultFile)
    {
        $this->onQueue('SFR-FSD');
    }

    public function handle(): void
    {
        // Получаем переменные
        $fromFileCursor = openFile($this->resultFile->SFRFile);

        // Получаем offset'ы
        $offsets = [0];
        $rowCount = 0;
        while (($rawLine = fgets($fromFileCursor)) !== false) {
            $rowCount++;

            if($rowCount % self::CHUNK_SIZE === 0) {
                $offsets[] = ftell($fromFileCursor);
            }
        }

        fclose($fromFileCursor);

        // Запускаем job'ы
        $batches = [];
        foreach ($offsets as $offset) {
            $part = $this->resultFile->createPart();
            $batches[] = new WriteResultFileChunkJob($this->resultFile, $part, $offset, self::CHUNK_SIZE);
        }

        Bus::batch($batches)
            ->onQueue('SFR-FSD')
            ->dispatch();
    }
}
