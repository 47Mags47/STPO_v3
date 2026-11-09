<?php

namespace Tests\Feature\Policy\Tests\Payment;

use App\Models\Payment\PaymentFile;
use Tests\Feature\Policy\Cases\PolicyTestCase;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment\Event;
use Override;

class PaymentFilePolicyTest extends PolicyTestCase
{
    public string $modelClass = PaymentFile::class;
    public array $permissions = [
        'viewAny'       => ['payment_file_upload'],
        'create'        => ['payment_file_upload'],
        'delete'        => ['payment_file_upload'],
    ];

    public bool $hasView = false;
    public bool $hasEdit = false;
    public bool $hasUpdate = false;
    public bool $hasForceDelete = false;
    public bool $hasRestore = false;

    public ?string $route = 'payment.payment-files';

    #[Override]
    public function modifyRouteParams(?array $params = [], ?Model $record = null): array
    {
        $params['event'] = $record !== null
            ? $record->event->id
            : Event::randomOrCreate();

        return $params;
    }
}
