<?php

namespace Tests\Feature\Controller\Tests\SFR\FSD;

use App\Http\Controllers\SFR\FSD\SFRFileController;
use App\Models\SFR\FSD\SFRFile;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;


class SFRFileControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = SFRFileController::class;
    public string $modelClass = SFRFile::class;
    public string $route = 'sfr.fsd.sfr-files';

    public array $props = [
        'index' => 'files',
    ];

    public bool $hasShow = false;
    public bool $hasEdit = false;
    public bool $hasUpdate = false;
    public bool $hasDestroy = false;
}
