<?php

namespace Tests\Feature\Controller\Tests\Payment;

use App\Http\Controllers\Payment\PaymentFileController;
use App\Models\Payment\PaymentFile;
use App\Models\Payment\Event;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;
use Illuminate\Database\Eloquent\Model;
use App\Models\Base\UploadFile;
use Override;

class PaymentFileControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = PaymentFileController::class;
    public string $modelClass = PaymentFile::class;
    public string $route = 'payment.payment-files';

    public ?array $pageProps = [
        'index' => 'files',
    ];

    public bool $hasShow = false;
    public bool $hasEdit = false;
    public bool $hasUpdate = false;

    #[Override]
    public function modifySendData(array $data): array
    {
        $data['file_id'] = UploadFile::emptyFile()->id;
        $data['file_ids'] = [$data['file_id']];
        return $data;
    }

    #[Override]
    public function modifyCheckData(array $data): array
    {
        unset($data['file_ids']);
        $data['file_id'] = UploadFile::emptyFile()->file_id;
        return $data;
    }

    #[Override]
    public function modifyRouteParams(?array $params = [], ?Model $record = null): array
    {
        $params['event'] = $record !== null
            ? $record->event->id
            : Event::randomOrCreate();

        return $params;
    }
}
