<?php

namespace Tests\Feature\Policy\Tests\Administrate;

use App\Models\Administrate\Law;
use Tests\Feature\Policy\Cases\PolicyTestCase;

class LawPolicyTest
extends PolicyTestCase
{
    public string $modelClass = Law::class;
    public array $permissions = [
        'viewAny'       => ['laws_administrate'],
        'create'        => ['laws_administrate'],
        'update'        => ['laws_administrate'],
        'delete'        => ['laws_administrate'],
    ];

    public bool $hasView = false;
    public bool $hasRestore = false;
    public bool $hasForceDelete = false;

    public ?string $route = 'administrate.laws';
}
