<?php

namespace Tests\Feature\Policy\Tests\SFR\FSD;

use App\Models\SFR\FSD\PaymentFile;
use Tests\Feature\Policy\Cases\PolicyTestCase;

class PaymentFilePolicyTest extends PolicyTestCase
{
    public string $modelClass = PaymentFile::class;
    public array $permissions = [
        'viewAny'       => ['FSD_administrator'],
        'create'        => ['FSD_administrator'],
        'update'        => ['FSD_administrator'],
        'delete'        => ['FSD_administrator'],
    ];

    public bool $hasView = false;
    public bool $hasEdit = false;
    public bool $hasUpdate = false;
    public bool $hasForceDelete = false;

    public ?string $route = 'sfr.fsd.payment-files';
}
