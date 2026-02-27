<?php

namespace Tests\Feature\Http\Controllers\Base;

use App\Http\Controllers\Appeal\ThemGroupController;
use App\Http\Requests\Appeal\ThemGroupStoreRequest;
use App\Http\Requests\Appeal\ThemGroupUpdateRequest;
use App\Models\Appeal\ThemGroup;
use Tests\Cases\ControllerTestCase;
use Tests\Traits\TestFormRequestRules;
use Tests\Traits\TestInertiaCreateMethod;
use Tests\Traits\TestInertiaEditMethod;
use Tests\Traits\TestInertiaIndexMethod;
use Tests\Traits\TestInertiaStoreMethod;
use Tests\Traits\TestInertiaUpdateMethod;
use Tests\Traits\TestInertiaDestroyMethod;

class ThemGroupControllerTest extends ControllerTestCase
{

    use
        TestInertiaIndexMethod,
        TestInertiaCreateMethod,
        TestInertiaStoreMethod,
        TestInertiaEditMethod,
        TestInertiaUpdateMethod,
        TestInertiaDestroyMethod;

    use TestFormRequestRules;


    public string $controller = ThemGroupController::class;
    public string $model = ThemGroup::class;
    public string $routeName = 'appeal.them-groups';
    public string $routeKey = 'them_group';
    public string $storeRequest = ThemGroupStoreRequest::class;
    public string $updateRequest = ThemGroupUpdateRequest::class;
    public string $pageComponentPath = 'appeal/them-groups';
    public string $propKey = 'them_groups';
}
