<?php

namespace Tests\Feature\Http\Controllers\Base;


use App\Http\Controllers\Base\ModulGroupController;
use App\Http\Requests\Base\ModulGroupStoreRequest;
use App\Http\Requests\Base\ModulGroupUpdateRequest;
use App\Models\ModulGroup;
use Tests\Cases\ControllerTestCase;
use Tests\Traits\TestFormRequestRules;
use Tests\Traits\TestInertiaCreateMethod;
use Tests\Traits\TestInertiaEditMethod;
use Tests\Traits\TestInertiaIndexMethod;
use Tests\Traits\TestInertiaStoreMethod;
use Tests\Traits\TestInertiaUpdateMethod;
use Tests\Traits\TestInertiaDestroyMethod;

class ModulGroupControllerTest extends ControllerTestCase
{

    use
        TestInertiaIndexMethod,
        TestInertiaCreateMethod,
        TestInertiaStoreMethod,
        TestInertiaEditMethod,
        TestInertiaUpdateMethod,
        TestInertiaDestroyMethod;

    use TestFormRequestRules;


    public string $controller = ModulGroupController::class;
    public string $model = ModulGroup::class;
    public string $routeName = 'modul-groups';
    public string $routeKey = 'modul_group';
    public string $storeRequest = ModulGroupStoreRequest::class;
    public string $updateRequest = ModulGroupUpdateRequest::class;
    public string $pageComponentPath = 'base/modul-groups';
    public string $propKey = 'modulGroups';
}
