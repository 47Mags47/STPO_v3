<?php

namespace App\Writers\Payment;

use App\Classes\BankRaportWriter;

class SberWriter extends BankRaportWriter
{
    protected string $encoding = 'WINDOWS-1251';
    protected ?int $delimiter = 5000;

    public function getFileName(int $in_raport_npp): string
    {
        return 'f8615' . str_pad($this->npp, 3, '0', STR_PAD_LEFT) . '.xml';
    }
}
