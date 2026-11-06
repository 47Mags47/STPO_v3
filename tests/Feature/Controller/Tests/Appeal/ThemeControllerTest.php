<?php

namespace Tests\Feature\Controller\Tests\Appeal;

use App\Http\Controllers\Appeal\ThemeController;
use App\Models\Appeal\Theme;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;

class ThemeControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = ThemeController::class;
    public string $modelClass = Theme::class;
    public string $route = 'appeal.themes';

    public ?array $pageProps = [
        'index' => 'themes',
        'edit'  => 'theme',
    ];

    public bool $hasShow = false;
}
