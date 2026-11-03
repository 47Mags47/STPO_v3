<?php

namespace Tests\Feature\Controller\Tests\Appeal;

use App\Http\Controllers\Appeal\ThemController;
use App\Models\Appeal\Them;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;

class ThemControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = ThemController::class;
    public string $modelClass = Them::class;
    public string $route = 'appeal.thems';

    public array $pageProps = [
        'index' => 'thems',
        'edit'  => 'them',
    ];

    public bool $hasShow = false;
}
