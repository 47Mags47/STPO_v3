<?php

namespace Tests\Feature\Controller\Tests\SFR\FSD;

use App\Http\Controllers\SFR\FSD\TransitFileController;
use App\Models\SFR\FSD\TransitFile;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;


class TransitFileControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = TransitFileController::class;
    public string $modelClass = TransitFile::class;
    public string $route = 'sfr.fsd.transit-files';

    public array $props = [
        'index' => 'files',
    ];

    public bool $hasShow = false;
    public bool $hasEdit = false;
    public bool $hasUpdate = false;
    public bool $hasDestroy = false;
}
