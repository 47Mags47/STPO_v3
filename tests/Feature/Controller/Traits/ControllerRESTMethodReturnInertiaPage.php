<?php

namespace Tests\Feature\Controller\Traits;

use Inertia\Testing\AssertableInertia as Assert;

trait ControllerRESTMethodReturnInertiaPage
{
    public function test_controller_method_index_return_inertia_page()
    {
        $this->checkIndexMethodExist();

        $this->disableAuthMiddleware();

        $response = $this->get(route($this->route . '.index', $this->getIndexRouteParams()));
        $response->assertInertia(fn(Assert $page) => $page->component($this->getIndexPageComponent()));
    }

    public function test_controller_method_create_return_inertia_page()
    {
        $this->checkCreateMethodExist();

        $this->disableAuthMiddleware();

        $response = $this->get(route($this->route . '.create', $this->getCreateRouteParams()));
        $response->assertInertia(fn(Assert $page) => $page->component($this->getCreatePageComponent()));
    }

    public function test_controller_method_show_return_inertia_page()
    {
        $this->checkShowMethodExist();

        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $record = $this->createTestRecord();

        $response = $this->get(route($this->route . '.show', $this->getShowRouteParams(record: $record)));
        $response->assertInertia(fn(Assert $page) => $page->component($this->getShowPageComponent()));
    }

    public function test_controller_method_edit_return_inertia_page()
    {
        $this->checkEditMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $record = $this->createTestRecord();

        $response = $this->get(route($this->route . '.edit', $this->getEditRouteParams(record: $record)));
        $response->assertInertia(fn(Assert $page) => $page->component($this->getEditPageComponent()));
    }
}
