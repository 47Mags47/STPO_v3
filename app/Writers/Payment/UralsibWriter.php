<?php

namespace App\Writers\Payment;

use App\Classes\BankRaportWriter;

class UralsibWriter extends BankRaportWriter
{
    protected string $encoding = 'CP866';

    public function getFileName(int $in_raport_npp): string
    {
        return '55557460' . str_pad($this->npp, 3, '0', STR_PAD_LEFT) . '.I' . str_pad($this->npp, 3, '0', STR_PAD_LEFT);
    }

    public function afterTemplateRender(string $content, array $data): string
    {
        return str_pad((string) $data['recipients']->count(), 5, ' ', STR_PAD_LEFT) . $content;
    }
}
