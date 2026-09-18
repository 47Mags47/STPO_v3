<?php

namespace Tests\Feature\Abstracts\Controller;

use App\Models\Base\User;
use Tests\Feature\Interfaces\Controller\BaseControllerInterfacce;
use Tests\TestCase;

abstract class BaseAbstractController
extends TestCase
implements BaseControllerInterfacce
{
    ### Methods
    ##################################################
    /**
     * Проверяет существование метода в контроллере
     *
     * @param string $method
     * @return boolean
     */
    protected function checkControllerMethodExist(string $method): bool
    {
        return method_exists($this->controllerClass, $method);
    }

    protected function createTestUser(): User
    {
        return User::factory()->create();
    }
}
