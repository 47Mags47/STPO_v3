<?php

namespace App\Jobs\FSD;

use App\Imports\FSD\TransitFileImport;
use App\Models\FSD\TransitFile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ReadTransitFileJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public TransitFile $transitFile) {}

    public function handle(): void
    {
        (new TransitFileImport($this->transitFile))
            ->import($this->transitFile->getLocalPath(), $this->transitFile->file->disk, \Maatwebsite\Excel\Excel::CSV)
            ->onQueue('SFR-FSD-ReadTransitFile')
            ->allOnQueue('SFR-FSD-ReadTransitFile');
    }
}
