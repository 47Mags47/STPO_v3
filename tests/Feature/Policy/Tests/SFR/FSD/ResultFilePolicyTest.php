<?php

namespace Tests\Feature\Policy\Tests\SFR\FSD;

use App\Models\Base\UploadFile;
use App\Models\SFR\FSD\ResultFile;
use App\Models\SFR\FSD\SFRFile;
use Illuminate\Database\Eloquent\Model;
use Override;
use Tests\Feature\Policy\Cases\PolicyTestCase;

class ResultFilePolicyTest extends PolicyTestCase
{
    public string $modelClass = ResultFile::class;

    public array $permissions = [
        'viewAny'       => ['FSD_administrator'],
        'view'          => ['FSD_administrator'],
        'create'        => ['FSD_administrator'],
    ];

    public bool $hasUpdate = false;
    public bool $hasDelete = false;
    public bool $hasRestore = false;
    public bool $hasForceDelete = false;

    public ?string $route = 'sfr.fsd.result-files';

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
