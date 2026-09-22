<?php

namespace Tests\Feature\Controller\Tests\Administrate;

use App\Http\Controllers\Administrate\PaymentController;
use App\Models\Administrate\Payment;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;

class PaymentControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = PaymentController::class;
    public string $modelClass = Payment::class;
    public string $route = 'administrate.payments';

    public array $props = [
        'index' => 'payments',
        'edit'  => 'payment',
    ];

    public bool $hasShow = false;
}
