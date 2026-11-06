<?php

namespace Tests\Feature\Policy\Tests\SFR\FSD;

use App\Models\SFR\FSD\TransitCategory;
use Tests\Feature\Policy\Cases\PolicyTestCase;

class TransitCategoryPolicyTest extends PolicyTestCase
{
    public string $modelClass = TransitCategory::class;
    public array $permissions = [
        'viewAny'       => ['FSD_administrator'],
        'create'        => ['FSD_administrator'],
        'update'        => ['FSD_administrator'],
        'delete'        => ['FSD_administrator'],
    ];

    public bool $hasView = false;
    public bool $hasRestore = false;
    public bool $hasForceDelete = false;

    public ?string $route = 'sfr.fsd.transit-categories';
}
