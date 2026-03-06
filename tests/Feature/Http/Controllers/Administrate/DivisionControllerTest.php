<?php

namespace Tests\Feature\Http\Controllers\Administrate;

use App\Http\Controllers\Administrate\DivisionController;
use App\Http\Requests\Administrate\DivisionStoreRequest;
use App\Http\Requests\Administrate\DivisionUpdateRequest;
use App\Models\Administrate\Division;
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
    use TestInertiaIndexMethod;
    use TestInertiaCreateMethod;
    use TestInertiaStoreMethod;
    use TestInertiaEditMethod;
    use TestInertiaUpdateMethod;
    use TestInertiaDestroyMethod;

    use TestFormRequestRules;

    public string $controller = DivisionController::class;
    public string $model = Division::class;
    public string $routeName = 'administrate.divisions';
    public string $routeKey = 'division';
    public string $storeRequest = DivisionStoreRequest::class;
    public string $updateRequest = DivisionUpdateRequest::class;
    public string $pageComponentPath = 'administrate/divisions';
    public string $propKey = 'divisions';
}
