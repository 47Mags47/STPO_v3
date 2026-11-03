<?php

namespace Tests\Feature\Policy\Tests\Appeal;

use App\Models\Appeal\Them;
use Tests\Feature\Policy\Cases\PolicyTestCase;

class ThemPolicyTest
extends PolicyTestCase
{
    public string $modelClass = Them::class;
    public array $permissions = [
        'viewAny'       => ['appeal_them'],
        'create'        => ['appeal_them'],
        'update'        => ['appeal_them'],
        'delete'        => ['appeal_them'],
    ];

    public bool $hasView = false;
    public bool $hasRestore = false;
    public bool $hasForceDelete = false;

    public ?string $route = 'appeal.thems';
}
