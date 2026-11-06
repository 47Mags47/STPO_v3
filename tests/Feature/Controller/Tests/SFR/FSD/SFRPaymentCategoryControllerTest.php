<?php

namespace Tests\Feature\Controller\Tests\SFR\FSD;

use App\Http\Controllers\SFR\FSD\SFRPaymentCategoryController;
use App\Models\SFR\FSD\SFRPaymentCategory;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;


class SFRPaymentCategoryControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = SFRPaymentCategoryController::class;
    public string $modelClass = SFRPaymentCategory::class;
    public string $route = 'sfr.fsd.sfr-payment-categories';

    public ?array $pageProps = [
        'index' => 'categories',
        'edit'  => 'category'
    ];

    public bool $hasShow = false;
}
