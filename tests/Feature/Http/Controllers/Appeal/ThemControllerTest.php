<?php

namespace Tests\Feature\Http\Controllers\Base;

use App\Http\Controllers\Appeal\ThemController;
use App\Http\Requests\Appeal\ThemStoreRequest;
use App\Http\Requests\Appeal\ThemUpdateRequest;
use App\Models\Appeal\Them;
use Tests\Cases\ControllerTestCase;
use Tests\Traits\TestFormRequestRules;
use Tests\Traits\TestInertiaCreateMethod;
use Tests\Traits\TestInertiaEditMethod;
use Tests\Traits\TestInertiaIndexMethod;
use Tests\Traits\TestInertiaStoreMethod;
use Tests\Traits\TestInertiaUpdateMethod;
use Tests\Traits\TestInertiaDestroyMethod;

class ThemControllerTest extends ControllerTestCase
{

    use
        TestInertiaIndexMethod,
        TestInertiaCreateMethod,
        TestInertiaStoreMethod,
        TestInertiaEditMethod,
        TestInertiaUpdateMethod,
        TestInertiaDestroyMethod;

    use TestFormRequestRules;


    public string $controller = ThemController::class;
    public string $model = Them::class;
    public string $routeName = 'appeal.thems';
    public string $routeKey = 'them';
    public string $storeRequest = ThemStoreRequest::class;
    public string $updateRequest = ThemUpdateRequest::class;
    public string $pageComponentPath = 'appeal/thems';
    public string $propKey = 'thems';
}
