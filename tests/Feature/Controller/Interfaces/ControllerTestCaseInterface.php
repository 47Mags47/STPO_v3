<?php

namespace Tests\Feature\Controller\Interfaces;

interface ControllerTestCaseInterface
{
    public string $controllerClass {
        get;
        set;
    }

    public string $route {
        get;
        set;
    }

    public ?array $pageProps {
        get;
        set;
    }
}
