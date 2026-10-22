<?php

namespace Tests\Feature\Controller\Tests\SFR\FSD;

use App\Http\Controllers\SFR\FSD\ResultFileController;
use App\Models\SFR\FSD\ResultFile;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;


class ResultFileControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = ResultFileController::class;
    public string $modelClass = ResultFile::class;
    public string $route = 'sfr.fsd.result-files';

    public array $props = [
        'index' => 'files',
    ];

    public bool $hasCreate = false;
    public bool $hasEdit = false;
    public bool $hasUpdate = false;
    public bool $hasDestroy = false;
}
