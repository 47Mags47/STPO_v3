<?php

namespace Tests\Feature\Controller\Tests\Auth;

use App\Http\Controllers\Auth\SelectDivisionController;
use Override;
use Tests\Feature\Controller\Cases\ControllerTestCase;

class SelectDivisionControllerTest extends ControllerTestCase
{
    public string $controllerClass = SelectDivisionController::class;
    public string $route = 'select-division';

    public ?array $pageProps = [
        'index' => 'divisions',
    ];

    public bool $hasCreate = false;
    public bool $hasShow = false;
    public bool $hasEdit = false;
    public bool $hasUpdate = false;
    public bool $hasDestroy = false;
    public bool $hasRestore = false;
    public bool $hasForceDelete = false;

    public ?string $storeRedirectRoute = 'dashboard';
    public ?string $storeFlashMessage = null;

    #[Override]
    public function createTestData(): array
    {
        return [];
    }
}
