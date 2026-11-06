<?php

namespace Tests\Feature\Controller\Cases;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Override;
use Tests\Feature\Controller\Interfaces\ControllerTestCaseInterface;
use Tests\Feature\Controller\Traits\ControllerHasRESTMethod;
use Tests\Feature\Controller\Traits\RouteReturnFlash;
use Tests\Feature\Controller\Traits\RouteReturnInertiaPage;
use Tests\Feature\Controller\Traits\RouteReturnInertiaProp;
use Tests\Feature\Controller\Traits\RouteReturnRedirect;
use Tests\Feature\Controller\Traits\RouteReturnStatus;
use Tests\Feature\TestCase;

abstract class ControllerTestCase
extends TestCase
implements ControllerTestCaseInterface
{
    use RefreshDatabase;

    use ControllerHasRESTMethod;

    use RouteReturnStatus;
    use RouteReturnInertiaPage;
    use RouteReturnRedirect;
    use RouteReturnFlash;
    use RouteReturnInertiaProp;

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

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->disableAuthMiddleware();
        $this->runProdSeeder();
        $this->actingAsUser();
    }

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
}
