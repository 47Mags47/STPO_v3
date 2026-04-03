<?php

namespace App\Jobs\FSD;

use App\Models\FSD\SFRFile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ReadSFRFileJob implements ShouldQueue
{
    use Queueable;

    const CHUNK_SIZE = 1000;

    public function __construct(public SFRFile $file) {}

    public function handle(): void
    {
        $file = fopen($this->file->getFullPath(), 'r');

        $count = 0;
        $lines = [];
        while (!feof($file)) {
            $count++;
            $lines[] = mb_convert_encoding(fgets($file), 'UTF-8', 'CP-866');

            if($count >= $this::CHUNK_SIZE){
                ReadSFRFileChunkJob::dispatch($this->file, $lines)->onQueue('fsd-sfrFile-readChunk');

                $count = 0;
                $lines = [];
            }
        }

        ReadSFRFileChunkJob::dispatch($this->file, $lines)->onQueue('fsd-sfrFile-readChunk');
    }
}
