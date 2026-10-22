<?php

namespace Tests\Feature\Controller\Tests\SFR\FSD;

use App\Http\Controllers\SFR\FSD\TransitCategoryController;
use App\Models\SFR\FSD\TransitCategory;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;


class TransitCategoryControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = TransitCategoryController::class;
    public string $modelClass = TransitCategory::class;
    public string $route = 'sfr.fsd.transit-categories';

    public array $props = [
        'index' => 'categories',
        'edit'  => 'category'
    ];

    public bool $hasShow = false;
}
