<?php

namespace Tests\Feature\Policy\Tests\Appeal;

use App\Models\Appeal\ThemeGroup;
use Tests\Feature\Policy\Cases\PolicyTestCase;

class ThemeGroupPolicyTest
extends PolicyTestCase
{
    public string $modelClass = ThemeGroup::class;
    public array $permissions = [
        'viewAny'       => ['appeal_work'],
        'create'        => ['appeal_work'],
        'update'        => ['appeal_work'],
        'delete'        => ['appeal_work'],
    ];

    public bool $hasView = false;
    public bool $hasRestore = false;
    public bool $hasForceDelete = false;

    public ?string $route = 'appeal.theme-groups';
}
