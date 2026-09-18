<?php

namespace Tests\Feature\Interfaces\Controller;

// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

interface BaseControllerInterfacce
{
    public string $controllerClass {
        get;
        set;
    }
}
