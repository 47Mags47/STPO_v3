<?php

namespace App\Writers\Payment;

use App\Classes\BankRaportWriter;

class PochtaBankWriter extends BankRaportWriter
{
    protected string $encoding = 'WINDOWS-1251';

    public function getFileName(int $in_raport_npp): string
    {
        return $this->event->in_date->format('Y') . '-ELVM-' . str_pad($this->npp, 5, '0', STR_PAD_LEFT) . '.xml';
    }
}
