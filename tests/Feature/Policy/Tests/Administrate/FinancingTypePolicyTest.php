<?php

namespace Tests\Feature\Policy\Tests\Administrate;

use App\Models\Administrate\FinancingType;
use Tests\Feature\Policy\Cases\PolicyTestCase;

class FinancingTypePolicyTest
extends PolicyTestCase
{
    public string $modelClass = FinancingType::class;
    public array $permissions = [
        'viewAny'       => ['financing_types_administrate'],
        'create'        => ['financing_types_administrate'],
        'update'        => ['financing_types_administrate'],
        'delete'        => ['financing_types_administrate'],
    ];

    public bool $hasView = false;
    public bool $hasRestore = false;
    public bool $hasForceDelete = false;

    public ?string $route = 'administrate.financing-types';
}
