<?php

namespace Tests\Feature\Controller\Traits;

trait RouteReturnStatus
{
    ### Settings
    ##################################################
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

    ### Tests
    ##################################################
    public function test_route_return_necessary_status__index()
    {
        $this->checkIndexMethodExist();

        $response = $this->get(route($this->route . '.index', $this->getIndexRouteParams()));
        $response->assertStatus($this->indexResponseStatus);
    }

    public function test_route_return_necessary_status__create()
    {
        $this->checkCreateMethodExist();

        $response = $this->get(route($this->route . '.create', $this->getCreateRouteParams()));
        $response->assertStatus($this->createResponseStatus);
    }

    public function test_route_return_necessary_status__store()
    {
        $this->checkStoreMethodExist();

        $data = $this->createTestData();
        $response = $this->post(route($this->route . '.store', $this->getStoreRouteParams()), $data);
        $response->assertStatus($this->storeResponseStatus);
    }

    public function test_route_return_necessary_status__show() {
        $this->checkShowMethodExist();

        $response = $this->get(route($this->route . '.show', $this->getShowRouteParams()));
        $response->assertStatus($this->showResponseStatus);
    }

    public function test_route_return_necessary_status__edit() {
        $this->checkEditMethodExist();

        $response = $this->get(route($this->route . '.edit', $this->getEditRouteParams()));
        $response->assertStatus($this->editResponseStatus);
    }

    public function test_route_return_necessary_status__update() {
        $this->checkUpdateMethodExist();

        $data = $this->createTestData();
        $response = $this->put(route($this->route . '.update', $this->getUpdateRouteParams()), $data);
        $response->assertStatus($this->updateResponseStatus);
    }

    public function test_route_return_necessary_status__destroy()
    {
        $this->checkDestroyMethodExist();

        $response = $this->delete(route($this->route . '.destroy', $this->getDestroyRouteParams()));
        $response->assertStatus($this->destroyResponseStatus);
    }

    public function test_route_return_necessary_status__restore()
    {
        $this->checkRestoreMethodExist();

        $response = $this->post(route($this->route . '.restore', $this->getRestoreRouteParams()));
        $response->assertStatus($this->restoreResponseStatus);
    }

    public function test_route_return_necessary_status__force_delete()
    {
        $this->checkForceDeleteMethodExist();

        $response = $this->delete(route($this->route . '.force-delete', $this->getforceDeleteRouteParams()));
        $response->assertStatus($this->forceDeleteResponseStatus);
    }
}
