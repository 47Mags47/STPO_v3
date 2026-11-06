<?php

namespace Tests\Feature\Policy\Tests\Appeal;

use App\Models\Appeal\Appeal;
use Tests\Feature\Policy\Cases\PolicyTestCase;

class AppealPolicyTest
extends PolicyTestCase
{
    public string $modelClass = Appeal::class;
    public array $permissions = [
        'viewAny'       => ['appeal_work'],
        'create'        => ['appeal_work'],
        'view'          => ['appeal_work'],
    ];

    public bool $hasUpdate = false;
    public bool $hasDelete = false;
    public bool $hasForceDelete = false;
    public bool $hasRestore = false;

    public ?string $route = 'appeal.appeals';
}
