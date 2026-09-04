<?php

namespace App\Writers\Payment;

use App\Classes\BankRaportWriter;

class VTBWriter extends BankRaportWriter
{
    protected string $encoding = 'WINDOWS-1251';

    public function getFileName(int $in_raport_npp): string
    {
        $default =
            'Z_' .
            str_pad('281997', 10, '0', STR_PAD_LEFT) .
            '_' .
            $this->raport->event->in_date->format('Ymd') .
            '_' .
            str_pad($this->npp, 10, '0', STR_PAD_LEFT);

        if($this->recipientChunks->count() > 1)
            $default = $default .
            '_' .
            str_pad($in_raport_npp, 10, '0', STR_PAD_LEFT);

        return
            $default .
            '.txt';
    }
}
