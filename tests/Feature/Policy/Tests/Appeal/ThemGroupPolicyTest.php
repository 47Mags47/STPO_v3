<?php

namespace Tests\Feature\Policy\Tests\Appeal;

use App\Models\Appeal\ThemGroup;
use Tests\Feature\Policy\Cases\PolicyTestCase;

class ThemGroupPolicyTest
extends PolicyTestCase
{
    public string $modelClass = ThemGroup::class;
    public array $permissions = [
        'viewAny'       => ['appeal_them'],
        'create'        => ['appeal_them'],
        'update'        => ['appeal_them'],
        'delete'        => ['appeal_them'],
    ];

    public bool $hasView = false;
    public bool $hasRestore = false;
    public bool $hasForceDelete = false;

    public ?string $route = 'appeal.them-groups';
}
