<?php

namespace Tests\Feature\Controller\Traits;

trait ControllerHasRESTMethod
{
    ### Tests
    ##################################################
    public function test_controller_has_method__index()
    {
        $this->checkIndexMethodExist();

        $this->assertTrue($this->checkControllerMethodExist('index'));
    }

    public function test_controller_has_method__create()
    {
        $this->checkCreateMethodExist();

        $this->assertTrue($this->checkControllerMethodExist('create'));
    }

    public function test_controller_has_store_method()
    {
        $this->checkStoreMethodExist();

        $this->assertTrue($this->checkControllerMethodExist('store'));
    }

    public function test_controller_has_method__show()
    {
        $this->checkShowMethodExist();

        $this->assertTrue($this->checkControllerMethodExist('show'));
    }

    public function test_controller_has_method__edit()
    {
        $this->checkEditMethodExist();

        $this->assertTrue($this->checkControllerMethodExist('edit'));
    }

    public function test_controller_has_method__update()
    {
        $this->checkUpdateMethodExist();

        $this->assertTrue($this->checkControllerMethodExist('update'));
    }

    public function test_controller_has_method__destroy()
    {
        $this->checkDestroyMethodExist();

        $this->assertTrue($this->checkControllerMethodExist('destroy'));
    }

    public function test_controller_has_method__restore()
    {
        $this->checkRestoreMethodExist();

        $this->assertTrue($this->checkControllerMethodExist('restore'));
    }

    public function test_controller_has_method__force_delete()
    {
        $this->checkForceDeleteMethodExist();

        $this->assertTrue($this->checkControllerMethodExist('forceDelete'));
    }
}
