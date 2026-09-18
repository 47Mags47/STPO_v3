<?php

namespace Tests\Feature\Controller\Traits;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

trait RESTControllerUseAuthorizesRequests
{
    protected function checkControllerUsesAuthorizesRequestsTrait(): bool
    {
        return in_array(AuthorizesRequests::class, class_uses_recursive($this->controllerClass));
    }

    public function test_controller_use_AuthorizesRequests_trait(): void
    {
        $this->assertTrue($this->checkControllerUsesAuthorizesRequestsTrait());
    }

    public function test_controller_implement_middleware_viewAny()
    {
        if(!$this->checkControllerUsesAuthorizesRequestsTrait())
            $this->markTestSkipped('Контроллер не реализует AuthorizesRequests trait');

        $this->assertTrue(in_array('can:viewAny,' . $this->modelClass, $this->getControllerMidlewares()));
    }

    public function test_controller_implement_middleware_view()
    {
        if(!$this->checkControllerUsesAuthorizesRequestsTrait())
            $this->markTestSkipped('Контроллер не реализует AuthorizesRequests trait');

        $this->assertTrue(in_array('can:view,' . $this->getRouteParameterName(), $this->getControllerMidlewares()));
    }

    public function test_controller_implement_middleware_create()
    {
        if(!$this->checkControllerUsesAuthorizesRequestsTrait())
            $this->markTestSkipped('Контроллер не реализует AuthorizesRequests trait');

        $this->assertTrue(in_array('can:create,' . $this->modelClass, $this->getControllerMidlewares()));
    }

    public function test_controller_implement_middleware_update()
    {
        if(!$this->checkControllerUsesAuthorizesRequestsTrait())
            $this->markTestSkipped('Контроллер не реализует AuthorizesRequests trait');

        $this->assertTrue(in_array('can:update,' . $this->getRouteParameterName(), $this->getControllerMidlewares()));
    }

    public function test_controller_implement_middleware_delete()
    {
        if(!$this->checkControllerUsesAuthorizesRequestsTrait())
            $this->markTestSkipped('Контроллер не реализует AuthorizesRequests trait');

        $this->assertTrue(in_array('can:delete,' . $this->getRouteParameterName(), $this->getControllerMidlewares()));
    }
}
