<?php

namespace Tests\Feature\Controller\Interfaces;

// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

interface ControllerTestCaseInterface
{
    public string $controllerClass {
        get;
        set;
    }
}
