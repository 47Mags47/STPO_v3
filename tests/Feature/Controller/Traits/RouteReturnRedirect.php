<?php

namespace Tests\Feature\Controller\Traits;

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
    protected function getStoreRedirectRoute(): string
    {
        return $this->storeRedirectRoute ?? $this->route . '.index';
    }

    protected function getUpdateRedirectRoute(): string
    {
        return $this->storeReupdateRedirectRoutedirectRoute ?? $this->route . '.index';
    }

    protected function getDestroyRedirectRoute(): string
    {
        return $this->destroyRedirectRoute ?? $this->route . '.index';
    }

    protected function getRestoreRedirectRoute(): string
    {
        return $this->restoreRedirectRoute ?? $this->route . '.index';
    }

    protected function getForceDeleteRedirectRoute(): string
    {
        return $this->forceDeleteRedirectRoute ?? $this->route . '.index';
    }

    ### Tests
    ##################################################
    public function test_route_return_redirect__store()
    {
        $this->checkStoreMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $data = $this->createTestData();
        $response = $this->post(route($this->route . '.store', $this->getStoreRouteParams()), $data);
        $response->assertredirect(route($this->getStoreRedirectRoute(), $this->getIndexRouteParams()));
    }

    public function test_route_return_redirect__update()
    {
        $this->checkUpdateMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $data = $this->createTestData();
        $response = $this->put(route($this->route . '.update', $this->getUpdateRouteParams()), $data);
        $response->assertredirect(route($this->getUpdateRedirectRoute(), $this->getIndexRouteParams()));
    }

    public function test_route_return_redirect__destroy()
    {
        $this->checkDestroyMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $response = $this->delete(route($this->route . '.destroy', $this->getDestroyRouteParams()));
        if ($this->forceDeleteRedirectRoute !== null)
            $response->assertredirect(route($this->getDestroyRedirectRoute(), $this->getIndexRouteParams()));
        else
            $response->assertRedirectBack();
    }
    public function test_route_return_redirect__restore()
    {
        $this->checkRestoreMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $response = $this->post(route($this->route . '.restore', $this->getRestoreRouteParams()));
        if ($this->forceDeleteRedirectRoute !== null)
            $response->assertredirect(route($this->getRestoreRedirectRoute(), $this->getIndexRouteParams()));
        else
            $response->assertRedirectBack();
    }
    public function test_route_return_redirect__force_delete()
    {
        $this->checkForceDeleteMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $response = $this->delete(route($this->route . '.force-delete', $this->getforceDeleteRouteParams()));
        if ($this->forceDeleteRedirectRoute !== null)
            $response->assertredirect(route($this->getForceDeleteRedirectRoute(), $this->getIndexRouteParams()));
        else
            $response->assertRedirectBack();
    }
}
