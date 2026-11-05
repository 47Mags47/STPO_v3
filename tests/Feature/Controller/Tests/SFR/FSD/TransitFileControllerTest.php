<?php

namespace Tests\Feature\Controller\Tests\SFR\FSD;

use App\Http\Controllers\SFR\FSD\TransitFileController;
use App\Models\Base\UploadFile;
use App\Models\SFR\FSD\TransitFile;
use Override;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;


class TransitFileControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = TransitFileController::class;
    public string $modelClass = TransitFile::class;
    public string $route = 'sfr.fsd.transit-files';

    public ?array $pageProps = [
        'index' => 'files',
    ];

    public bool $hasShow = false;
    public bool $hasEdit = false;
    public bool $hasUpdate = false;
    public bool $hasDestroy = false;

    #[Override]
    public function modifySendData(array $data): array
    {
        $data['file_id'] = UploadFile::emptyFile()->id;
        return $data;
    }

    #[Override]
    public function modifyCheckData(array $data): array
    {
        $data['file_id'] = UploadFile::emptyFile()->file_id;
        return $data;
    }
}
