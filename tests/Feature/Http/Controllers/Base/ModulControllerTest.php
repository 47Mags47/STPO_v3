<?php

namespace Tests\Feature\Http\Controllers\Base;


use App\Http\Controllers\Base\ModulController;
use App\Http\Requests\Base\ModulStoreRequest;
use App\Http\Requests\Base\ModulUpdateRequest;
use App\Models\Modul;
use Tests\Cases\ControllerTestCase;
use Tests\Traits\TestFormRequestRules;
use Tests\Traits\TestInertiaCreateMethod;
use Tests\Traits\TestInertiaEditMethod;
use Tests\Traits\TestInertiaIndexMethod;
use Tests\Traits\TestInertiaStoreMethod;
use Tests\Traits\TestInertiaUpdateMethod;
use Tests\Traits\TestInertiaDestroyMethod;

class ModulControllerTest extends ControllerTestCase
{

    use
        TestInertiaIndexMethod,
        TestInertiaCreateMethod,
        TestInertiaStoreMethod,
        TestInertiaEditMethod,
        TestInertiaUpdateMethod,
        TestInertiaDestroyMethod;

    use TestFormRequestRules;


    public string $controller = ModulController::class;
    public string $model = Modul::class;
    public string $routeName = 'moduls';
    public string $routeKey = 'modul';
    public string $storeRequest = ModulStoreRequest::class;
    public string $updateRequest = ModulUpdateRequest::class;
    public string $pageComponentPath = 'base/moduls';
    public string $propKey = 'moduls';
}
