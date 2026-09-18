<?php

namespace Tests\Feature\Controller\Administrate;

use App\Http\Controllers\Administrate\CityController;
use App\Models\Administrate\City;
use Tests\Feature\Abstracts\Controller\RESTFullAbstractController;

class CityControllerTest// extends RESTFullAbstractController
{
    ### Overwrite
    ##################################################
    public string $controllerClass = CityController::class;
    public string $modelClass = City::class;
    public string $route = 'administrate.cities';
    public array $props = [
        'index' => 'cities',
        'show'  => 'city',
        'edit'  => 'city',
    ];

    public bool $hasShow = false;
}
