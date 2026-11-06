<?php

namespace Tests\Feature\Controller\Traits;

use App\Classes\BaseModel;

trait RouteReturnRedirect
{
    ### Settings
    ##################################################
    // Статусы ответов
    public ?string $storeRedirectRoute         = null;
    public ?string $updateRedirectRoute        = null;
    public ?string $destroyRedirectRoute       = null;
    public ?string $restoreRedirectRoute       = null;
    public ?string $forceDeleteRedirectRoute   = null;

    ### Methods
    ##################################################
    public function getStoreRedirectURL(?array $data = []): string
    {
        return route($this->storeRedirectRoute ?? $this->route . '.index', $this->getIndexRouteParams());
    }

    public function getUpdateRedirectURL(?BaseModel $record = null): string
    {
        return route($this->updateRedirectRoute ?? $this->route . '.index', $this->getIndexRouteParams());
    }

    public function getDestroyRedirectURL(?BaseModel $record = null): string
    {
        return route($this->destroyRedirectRoute ?? $this->route . '.index', $this->getIndexRouteParams());
    }

    public function getRestoreRedirectURL(?BaseModel $record = null): string
    {
        return route($this->restoreRedirectRoute ?? $this->route . '.index', $this->getIndexRouteParams());
    }

    public function getForceDeleteRedirectURL(?BaseModel $record = null): string
    {
        return route($this->forceDeleteRedirectRoute ?? $this->route . '.index', $this->getIndexRouteParams());
    }

    ### Tests
    ##################################################
    public function test_route_return_redirect__store()
    {
        $this->checkStoreMethodExist();

        $data = $this->createTestData();
        $response = $this->post(route($this->route . '.store', $this->getStoreRouteParams()), $data);
        $response->assertRedirect($this->getStoreRedirectURL());
    }

    public function test_route_return_redirect__update()
    {
        $this->checkUpdateMethodExist();

        $data = $this->createTestData();
        $record = $this->createTestRecord();
        $response = $this->put(route($this->route . '.update', $this->getUpdateRouteParams($record)), $data);
        $response->assertRedirect($this->getUpdateRedirectURL($record));
    }

    public function test_route_return_redirect__destroy()
    {
        $this->checkDestroyMethodExist();

        $record = $this->createTestRecord();
        $response = $this->delete(route($this->route . '.destroy', $this->getDestroyRouteParams($record)));
        if ($this->forceDeleteRedirectRoute !== null)
            $response->assertRedirect($this->getDestroyRedirectURL($record));
        else
            $response->assertRedirectBack();
    }
    public function test_route_return_redirect__restore()
    {
        $this->checkRestoreMethodExist();

        $record = $this->createTestRecord();
        $response = $this->post(route($this->route . '.restore', $this->getRestoreRouteParams($record)));
        if ($this->forceDeleteRedirectRoute !== null)
            $response->assertRedirect($this->getRestoreRedirectURL($record));
        else
            $response->assertRedirectBack();
    }
    public function test_route_return_redirect__force_delete()
    {
        $this->checkForceDeleteMethodExist();

        $record = $this->createTestRecord();
        $response = $this->delete(route($this->route . '.force-delete', $this->getforceDeleteRouteParams($record)));
        if ($this->forceDeleteRedirectRoute !== null)
            $response->assertRedirect($this->getForceDeleteRedirectURL($record));
        else
            $response->assertRedirectBack();
    }
}
