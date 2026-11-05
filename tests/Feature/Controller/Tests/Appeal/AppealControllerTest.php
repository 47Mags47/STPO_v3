<?php

namespace Tests\Feature\Controller\Tests\Appeal;

use App\Http\Controllers\Appeal\AppealController;
use App\Models\Appeal\Appeal;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;

class AppealControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = AppealController::class;
    public string $modelClass = Appeal::class;
    public string $route = 'appeal.appeals';
    public array $pageComponents = [
        'show' => 'appeal.messages.index'
    ];

    public ?array $pageProps = [
        'index' => 'appeals',
        'show'  => 'appeal',
    ];

    public bool $hasEdit = false;
    public bool $hasUpdate = false;
    public bool $hasDestroy = false;

    // HACK доделать (задачи 274 - 276)
    public bool $hasStore = true;
}
