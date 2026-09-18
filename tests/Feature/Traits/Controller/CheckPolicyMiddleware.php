<?php

namespace Tests\Feature\Traits\Controller;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

trait CheckPolicyMiddleware
{
    ### Methods
    ##################################################
    /**
     * Проверяет реализует ли контроллер trait AuthorizesRequests
     *
     * @return boolean
     */
    protected function checkControllerUsesAuthorizesRequestsTrait(): bool
    {
        return in_array(AuthorizesRequests::class, class_uses_recursive($this->controllerClass));
    }

    /**
     * Возвращает массив middleware, реализуемы контроллером
     *
     * @return array
     */
    protected function getControllerMidlewares(): array
    {
        $middlewares = new ($this->controllerClass)()->getMiddleware();
        return collect($middlewares)->map(fn($middleware) => $middleware['middleware'])->toArray();
    }

    ### Tests
    ##################################################
    public function test_controller_uses_AuthorizesRequests_trait(): void
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
        $this->assertTrue(in_array('can:view,' . $this->getParameterName(), $this->getControllerMidlewares()));
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
        $this->assertTrue(in_array('can:update,' . $this->getParameterName(), $this->getControllerMidlewares()));
    }

    public function test_controller_implement_middleware_delete()
    {
        if(!$this->checkControllerUsesAuthorizesRequestsTrait())
            $this->markTestSkipped('Контроллер не реализует AuthorizesRequests trait');
        $this->assertTrue(in_array('can:delete,' . $this->getParameterName(), $this->getControllerMidlewares()));
    }
}
