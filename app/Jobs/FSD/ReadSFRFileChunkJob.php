<?php

namespace App\Jobs\FSD;

use App\Models\FSD\Recipient;
use App\Models\FSD\SFRFile;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;

class ReadSFRFileChunkJob implements ShouldQueue
{
    use Batchable, Queueable;

    public function __construct(private SFRFile $file, private array $lines) {}

    public function handle(): void
    {
        $records = [];
        foreach ($this->lines as $line) {
            if (!preg_match("/^О[0-9]{3}-[0-9]{3}-[0-9]{3}.*$/", $line))
                continue; // HACK AddErrorHandler добавить вывод ошибки

            // HACK AddErrorHandler добавить валидацию
            $records[] = [
                'SNILS'             => mb_substr($line, 1, 14),
                'birth'             => Carbon::make(mb_substr($line, 150, 10)),
                'date_start'        => Carbon::make(mb_substr($line, 1184, 10)),
                'date_end'          => Carbon::make(mb_substr($line, 1194, 10)),
                'file_id'           => $this->file->id,
            ];
        }

        Recipient::insert($records);
    }
}
