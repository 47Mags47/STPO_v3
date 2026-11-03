<?php

namespace Tests\Feature\Controller\Tests\SFR\FSD;

use App\Http\Controllers\SFR\FSD\ASPCategoryController;
use App\Models\SFR\FSD\ASPPaymentCategory;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;


class ASPCategoryControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = ASPCategoryController::class;
    public string $modelClass = ASPPaymentCategory::class;
    public string $route = 'sfr.fsd.asp-payment-categories';

    public array $props = [
        'index' => 'categories',
        'edit'  => 'category',
    ];

    public bool $hasShow = false;
}
