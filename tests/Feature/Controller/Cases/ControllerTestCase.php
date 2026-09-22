<?php

namespace Tests\Feature\Controller\Cases;

use App\Models\Base\User;
use Tests\Feature\Controller\Interfaces\ControllerTestCaseInterface;
use Tests\Feature\TestCase;

abstract class ControllerTestCase
extends TestCase
implements ControllerTestCaseInterface
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
