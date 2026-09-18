<?php

namespace Tests\Feature\Interfaces\Controller;

// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

interface RESTFullControllerInterfacce
{
    public string $modelClass {
        get;
        set;
    }

    public string $route {
        get;
        set;
    }

    public array $props {
        get;
        set;
    }
}
