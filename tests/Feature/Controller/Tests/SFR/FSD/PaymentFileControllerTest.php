<?php

namespace Tests\Feature\Controller\Tests\SFR\FSD;

use App\Http\Controllers\SFR\FSD\PaymentFileController;
use App\Models\SFR\FSD\PaymentFile;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;


class PaymentFileControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = PaymentFileController::class;
    public string $modelClass = PaymentFile::class;
    public string $route = 'sfr.fsd.payment-files';

    public array $props = [
        'index' => 'files',
    ];

    public bool $hasShow = false;
    public bool $hasEdit = false;
    public bool $hasUpdate = false;
}
