<?php

namespace App\Jobs\FSD;

use App\Models\FSD\Recipient;
use App\Models\FSD\SFRFile;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ReadSFRFileJob implements ShouldQueue
{
    use Queueable;

    const DEFAULT_RECIPIENT_STATUS_ID = 1;

    public function __construct(public SFRFile $file) {}

    public function handle(): void
    {
        // DEV Добавить reader
        $file = fopen($this->file->getFullPath(), 'r');
        while(!feof($file)) {
            $row = mb_convert_encoding(fgets($file), 'UTF-8', 'CP-866');

            if(!preg_match("/^О[0-9]{3}-[0-9]{3}-[0-9]{3}.*$/", $row))
                continue;

            $snils          = mb_substr($row, 1, 14);
            $division_code  = mb_substr($row, 26, 3);
            $first_name     = mb_ucfirst(mb_strtolower(mb_trim(mb_substr($row, 29, 40))));
            $last_name      = mb_ucfirst(mb_strtolower(mb_trim(mb_substr($row, 69, 40))));
            $middle_name    = mb_ucfirst(mb_strtolower(mb_trim(mb_substr($row, 109, 40))));

            $date_start     = Carbon::make(mb_substr($row, 1184, 10));
            $date_end       = Carbon::make(mb_substr($row, 1194, 10));
            // DEV Добавить валидацию входящих данных

            Recipient::create([
                'division_code'     => $division_code,
                'first_name'        => $first_name,
                'last_name'         => $last_name,
                'middle_name'       => $middle_name,
                'SNILS'             => $snils,
                'file_id'           => $this->file->id,
                'status_id'         => self::DEFAULT_RECIPIENT_STATUS_ID,

                'date_start'        => $date_start,
                'date_end'          => $date_end,
            ]);
        }

        // $content = mb_convert_encoding($this->file->getContent(), 'UTF-8', 'CP-866');
        // $pattern = "/^О[0-9]{3}-[0-9]{3}-[0-9]{3}.*(?:\n(?!О[0-9]{3}-[0-9]{3}-[0-9]{3}).*)*/m";
        // preg_match_all($pattern, $content, $matches);

        // foreach ($matches[0] ?? [] as $row) {
        //     $snils          = mb_substr($row, 1, 14);
        //     $division_code  = mb_substr($row, 26, 3);
        //     $first_name     = mb_ucfirst(mb_strtolower(mb_trim(mb_substr($row, 29, 40))));
        //     $last_name      = mb_ucfirst(mb_strtolower(mb_trim(mb_substr($row, 69, 40))));
        //     $middle_name    = mb_ucfirst(mb_strtolower(mb_trim(mb_substr($row, 109, 40))));

        //     $date_start     = Carbon::make(mb_substr($row, 1184, 10));
        //     $date_end       = Carbon::make(mb_substr($row, 1194, 10));
        //     // DEV Добавить валидацию входящих данных

        //     Recipient::create([
        //         'division_code'     => $division_code,
        //         'first_name'        => $first_name,
        //         'last_name'         => $last_name,
        //         'middle_name'       => $middle_name,
        //         'SNILS'             => $snils,
        //         'file_id'           => $this->file->id,
        //         'status_id'         => self::DEFAULT_RECIPIENT_STATUS_ID,

        //         'date_start'        => $date_start,
        //         'date_end'          => $date_end,
        //     ]);
        // }
    }
}
