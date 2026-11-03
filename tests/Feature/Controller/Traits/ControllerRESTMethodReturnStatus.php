<?php

namespace Tests\Feature\Controller\Traits;

trait ControllerRESTMethodReturnStatus
{
    public function test_controller_method_index_return_status_200()
    {
        $this->checkIndexMethodExist();

        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $response = $this->get(route($this->route . '.index', $this->getIndexRouteParams()));

        $response->assertStatus(200);
    }

    public function test_controller_method_create_return_status_200()
    {
        $this->checkCreateMethodExist();

        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $response = $this->get(route($this->route . '.create', $this->getCreateRouteParams()));

        $response->assertStatus(200);
    }

    public function test_controller_method_show_return_status_200() {
        $this->checkShowMethodExist();

        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $record = $this->createTestRecord();
        $response = $this->get(route($this->route . '.show', $this->getShowRouteParams(record: $record)));

        $response->assertStatus(200);
    }

    public function test_controller_method_edit_return_status_200() {
        $this->checkEditMethodExist();

        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $record = $this->createTestRecord();
        $response = $this->get(route($this->route . '.edit', $this->getEditRouteParams(record: $record)));

        $response->assertStatus(200);
    }
}
