<?php

namespace Tests\Feature\Controller\Tests\Appeal;

use App\Http\Controllers\Appeal\ThemGroupController;
use App\Models\Appeal\ThemGroup;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;

class ThemGroupControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = ThemGroupController::class;
    public string $modelClass = ThemGroup::class;
    public string $route = 'appeal.them-groups';

    public array $props = [
        'index' => 'them-groups',
        'edit'  => 'them-group',
    ];

    public bool $hasShow = false;
}
