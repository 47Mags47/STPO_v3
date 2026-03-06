<?php

namespace Tests\Feature\Http\Controllers\Base;

use App\Http\Controllers\Administrate\TemplateController;
use App\Http\Requests\Administrate\TemplateStoreRequest;
use App\Http\Requests\Administrate\TemplateUpdateRequest;
use App\Models\Administrate\Template;
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
    use TestInertiaIndexMethod;
    use TestInertiaCreateMethod;
    use TestInertiaStoreMethod;
    use TestInertiaEditMethod;
    use TestInertiaUpdateMethod;
    use TestInertiaDestroyMethod;

    use TestFormRequestRules;

    public string $controller = TemplateController::class;
    public string $model = Template::class;
    public string $routeName = 'administrate.templates';
    public string $routeKey = 'template';
    public string $storeRequest = TemplateStoreRequest::class;
    public string $updateRequest = TemplateUpdateRequest::class;
    public string $pageComponentPath = 'administrate/templates';
    public string $propKey = 'templates';

    public function getPayload(): array
    {
        $payload = parent::getPayload();
        unset($payload['file_id']);
        $payload['file'] = UploadedFile::fake()->createWithContent('test', 'test');

        return $payload;
    }
}
