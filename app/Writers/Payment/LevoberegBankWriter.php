<?php

namespace App\Writers\Payment;

use App\Classes\BankRaportWriter;

class LevoberegBankWriter extends BankRaportWriter
{
    protected string $encoding = 'CP866';

    public function getFileName(int $in_raport_npp): string
    {
        return str_pad($this->npp, 8, '0', STR_PAD_LEFT) . '.s52';
    }
}
