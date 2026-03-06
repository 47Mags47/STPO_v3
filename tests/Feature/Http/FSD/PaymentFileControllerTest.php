<?php

namespace Tests\Feature\Http\Controllers\Base;

use App\Http\Controllers\FSD\PaymentFileController;
use App\Http\Requests\FSD\PaymentFileStoreRequest;
use App\Models\FSD\PaymentFile;
use Illuminate\Http\UploadedFile;
use Tests\Cases\ControllerTestCase;
use Tests\Traits\TestInertiaCreateMethod;
use Tests\Traits\TestInertiaIndexMethod;
use Tests\Traits\TestInertiaStoreMethod;

class PaymentFileControllerTest extends ControllerTestCase
{
    use TestInertiaIndexMethod;
    use TestInertiaCreateMethod;
    use TestInertiaStoreMethod;

    public string $controller = PaymentFileController::class;
    public string $model = PaymentFile::class;
    public string $routeName = 'fsd.payment-files';
    public string $routeKey = 'file';
    public string $storeRequest = PaymentFileStoreRequest::class;
    public string $pageComponentPath = 'fsd/payment-files';
    public string $propKey = 'files';

    public function getPayload(): array
    {
        $payload = parent::getPayload();
        unset($payload['file_id']);

        $payload['file'] = UploadedFile::fake()->createWithContent('test.txt', 'test');

        return $payload;
    }
}
