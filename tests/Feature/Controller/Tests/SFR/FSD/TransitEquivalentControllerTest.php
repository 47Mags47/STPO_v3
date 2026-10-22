<?php

namespace Tests\Feature\Controller\Tests\SFR\FSD;

use App\Http\Controllers\SFR\FSD\TransitEquivalentController;
use App\Models\SFR\FSD\TransitEquivalent;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;


class TransitEquivalentControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = TransitEquivalentController::class;
    public string $modelClass = TransitEquivalent::class;
    public string $route = 'sfr.fsd.transit-categories';

    public array $props = [
        'index' => 'equivalents'
    ];

    public bool $hasShow = false;
    public bool $hasEdit = false;
    public bool $hasUpdate = false;
    public bool $hasDestroy = false;
}
