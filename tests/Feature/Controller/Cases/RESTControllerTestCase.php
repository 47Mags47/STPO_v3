<?php

namespace Tests\Feature\Controller\Cases;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Controller\Cases\ControllerTestCase;
use Tests\Feature\Controller\Interfaces\RESTControllerTestCaseInterface;
use Tests\Feature\Controller\Traits\ControllerHasRESTMethod;
use Tests\Feature\Controller\Traits\ControllerRESTMethodReturnFlash;
use Tests\Feature\Controller\Traits\ControllerRESTMethodReturnInertiaPage;
use Tests\Feature\Controller\Traits\ControllerRESTMethodReturnInertiaProp;
use Tests\Feature\Controller\Traits\ControllerRESTMethodReturnRedirect;
use Tests\Feature\Controller\Traits\ControllerRESTMethodReturnStatus;
use Tests\Feature\Controller\Traits\ControllerRESTMethodsRecordActions;
use Tests\Feature\Controller\Traits\RESTControllerUseAuthorizesRequests;

abstract class RESTControllerTestCase
extends ControllerTestCase
implements RESTControllerTestCaseInterface
{
    use RefreshDatabase;

    use ControllerHasRESTMethod;

    use ControllerRESTMethodReturnStatus;
    use ControllerRESTMethodReturnInertiaPage;
    use ControllerRESTMethodReturnRedirect;
    use ControllerRESTMethodReturnFlash;
    use ControllerRESTMethodReturnInertiaProp;
    use ControllerRESTMethodsRecordActions;

    use RESTControllerUseAuthorizesRequests;

    ### Settings
    ##################################################
    // Методы контроллера
    public bool $hasIndex = true;
    public bool $hasCreate = true;
    public bool $hasStore = true;
    public bool $hasShow = true;
    public bool $hasEdit = true;
    public bool $hasUpdate = true;
    public bool $hasDestroy = true;
    public bool $hasRestore = false;
    public bool $hasForceDelete = false;

    // Middleware контроллера
    public bool $useAuthorizesRequests = true;

    // Inertia Компоненты страниц
    public array $pageComponents = [
        'index'     => null,
        'create'    => null,
        'show'      => null,
        'edit'      => null
    ];

    // Статусы ответов
    public int $indexResponseStatus         = 200;
    public int $createResponseStatus        = 200;
    public int $storeResponseStatus         = 302;
    public int $showResponseStatus          = 200;
    public int $editResponseStatus          = 200;
    public int $updateResponseStatus        = 302;
    public int $destroyResponseStatus       = 302;
    public int $restoreResponseStatus       = 302;
    public int $forceDeleteResponseStatus   = 302;

    ### Methods
    ##################################################
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

    protected function checkRestoreMethodExist()
    {
        if(!$this->hasRestore)
            $this->markTestSkipped('Пропуск проверки restore метода');

        return $this->hasRestore;
    }

    protected function checkForceDeleteMethodExist()
    {
        if(!$this->hasForceDelete)
            $this->markTestSkipped('Пропуск проверки forceDelete метода');

        return $this->hasForceDelete;
    }

    protected function getIndexPageComponent(): string
    {
        return $this->pageComponents['index'] !== null
            ? stringDotToSlash($this->pageComponents['index'])
            : stringDotToSlash($this->route) . '/index';
    }

    protected function getCreatePageComponent(): string
    {
        return $this->pageComponents['create'] !== null
            ? stringDotToSlash($this->pageComponents['create'])
            : stringDotToSlash($this->route) . '/create';
    }

    protected function getShowPageComponent(): string
    {
        return $this->pageComponents['show'] !== null
            ? stringDotToSlash($this->pageComponents['show'])
            : stringDotToSlash($this->route) . '/show';
    }

    protected function getEditPageComponent(): string
    {
        return $this->pageComponents['edit'] !== null
            ? stringDotToSlash($this->pageComponents['edit'])
            : stringDotToSlash($this->route) . '/edit';
    }
}
