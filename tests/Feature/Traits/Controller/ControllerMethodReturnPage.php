<?php

namespace Tests\Feature\Traits\Controller;

trait ControllerMethodReturnPage
{
    public function test_controller_method_index_return_page()
    {
        $this->checkIndexMethodExist();

        $response = $this
            ->get(route($this->route . '.index'));

        dd($response);

        $response->assertInertia();
        $response->assertStatus(200);
    }

    public function test_controller_method_create_return_page()
    {
        $this->checkCreateMethodExist();

        $response = $this
            ->get(route($this->route . '.create'));

        $response->assertInertia();
        $response->assertStatus(200);
    }

    public function test_controller_method_show_return_page()
    {
        $this->checkShowMethodExist();

        $response = $this
            ->get(route($this->route . '.show', [$this->getParameterName() => $this->createTestRecord()]));

        $response->assertInertia();
        $response->assertStatus(200);
    }

    public function test_controller_method_edit_return_page()
    {
        $this->checkEditMethodExist();

        $response = $this
            ->get(route($this->route . '.edit', [$this->getParameterName() => $this->createTestRecord()]));

        $response->assertInertia();
        $response->assertStatus(200);
    }
}
