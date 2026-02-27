<?php

namespace Tests\Feature\Http\Controllers\Base;

use App\Http\Controllers\Appeal\AppealController;
use App\Http\Requests\Appeal\AppealStoreRequest;
use App\Models\Appeal\Appeal;
use Tests\Cases\ControllerTestCase;
use Tests\Traits\TestFormRequestRules;
use Tests\Traits\TestInertiaCreateMethod;
use Tests\Traits\TestInertiaIndexMethod;
use Tests\Traits\TestInertiaStoreMethod;

class AppealControllerTest extends ControllerTestCase
{
    use
        TestInertiaIndexMethod,
        TestInertiaCreateMethod,
        TestInertiaStoreMethod;

    public bool $auth = true;

    public string $controller = AppealController::class;
    public string $model = Appeal::class;
    public string $routeName = 'appeal.appeals';
    public string $routeKey = 'appeal';
    public string $storeRequest = AppealStoreRequest::class;
    public string $pageComponentPath = 'appeal/appeals';
    public string $propKey = 'appeals';

    public function getPayload(): array
    {
        $payload = parent::getPayload();

        unset($payload['sender_id']);
        unset($payload['status_id']);

        return $payload;
    }
}
