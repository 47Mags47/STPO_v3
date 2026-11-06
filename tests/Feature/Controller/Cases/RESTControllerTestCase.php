<?php

namespace Tests\Feature\Controller\Cases;

use Tests\Feature\Controller\Cases\ControllerTestCase;
use Tests\Feature\Controller\Interfaces\RESTControllerTestCaseInterface;
use Tests\Feature\Controller\Traits\ControllerRESTMethodsRecordActions;
use Tests\Feature\Controller\Traits\RESTControllerUseAuthorizesRequests;

abstract class RESTControllerTestCase
extends ControllerTestCase
implements RESTControllerTestCaseInterface
{
    use ControllerRESTMethodsRecordActions;
    use RESTControllerUseAuthorizesRequests;

    ### Settings
    ##################################################
    public bool $useAuthorizesRequests = true;

    ### Methods
    ##################################################
    protected function getControllerMidlewares(): array
    {
        $middlewares = new ($this->controllerClass)()->getMiddleware();
        return collect($middlewares)->map(fn($middleware) => $middleware['middleware'])->toArray();
    }
}
