<?php

namespace Tests\Feature\Controller\Tests\Administrate\BankController;

use App\Http\Controllers\Administrate\BankController;
use App\Models\Administrate\Bank;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;

class BankControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = BankController::class;
    public string $modelClass = Bank::class;
    public string $route = 'administrate.banks';

    public array $props = [
        'index' => 'banks',
        'show'  => 'bank',
        'edit'  => 'bank',
    ];

    // public bool $hasShow = false;
}
