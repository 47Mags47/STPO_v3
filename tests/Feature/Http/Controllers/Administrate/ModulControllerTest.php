<?php

namespace Tests\Feature\Http\Controllers\Base;

use App\Http\Controllers\Administrate\ModulController;
use App\Http\Requests\Administrate\ModulStoreRequest;
use App\Http\Requests\Administrate\ModulUpdateRequest;
use App\Models\Administrate\Modul;
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
    use TestInertiaIndexMethod;
    use TestInertiaCreateMethod;
    use TestInertiaStoreMethod;
    use TestInertiaEditMethod;
    use TestInertiaUpdateMethod;
    use TestInertiaDestroyMethod;

    use TestFormRequestRules;

    public string $controller = ModulController::class;
    public string $model = Modul::class;
    public string $routeName = 'administrate.moduls';
    public string $routeKey = 'modul';
    public string $storeRequest = ModulStoreRequest::class;
    public string $updateRequest = ModulUpdateRequest::class;
    public string $pageComponentPath = 'administrate/moduls';
    public string $propKey = 'moduls';
}
