<?php

namespace Tests\Feature\Http\Controllers\Base;

use App\Http\Controllers\Administrate\ModulGroupController;
use App\Http\Requests\Administrate\ModulGroupStoreRequest;
use App\Http\Requests\Administrate\ModulGroupUpdateRequest;
use App\Models\Administrate\ModulGroup;
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
    use TestInertiaIndexMethod;
    use TestInertiaCreateMethod;
    use TestInertiaStoreMethod;
    use TestInertiaEditMethod;
    use TestInertiaUpdateMethod;
    use TestInertiaDestroyMethod;

    use TestFormRequestRules;


    public string $controller = ModulGroupController::class;
    public string $model = ModulGroup::class;
    public string $routeName = 'administrate.modul-groups';
    public string $routeKey = 'modul_group';
    public string $storeRequest = ModulGroupStoreRequest::class;
    public string $updateRequest = ModulGroupUpdateRequest::class;
    public string $pageComponentPath = 'administrate/modul-groups';
    public string $propKey = 'modulGroups';
}
