<?php

namespace Tests\Feature\Policy\Tests\Administrate;

use App\Models\Administrate\Bank;
use Tests\Feature\Policy\Cases\PolicyTestCase;

class BankPolicyTest
extends PolicyTestCase
{
    public string $modelClass = Bank::class;
    public array $permissions = [
        'viewAny'       => ['banks_administrate'],
        'create'        => ['banks_administrate'],
        'update'        => ['banks_administrate'],
        'delete'        => ['banks_administrate'],
    ];

    public bool $hasView = false;
    public bool $hasRestore = false;
    public bool $hasForceDelete = false;

    public ?string $route = 'administrate.banks';
}
