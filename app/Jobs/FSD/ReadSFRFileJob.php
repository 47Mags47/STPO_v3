<?php

namespace App\Jobs\FSD;

use App\Events\SFR\FSD\SFRFileChange;
use App\Models\FSD\SFRFile;
use Illuminate\Bus\Batch;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class ReadSFRFileJob implements ShouldQueue
{
    use Queueable, Batchable;

    const CHUNK_SIZE = 5000;

    public function __construct(public SFRFile $file) {}

    public function handle(): void
    {
        $file = fopen($this->file->getFullPath(), 'r');

        $count = 0;
        $lines = [];
        $jobs = [];
        while (!feof($file)) {
            $count++;
            $lines[] = mb_convert_encoding(fgets($file), 'UTF-8', 'CP-866');

            if ($count >= $this::CHUNK_SIZE) {
                $jobs[] = new ReadSFRFileChunkJob($this->file, $lines);

                $count = 0;
                $lines = [];
            }
        }

        $jobs[] = new ReadSFRFileChunkJob($this->file, $lines);

        Bus::batch($jobs)
            ->progress(function (Batch $batch) {
                Log::info($batch->progress());
            })
            ->finally(function () {
                SFRFileChange::dispatch();
            })
            ->onQueue('SFR-FSD-ReadSFRFile')
            ->dispatch();
    }
}
