<?php

namespace Tests\Feature\Controller\Tests\SFR\FSD;

use App\Http\Controllers\SFR\FSD\SFRCategoryController;
use App\Models\SFR\FSD\SFRPaymentCategory;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;


class SFRCategoryControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = SFRCategoryController::class;
    public string $modelClass = SFRPaymentCategory::class;
    public string $route = 'sfr.fsd.sfr-payment-categories';

    public array $props = [
        'index' => 'categories',
        'edit'  => 'category'
    ];

    public bool $hasShow = false;
}
