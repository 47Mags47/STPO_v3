<?php

namespace App\Writers\Payment;

use App\Classes\BankRaportWriter;

class KuzBizBankWriter extends BankRaportWriter
{
    protected string $encoding = 'WINDOWS-1251';

    public function getFileName(int $in_raport_npp): string
    {
        return 'SZRG_KBB20_' . $this->event->in_date->format('dmY') . '_' . str_pad($this->npp, 5, '0', STR_PAD_LEFT) . '.txt';
    }
}
