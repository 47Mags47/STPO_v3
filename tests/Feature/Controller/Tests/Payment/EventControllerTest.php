<?php

namespace Tests\Feature\Controller\Tests\Payment;

use App\Http\Controllers\Payment\EventController;
use App\Models\Payment\Event;
use Tests\Feature\Controller\Cases\RESTControllerTestCase;

class EventControllerTest extends RESTControllerTestCase
{
    public string $controllerClass = EventController::class;
    public string $modelClass = Event::class;
    public string $route = 'payment.events';

    public array $pageProps = [
        'index' => 'events',
        'edit'  => 'event',
    ];

    public bool $hasShow = false;
}
