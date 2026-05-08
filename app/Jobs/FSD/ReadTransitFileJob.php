<?php

namespace App\Jobs\FSD;

use App\Models\FSD\TransitFile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class ReadTransitFileJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 300;

    const CHUNK_SIZE = 5000;

    public function __construct(public TransitFile $transitFile) {}

    public function handle(): void
    {
        Log::info('Загрузка файла: ' . $this->transitFile->file->origin_name);

        $file = fopen($this->transitFile->getFullPath(), 'r');

        $count = 0;
        $lines = [];
        $jobs = [];
        while (!feof($file)) {
            $count++;
            $lines[] = mb_convert_encoding(fgets($file), 'UTF-8', 'CP-866');

            if ($count >= $this::CHUNK_SIZE) {
                $jobs[] = new ReadTransitFileChunkJob($this->transitFile, $lines);

                $count = 0;
                $lines = [];
            }
        }

        $jobs[] = new ReadTransitFileChunkJob($this->transitFile, $lines);

        Bus::batch($jobs)
            ->onQueue('SFR-FSD-ReadTransitFile')
            ->dispatch();
    }
}
