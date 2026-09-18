<?php

namespace Tests\Feature\Controller\Traits;

use Inertia\Testing\AssertableInertia as Assert;

trait ControllerRESTMethodReturnPage
{
    public function test_controller_method_index_return_page()
    {
        $this->checkIndexMethodExist();
        $this->disableAuthMiddleware();

        $response = $this->get(route($this->route . '.index'));

        $response->assertStatus(200);
        $response->assertInertia(fn(Assert $page) => $page
            ->component(str_replace('.', '/', $this->route) . '/index')
            ->has($this->props['index'])
            ->has($this->props['index'] . '.data')
        );
    }

    public function test_controller_method_create_return_page()
    {
        $this->checkCreateMethodExist();
        $this->disableAuthMiddleware();

        $response = $this->get(route($this->route . '.create'));

        $response->assertStatus(200);
        $response->assertInertia(fn(Assert $page) => $page
            ->component(str_replace('.', '/', $this->route) . '/create')
        );
    }

    public function test_controller_method_show_return_page()
    {
        $this->checkShowMethodExist();
        $this->disableAuthMiddleware();

        $response = $this->get(route($this->route . '.show', [$this->getRouteParameterName() => $this->createTestRecord()]));

        $response->assertStatus(200);
        $response->assertInertia(fn(Assert $page) => $page
            ->component(str_replace('.', '/', $this->route) . '/show')
        );
    }

    public function test_controller_method_edit_return_page()
    {
        $this->checkEditMethodExist();
        $this->disableAuthMiddleware();

        $response = $this->get(route($this->route . '.edit', [$this->getRouteParameterName() => $this->createTestRecord()]));

        $response->assertStatus(200);
        $response->assertInertia(fn(Assert $page) => $page
            ->component(str_replace('.', '/', $this->route) . '/edit')
        );
    }
}
