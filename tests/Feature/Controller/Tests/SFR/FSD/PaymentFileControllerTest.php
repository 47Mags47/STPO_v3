<?php

namespace Tests\Feature\Controller\Tests\SFR\FSD;

use App\Http\Controllers\SFR\FSD\PaymentFileController;
use App\Models\Base\UploadFile;
use App\Models\SFR\FSD\PaymentFile;
use Override;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;


class PaymentFileControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = PaymentFileController::class;
    public string $modelClass = PaymentFile::class;
    public string $route = 'sfr.fsd.payment-files';

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
}
