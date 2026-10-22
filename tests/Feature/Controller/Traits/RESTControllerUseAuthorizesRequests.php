<?php

namespace Tests\Feature\Controller\Traits;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

trait RESTControllerUseAuthorizesRequests
{
    protected function checkControllerUsesAuthorizesRequestsTrait(): bool
    {
        if(!$this->useAuthorizesRequests)
            $this->markTestSkipped('Пропущена проверка AuthorizesRequests trait');

        $result = in_array(AuthorizesRequests::class, class_uses_recursive($this->controllerClass));
        if(!$result)
            $this->markTestSkipped('Контроллер не реализует AuthorizesRequests trait');

        return $result;
    }

    public function test_controller_use_AuthorizesRequests_trait(): void
    {
        if(!$this->useAuthorizesRequests)
            $this->markTestSkipped('Пропущена проверка AuthorizesRequests trait');

        $this->assertTrue(in_array(AuthorizesRequests::class, class_uses_recursive($this->controllerClass)), 'Контроллер не реализует AuthorizesRequests trait');
    }

    public function test_controller_implement_middleware_viewAny()
    {
        $this->checkControllerUsesAuthorizesRequestsTrait();

        $this->assertTrue(in_array('can:viewAny,' . $this->modelClass, $this->getControllerMidlewares()));
    }

    public function test_controller_implement_middleware_create()
    {
        $this->checkControllerUsesAuthorizesRequestsTrait();

        $this->assertTrue(in_array('can:create,' . $this->modelClass, $this->getControllerMidlewares()));
    }

    public function test_controller_implement_middleware_view()
    {
        $this->checkControllerUsesAuthorizesRequestsTrait();

        $this->assertTrue(in_array('can:view,' . $this->getRouteParameterName(), $this->getControllerMidlewares()));
    }

    public function test_controller_implement_middleware_update()
    {
        $this->checkControllerUsesAuthorizesRequestsTrait();

        $this->assertTrue(in_array('can:update,' . $this->getRouteParameterName(), $this->getControllerMidlewares()));
    }

    public function test_controller_implement_middleware_delete()
    {
        $this->checkControllerUsesAuthorizesRequestsTrait();

        $this->assertTrue(in_array('can:delete,' . $this->getRouteParameterName(), $this->getControllerMidlewares()));
    }
}
