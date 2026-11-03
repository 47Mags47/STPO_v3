<?php

namespace Tests\Feature\Controller\Tests\SFR\FSD;

use App\Http\Controllers\SFR\FSD\ResultFileController;
use App\Models\Base\UploadFile;
use App\Models\SFR\FSD\ResultFile;
use App\Models\SFR\FSD\SFRFile;
use Illuminate\Database\Eloquent\Model;
use Override;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;


class ResultFileControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = ResultFileController::class;
    public string $modelClass = ResultFile::class;
    public string $route = 'sfr.fsd.result-files';

    public array $pageProps = [
        'index' => 'files',
    ];

    public bool $hasCreate = false;
    public bool $hasShow = false;
    public bool $hasEdit = false;
    public bool $hasUpdate = false;
    public bool $hasDestroy = false;

    public string $storeFlashMessage = 'Формирование файла запущено';

    #[Override]
    public function modifyCheckData(array $data): array
    {
        unset($data['file_id']);
        return $data;
    }

    #[Override]
    public function modifyRouteParams(?array $params = [], ?Model $record = null): array
    {
        $params['SFRFile'] = $record !== null
            ? $record->SFRFile->id
            : SFRFile::randomOrCreate(['file_id' => UploadFile::emptyFile()->file_id]);

        return $params;
    }
}
