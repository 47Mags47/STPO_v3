<?php

namespace Tests\Feature\Controller\Tests\Administrate;

use App\Http\Controllers\Administrate\FinancingTypeController;
use App\Models\Administrate\FinancingType;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;

class FinancingTypesControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = FinancingTypeController::class;
    public string $modelClass = FinancingType::class;
    public string $route = 'administrate.financing-types';

    public array $props = [
        'index' => 'types',
        'edit'  => 'type',
    ];

    public bool $hasShow = false;
}
