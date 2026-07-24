<?php

namespace App\Writers\Payment;

use App\Classes\BankRaportWriter;
use App\Models\Payment\BankRaport;
use Illuminate\Support\Collection;

class VTBWriter extends BankRaportWriter
{
    public function __construct(BankRaport $raport) {
        $this->encoding = 'WINDOWS-1251';

        parent::__construct($raport);
    }

    public function fileName(int $npp): string
    {
        return 'Z_0000281997_'. $this->raport->event->in_day->format('Ymd') . '_' . str_pad($npp, 2, '0', STR_PAD_LEFT) . '.txt';
    }

    public function fileData(Collection $recipients): array
    {
        return [
            'contract' => $this->contract,
            'recipients' => $recipients,
            'event' => $this->event,
            'division_name' => "ГОСУДАРСТВЕННОЕ КАЗЕННОЕ УЧРЕЖДЕНИЕ \"ЦЕНТР СОЦИАЛЬНЫХ ВЫПЛАТ И ИНФОРМАТИЗАЦИИ МИНИСТЕРСТВА СОЦИАЛЬНОЙ ЗАЩИТЫ НАСЕЛЕНИЯ КУЗБАССА\""
        ];
    }
}
