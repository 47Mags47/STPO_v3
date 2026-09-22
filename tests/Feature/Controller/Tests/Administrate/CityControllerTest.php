<?php

namespace Tests\Feature\Controller\Tests\Administrate;

use App\Http\Controllers\Administrate\CityController;
use App\Models\Administrate\City;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;

class CityControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = CityController::class;
    public string $modelClass = City::class;
    public string $route = 'administrate.cities';

    public array $props = [
        'index' => 'cities',
        'edit'  => 'city',
    ];

    public bool $hasShow = false;
}
