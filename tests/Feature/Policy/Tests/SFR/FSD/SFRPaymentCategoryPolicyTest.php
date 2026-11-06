<?php

namespace Tests\Feature\Policy\Tests\SFR\FSD;

use App\Models\SFR\FSD\SFRPaymentCategory;
use Tests\Feature\Policy\Cases\PolicyTestCase;

class SFRPaymentCategoryPolicyTest extends PolicyTestCase
{
    public string $modelClass = SFRPaymentCategory::class;

    public array $permissions = [
        'viewAny'       => ['FSD_administrator'],
        'create'        => ['FSD_administrator'],
        'update'        => ['FSD_administrator'],
        'delete'        => ['FSD_administrator'],
    ];

    public bool $hasView = false;
    public bool $hasRestore = false;
    public bool $hasForceDelete = false;

    public ?string $route = 'sfr.fsd.sfr-payment-categories';
}
