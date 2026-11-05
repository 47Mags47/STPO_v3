<?php

namespace Tests\Feature\Controller\Traits;

trait ControllerRESTMethodReturnRedirect
{
    public string $storeFlashMessage = 'Запись успешно создана';
    public string $updateFlashMessage = 'Запись успешно обновлена';
    public string $destroyFlashMessage = 'Запись удалена';
    public string $restoreFlashMessage = 'Запись успешно восстановлена';
    public string $forceDeleteFlashMessage = 'Запись безвозвратно удалена';

    public function test_route_return_redirect__store()
    {
        $this->checkStoreMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $data = $this->createTestData();
        $response = $this->post(route($this->route . '.store', $this->getStoreRouteParams()), $data);
        $response->assertredirect(route($this->route . '.index', $this->getIndexRouteParams()));
    }

    public function test_route_return_redirect__update()
    {
        $this->checkUpdateMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $data = $this->createTestData();
        $response = $this->put(route($this->route . '.update', $this->getUpdateRouteParams()), $data);
        $response->assertredirect(route($this->route . '.index'));
    }

    public function test_route_return_redirect__destroy()
    {
        $this->checkDestroyMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $response = $this->delete(route($this->route . '.destroy', $this->getDestroyRouteParams()));
        $response->assertRedirectBack();
    }
    public function test_route_return_redirect__restore()
    {
        $this->checkRestoreMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $response = $this->post(route($this->route . '.restore', $this->getRestoreRouteParams()));
        $response->assertRedirectBack();
    }
    public function test_route_return_redirect__force_delete()
    {
        $this->checkForceDeleteMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $response = $this->delete(route($this->route . '.force-delete', $this->getforceDeleteRouteParams()));
        $response->assertRedirectBack();
    }
}
