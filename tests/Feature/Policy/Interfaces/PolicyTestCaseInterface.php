<?php

namespace Tests\Feature\Policy\Interfaces;

interface PolicyTestCaseInterface
{
    public string $modelClass {
        get;
        set;
    }

    public string $policyClass {
        get;
        set;
    }

    public string $controllerClass {
        get;
        set;
    }

    public array $permissions {
        get;
        set;
    }
}
