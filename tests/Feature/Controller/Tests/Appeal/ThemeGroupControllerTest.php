<?php

namespace Tests\Feature\Controller\Tests\Appeal;

use App\Http\Controllers\Appeal\ThemeGroupController;
use App\Models\Appeal\ThemeGroup;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;

class ThemeGroupControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = ThemeGroupController::class;
    public string $modelClass = ThemeGroup::class;
    public string $route = 'appeal.theme-groups';

    public ?array $pageProps = [
        'index' => 'theme_groups',
        'edit'  => 'theme_group',
    ];

    public bool $hasShow = false;
}
