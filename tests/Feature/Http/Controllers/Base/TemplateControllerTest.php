<?php

namespace Tests\Feature\Http\Controllers\Base;

use App\Http\Controllers\Base\TemplateController;
use App\Http\Requests\Base\TemplateStoreRequest;
use App\Http\Requests\Base\TemplateUpdateRequest;
use App\Models\Template;
use Illuminate\Http\UploadedFile;
use Tests\Cases\ControllerTestCase;
use Tests\Traits\TestFormRequestRules;
use Tests\Traits\TestInertiaCreateMethod;
use Tests\Traits\TestInertiaDestroyMethod;
use Tests\Traits\TestInertiaEditMethod;
use Tests\Traits\TestInertiaIndexMethod;
use Tests\Traits\TestInertiaStoreMethod;
use Tests\Traits\TestInertiaUpdateMethod;

class TemplateControllerTest extends ControllerTestCase
{
    use
        TestInertiaIndexMethod,
        TestInertiaCreateMethod,
        TestInertiaStoreMethod,
        TestInertiaEditMethod,
        TestInertiaUpdateMethod,
        TestInertiaDestroyMethod;

    use TestFormRequestRules;

    public string $controller = TemplateController::class;
    public string $model = Template::class;
    public string $routeName = 'templates';
    public string $routeKey = 'template';
    public string $storeRequest = TemplateStoreRequest::class;
    public string $updateRequest = TemplateUpdateRequest::class;
    public string $pageComponentPath = 'base/templates';
    public string $propKey = 'templates';

    public function getPayload(): array
    {
        $payload = parent::getPayload();
        unset($payload['file_id']);
        $payload['file'] = UploadedFile::fake()->createWithContent('test', 'test');

        return $payload;
    }
}
