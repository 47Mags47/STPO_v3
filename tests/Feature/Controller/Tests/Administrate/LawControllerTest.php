<?php

namespace Tests\Feature\Controller\Tests\Administrate;

use App\Http\Controllers\Administrate\LawController;
use App\Models\Administrate\Law;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;

class LawControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = LawController::class;
    public string $modelClass = Law::class;
    public string $route = 'administrate.laws';

    public array $props = [
        'index' => 'laws',
        'edit'  => 'law',
    ];

    public bool $hasShow = false;
}
