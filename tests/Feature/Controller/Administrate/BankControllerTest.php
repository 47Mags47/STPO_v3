<?php

namespace Tests\Feature\Controller\Administrate;

use App\Http\Controllers\Administrate\BankController;
use App\Models\Administrate\Bank;
use Tests\Feature\Abstracts\Controller\RESTFullAbstractController;

class BankControllerTest //extends RESTFullAbstractController
{
    ### Overwrite
    ##################################################
    public string $controllerClass = BankController::class;
    public string $modelClass = Bank::class;
    public string $route = 'administrate.banks';
    public array $props = [
        'index' => 'banks',
        'show'  => 'bank',
        'edit'  => 'bank',
    ];

    public bool $hasShow = false;
}
