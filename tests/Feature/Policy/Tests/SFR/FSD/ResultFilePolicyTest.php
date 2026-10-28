<?php

namespace Tests\Feature\Policy\Tests\SFR\FSD;

use App\Models\Base\UploadFile;
use App\Models\SFR\FSD\ResultFile;
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
    public function getRouteParams(?Model $record = null): array
    {
        $params = parent::getRouteParams($record);

        $record = $params[$this->getRouteParameterName()];

        $record->SFRFile->update(['file_id' => UploadFile::emptyFile()->file_id]);
        $params['SFRFile'] = $record->SFRFile->fresh();

        return $params;
    }
}
