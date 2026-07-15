<?php

namespace App\Jobs\SFR\FSD;

use App\Models\SFR\FSD\SFRFile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;

class ReadSFRFileJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public SFRFile $SFRFile)
    {
        $this->onQueue('SFR-FSD');
    }

    public function handle(): void
    {
        waitDisabledFile($this->SFRFile);
        $this->SFRFile->setDisabled();
        $this->SFRFile->setStatus('reading');
        $this->SFRFile = $this->SFRFile->fresh();

        $file = fopen($this->SFRFile->getFullPath(), 'r');

        $date_start = $this->SFRFile->in_date->startOfMonth();
        $date_end = $this->SFRFile->in_date->endOfMonth();

        while (!feof($file)) {
            $line = mb_convert_encoding(fgets($file), 'UTF-8', 'CP-866');

            if (!preg_match("/^О[0-9]{3}-[0-9]{3}-[0-9]{3}.*$/", $line))
                continue;

            if (Carbon::make(mb_substr($line, 1184, 10)) < $date_start){
                $date_start = Carbon::make(mb_substr($line, 1184, 10))->startOfMonth();
            }

            if (Carbon::make(mb_substr($line, 1194, 10)) > $date_end)
                $date_end = Carbon::make(mb_substr($line, 1194, 10))->endOfMonth();
        }

        $this->SFRFile->update([
            'date_start' => $date_start,
            'date_end' => $date_end,
        ]);

        $this->SFRFile->setStatus('ok');
        $this->SFRFile->setDisabled(false);
    }
}
