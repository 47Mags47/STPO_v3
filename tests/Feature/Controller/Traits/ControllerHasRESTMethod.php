<?php

namespace Tests\Feature\Controller\Traits;

trait ControllerHasRESTMethod
{
    ### Tests
    ##################################################
    public function test_controller_has_index_method()
    {
        $this->checkIndexMethodExist();

        $this->assertTrue($this->checkControllerMethodExist('index'));
    }

    public function test_controller_has_create_method()
    {
        $this->checkCreateMethodExist();

        $this->assertTrue($this->checkControllerMethodExist('create'));
    }

    public function test_controller_has_store_method()
    {
        $this->checkStoreMethodExist();

        $this->assertTrue($this->checkControllerMethodExist('store'));
    }

    public function test_controller_has_show_method()
    {
        $this->checkShowMethodExist();

        $this->assertTrue($this->checkControllerMethodExist('show'));
    }

    public function test_controller_has_edit_method()
    {
        $this->checkEditMethodExist();

        $this->assertTrue($this->checkControllerMethodExist('edit'));
    }

    public function test_controller_has_update_method()
    {
        $this->checkUpdateMethodExist();

        $this->assertTrue($this->checkControllerMethodExist('update'));
    }

    public function test_controller_has_destroy_method()
    {
        $this->checkDestroyMethodExist();

        $this->assertTrue($this->checkControllerMethodExist('destroy'));
    }
}
