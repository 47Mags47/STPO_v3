<?php

namespace Tests\Feature\Policy\Tests\Administrate;

use App\Models\Administrate\Payment;
use Tests\Feature\Policy\Cases\PolicyTestCase;

class PaymentPolicyTest
extends PolicyTestCase
{
    public string $modelClass = Payment::class;
    public array $permissions = [
        'viewAny'       => ['payments_administrate'],
        'create'        => ['payments_administrate'],
        'update'        => ['payments_administrate'],
        'delete'        => ['payments_administrate'],
    ];

    public bool $hasView = false;
    public bool $hasRestore = false;
    public bool $hasForceDelete = false;

    public ?string $route = 'administrate.payments';
}
