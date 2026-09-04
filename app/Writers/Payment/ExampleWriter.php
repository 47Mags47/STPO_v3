<?php

namespace App\Writers\Payment;

use App\Classes\BankRaportWriter;
use App\Models\Payment\BankRaport;
use Illuminate\Support\Collection;

class ExampleWriter extends BankRaportWriter
{
    public function __construct(BankRaport $raport)
    {
        parent::__construct($raport);
    }

    public function fileName(): string
    {
        return 'example_bank_raport.txt';
    }

    public function fileData(Collection $recipients): array
    {
        return [
            'recipients' => $recipients,
        ];
    }
}
