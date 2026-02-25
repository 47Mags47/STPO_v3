<?php

namespace Tests\Feature\Http\Controllers\Base;

use App\Http\Controllers\Base\DivisionController;
use App\Http\Requests\Base\DivisionStoreRequest;
use App\Http\Requests\Base\DivisionUpdateRequest;
use App\Models\Division;
use Tests\Cases\ControllerTestCase;
use Tests\Traits\TestFormRequestRules;
use Tests\Traits\TestInertiaCreateMethod;
use Tests\Traits\TestInertiaEditMethod;
use Tests\Traits\TestInertiaIndexMethod;
use Tests\Traits\TestInertiaStoreMethod;
use Tests\Traits\TestInertiaUpdateMethod;
use Tests\Traits\TestInertiaDestroyMethod;

class DivisionControllerTest extends ControllerTestCase
{
    use
        TestInertiaIndexMethod,
        TestInertiaCreateMethod,
        TestInertiaStoreMethod,
        TestInertiaEditMethod,
        TestInertiaUpdateMethod,
        TestInertiaDestroyMethod;

    use TestFormRequestRules;


    public string $controller = DivisionController::class;
    public string $model = Division::class;
    public string $routeName = 'divisions';
    public string $routeKey = 'division';
    public string $storeRequest = DivisionStoreRequest::class;
    public string $updateRequest = DivisionUpdateRequest::class;
    public string $pageComponentPath = 'base/divisions';
    public string $propKey = 'divisions';
}
