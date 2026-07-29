<?php

namespace App\Writers\Payment;

use App\Classes\BankRaportWriter;
use App\Models\Payment\BankRaport;
use Illuminate\Support\Collection;

class RosselhozWriter extends BankRaportWriter
{
    public function __construct(BankRaport $raport) {
        parent::__construct($raport);
    }

    public function fileName(int $npp): string
    {
        return '55557460'. str_pad($npp, 3, '0', STR_PAD_LEFT) . 'I' . str_pad($npp, 3, '0', STR_PAD_LEFT);
    }

    public function fileData(Collection $recipients): array
    {
        return [
            'recipients' => $recipients,
        ];
    }
}
