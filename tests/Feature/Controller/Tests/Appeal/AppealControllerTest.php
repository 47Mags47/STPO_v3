<?php

namespace Tests\Feature\Controller\Tests\Appeal;

use App\Http\Controllers\Appeal\AppealController;
use App\Models\Appeal\Appeal;
use Override;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;

class AppealControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = AppealController::class;
    public string $modelClass = Appeal::class;
    public string $route = 'appeal.appeals';
    public array $pageComponents = [
        'show' => 'appeal.messages.index'
    ];

    public ?array $pageProps = [
        'index' => 'appeals',
        'show'  => 'appeal',
    ];

    public bool $hasEdit = false;
    public bool $hasUpdate = false;
    public bool $hasDestroy = false;

    #[Override]
    public function modifySendData(array $data): array
    {
        $send_data = [
            'comment' => $data['comment'],
            'theme_id' => $data['theme_id'],
        ];

        return $send_data;
    }

    #[Override]
    public function getStoreRedirectURL(?array $data = []): string
    {
        $record = Appeal::query()->latest('id')->first();
        return route('appeal.appeals.show', ['appeal' => $record]);
    }
}
