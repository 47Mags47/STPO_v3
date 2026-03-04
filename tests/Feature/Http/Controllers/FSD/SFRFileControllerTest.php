<?php

namespace Tests\Feature\Http\Controllers\Base;

use App\Http\Controllers\Base\TemplateController;
use App\Http\Controllers\FSD\SFRFileController;
use App\Http\Requests\Base\TemplateStoreRequest;
use App\Http\Requests\Base\TemplateUpdateRequest;
use App\Http\Requests\FSD\SFRFileStoreRequest;
use App\Models\FSD\SFRFile;
use App\Models\Template;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Tests\Cases\ControllerTestCase;
use Tests\Traits\TestFormRequestRules;
use Tests\Traits\TestInertiaCreateMethod;
use Tests\Traits\TestInertiaIndexMethod;
use Tests\Traits\TestInertiaStoreMethod;

class SFRFileControllerTest extends ControllerTestCase
{
    use
        TestInertiaIndexMethod,
        TestInertiaCreateMethod,
        TestInertiaStoreMethod;

    public string $controller = SFRFileController::class;
    public string $model = SFRFile::class;
    public string $routeName = 'fsd.files';
    public string $routeKey = 'file';
    public string $storeRequest = SFRFileStoreRequest::class;
    public string $pageComponentPath = 'fsd/SFRFiles';
    public string $propKey = 'files';

    public function getPayload(): array
    {
        $payload = parent::getPayload();
        unset($payload['file_id']);

        $payload['in_date'] = Carbon::make($payload['in_date'])->format('Y-m-d H:i:s');
        $payload['file'] = UploadedFile::fake()->createWithContent('05236011.000', 'test');

        return $payload;
    }
}
