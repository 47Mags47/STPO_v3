<?php

namespace Tests\Feature\Http\Controllers\Base;

use App\Http\Controllers\FSD\SFRFileController;
use App\Http\Requests\FSD\SFRFileStoreRequest;
use App\Models\FSD\SFRFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Tests\Cases\ControllerTestCase;
use Tests\Traits\TestInertiaCreateMethod;
use Tests\Traits\TestInertiaIndexMethod;
use Tests\Traits\TestInertiaStoreMethod;

class SFRFileControllerTest extends ControllerTestCase
{
    use TestInertiaIndexMethod;
    use TestInertiaCreateMethod;
    use TestInertiaStoreMethod;

    public string $controller = SFRFileController::class;
    public string $model = SFRFile::class;
    public string $routeName = 'fsd.sfr-files';
    public string $routeKey = 'file';
    public string $storeRequest = SFRFileStoreRequest::class;
    public string $pageComponentPath = 'fsd/sfr-files';
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
