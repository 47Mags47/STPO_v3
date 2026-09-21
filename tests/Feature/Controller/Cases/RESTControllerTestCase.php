<?php

namespace Tests\Feature\Controller\Cases;

use App\Classes\BaseModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Controller\Cases\ControllerTestCase;
use Tests\Feature\Controller\Interfaces\RESTControllerTestCaseInterface;
use Tests\Feature\Controller\Traits\ControllerHasRESTMethod;
use Tests\Feature\Controller\Traits\ControllerRESTMethodReturnPage;
use Tests\Feature\Controller\Traits\ControllerRESTMethodReturnRedirect;
use Tests\Feature\Controller\Traits\ControllerRESTMethodsRecordActions;
use Tests\Feature\Controller\Traits\RESTControllerUseAuthorizesRequests;

abstract class RESTControllerTestCase
extends ControllerTestCase
implements RESTControllerTestCaseInterface
{
    use RefreshDatabase;

    use ControllerHasRESTMethod;
    use ControllerRESTMethodReturnPage;
    use ControllerRESTMethodReturnRedirect;
    use ControllerRESTMethodsRecordActions;
    use RESTControllerUseAuthorizesRequests;

    ### Settings
    ##################################################
    public bool $hasIndex = true;
    public bool $hasCreate = true;
    public bool $hasStore = true;
    public bool $hasShow = true;
    public bool $hasEdit = true;
    public bool $hasUpdate = true;
    public bool $hasDestroy = true;

    ### Methods
    ##################################################
    protected function getRouteParameterName(): string
    {
        return strtolower(class_basename($this->modelClass));
    }

    protected function getControllerMidlewares(): array
    {
        $middlewares = new ($this->controllerClass)()->getMiddleware();
        return collect($middlewares)->map(fn($middleware) => $middleware['middleware'])->toArray();
    }

    protected function checkIndexMethodExist()
    {
        if(!$this->hasIndex)
            $this->markTestSkipped('Пропуск проверки index метода');

        return $this->hasIndex;
    }

    protected function checkCreateMethodExist()
    {
        if(!$this->hasCreate)
            $this->markTestSkipped('Пропуск проверки create метода');

        return $this->hasCreate;
    }

    protected function checkStoreMethodExist()
    {
        if(!$this->hasStore)
            $this->markTestSkipped('Пропуск проверки store метода');

        return $this->hasStore;
    }

    protected function checkShowMethodExist()
    {
        if(!$this->hasShow)
            $this->markTestSkipped('Пропуск проверки show метода');

        return $this->hasShow;
    }

    protected function checkEditMethodExist()
    {
        if(!$this->hasEdit)
            $this->markTestSkipped('Пропуск проверки edit метода');

        return $this->hasEdit;
    }

    protected function checkUpdateMethodExist()
    {
        if(!$this->hasUpdate)
            $this->markTestSkipped('Пропуск проверки update метода');

        return $this->hasUpdate;
    }

    protected function checkDestroyMethodExist()
    {
        if(!$this->hasDestroy)
            $this->markTestSkipped('Пропуск проверки destroy метода');

        return $this->hasDestroy;
    }
}
