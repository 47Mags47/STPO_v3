<?php

namespace Tests\Feature\Policy\Tests\Administrate;

use App\Models\Administrate\City;
use Tests\Feature\Policy\Cases\PolicyTestCase;

class CityPolicyTest
extends PolicyTestCase
{
    public string $modelClass = City::class;
    public array $permissions = [
        'viewAny'       => ['city_administrate'],
        'create'        => ['city_administrate'],
        'update'        => ['city_administrate'],
        'delete'        => ['city_administrate'],
    ];

    public bool $hasView = false;
    public bool $hasRestore = false;
    public bool $hasForceDelete = false;

    public ?string $route = 'administrate.cities';
}
