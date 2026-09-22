<?php

namespace Tests\Feature\Policy\Tests\Administrate;

use App\Models\Administrate\Division;
use Tests\Feature\Policy\Cases\PolicyTestCase;

class DivisionPolicyTest
extends PolicyTestCase
{
    public string $modelClass = Division::class;
    public array $permissions = [
        'viewAny'       => ['division_administrate'],
        'create'        => ['division_administrate'],
        'update'        => ['division_administrate'],
        'delete'        => ['division_administrate'],
    ];

    public bool $hasView = false;
    public bool $hasRestore = false;
    public bool $hasForceDelete = false;

    public ?string $route = 'administrate.divisions';
}
