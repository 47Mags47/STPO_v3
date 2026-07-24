<?php

namespace App\Writers\Payment;

use App\Classes\BankRaportWriter;
use App\Models\Payment\BankRaport;
use Illuminate\Support\Collection;

class SberWriter extends BankRaportWriter
{
    public function __construct(BankRaport $raport) {
        $this->delimiter = 25000;
        parent::__construct($raport);
    }

    public function fileName(int $npp): string
    {
        return 'f8615' . str_pad($npp, 3, '0', STR_PAD_LEFT) . '.xml';
    }

    public function fileData(Collection $recipients): array
    {
        return [
            'contract' => $this->contract,
            'recipients' => $recipients,
        ];
    }
}
