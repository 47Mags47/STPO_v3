<?php

namespace Tests\Feature\Abstracts\Controller;

use App\Classes\BaseModel;
use App\Http\Middleware\CurrentDivisionMiddleware;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Interfaces\Controller\RESTFullControllerInterfacce;
use Tests\Feature\Traits\Controller\CheckPolicyMiddleware;
use Tests\Feature\Traits\Controller\ControllerHasMethod;
use Tests\Feature\Traits\Controller\ControllerMethodReturnPage;
use Tests\Feature\Traits\Controller\CheckRecordAction;
use Tests\Feature\Traits\Controller\WithOutAuthMiddleware;

abstract class RESTFullAbstractController
extends BaseAbstractController
implements RESTFullControllerInterfacce
{
    use RefreshDatabase;

    // use WithOutAuthMiddleware;

    use ControllerHasMethod;
    use ControllerMethodReturnPage;
    // use CheckRecordAction;
    // use CheckPolicyMiddleware;

    ### Settings
    ##################################################
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(CurrentDivisionMiddleware::class);
        $this->withoutMiddleware(HandleInertiaRequests::class);
    }

    public bool $hasIndex = true;
    public bool $hasCreate = true;
    public bool $hasStore = true;
    public bool $hasShow = true;
    public bool $hasEdit = true;
    public bool $hasUpdate = true;
    public bool $hasDestroy = true;

    ### Methods
    ##################################################
    protected function createTestRecord(): BaseModel
    {
        return $this->modelClass::factory()->create();
    }

    protected function createTestData(): array
    {
        return $this->modelClass::factory()->make()->toArray();
    }

    protected function getParameterName(): string
    {
        return strtolower(class_basename($this->modelClass));
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
