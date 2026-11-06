<?php

namespace App\Jobs\SFR\FSD;

use App\Models\SFR\FSD\TransitFile;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Support\Facades\Bus;

class ReadTransitFileJob implements ShouldQueue
{
    use Queueable;

    const CHUNK_SIZE = 1000;

    public function __construct(public TransitFile $transitFile)
    {
        $this->onQueue('SFR-FSD');
    }

    public function middleware(): array
    {
        return [
            (new WithoutOverlapping("file:" . $this->transitFile->file_id))->shared()
        ];
    }

    public function handle(): void
    {
        $this->transitFile->setStatus('reading');

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

        $file = $this->transitFile->fresh();
        Bus::batch($jobs)
            ->then(function (Batch $batch) use ($file) {
                $file->setStatus('ok');
            })
            ->onQueue('SFR-FSD')
            ->dispatch();
    }
}
