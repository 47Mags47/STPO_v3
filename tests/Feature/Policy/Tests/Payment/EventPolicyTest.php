<?php

namespace Tests\Feature\Policy\Tests\Payment;

use App\Models\Payment\Event;
use Tests\Feature\Policy\Cases\PolicyTestCase;

class EventPolicyTest
extends PolicyTestCase
{
    public string $modelClass = Event::class;
    public array $permissions = [
        'viewAny'       => ['payment_event_view'],
        'create'        => ['payment_event_view'],
        'update'        => ['payment_event_view'],
        'delete'        => ['payment_event_view'],
    ];

    public bool $hasView = false;
    public bool $hasRestore = false;
    public bool $hasForceDelete = false;

    public ?string $route = 'payment.events';
}
