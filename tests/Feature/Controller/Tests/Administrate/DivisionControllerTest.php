<?php

namespace Tests\Feature\Controller\Tests\Administrate;

use App\Http\Controllers\Administrate\DivisionController;
use App\Models\Administrate\Division;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;

class DivisionControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = DivisionController::class;
    public string $modelClass = Division::class;
    public string $route = 'administrate.divisions';

    public array $props = [
        'index' => 'divisions',
        'edit'  => 'division',
    ];

    public bool $hasShow = false;
}
