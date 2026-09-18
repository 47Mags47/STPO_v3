<?php

namespace Tests\Feature\Controller\Interfaces;

interface RESTControllerTestCaseInterface
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
