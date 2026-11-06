<?php

namespace Tests\Feature\Policy\Tests\SFR\FSD;

use App\Models\SFR\FSD\TransitEquivalent;
use Tests\Feature\Policy\Cases\PolicyTestCase;

class TransitEquivalentPolicyTest extends PolicyTestCase
{
    public string $modelClass = TransitEquivalent::class;
    public array $permissions = [
        'viewAny'       => ['FSD_administrator'],
        'create'        => ['FSD_administrator'],
    ];

    public bool $hasView = false;
    public bool $hasUpdate = false;
    public bool $hasDelete = false;
    public bool $hasRestore = false;
    public bool $hasForceDelete = false;

    public ?string $route = 'sfr.fsd.transit-equivalents';
}
