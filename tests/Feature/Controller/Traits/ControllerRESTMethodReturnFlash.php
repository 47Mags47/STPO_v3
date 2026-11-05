<?php

namespace Tests\Feature\Controller\Traits;

trait ControllerRESTMethodReturnFlash
{
    public string $storeFlashMessage = 'Запись успешно создана';
    public string $updateFlashMessage = 'Запись успешно обновлена';
    public string $destroyFlashMessage = 'Запись удалена';
    public string $restoreFlashMessage = 'Запись успешно восстановлена';
    public string $forceDeleteFlashMessage = 'Запись безвозвратно удалена';

    public function test_route_return_flash__store()
    {
        $this->checkStoreMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $data = $this->createTestData();
        $response = $this->post(route($this->route . '.store', $this->getStoreRouteParams()), $data);

        $response->assertSessionHas('success');
        $response->assertSessionHas('success', $this->storeFlashMessage);
    }

    public function test_route_return_flash__update()
    {
        $this->checkUpdateMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $data = $this->createTestData();
        $response = $this->put(route($this->route . '.update', $this->getUpdateRouteParams()), $data);

        $response->assertSessionHas('success');
        $response->assertSessionHas('success', $this->updateFlashMessage);
    }

    public function test_route_return_flash__destroy()
    {
        $this->checkDestroyMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $response = $this->delete(route($this->route . '.destroy', $this->getDestroyRouteParams()));

        $response->assertSessionHas('success');
        $response->assertSessionHas('success', $this->destroyFlashMessage);
    }

    public function test_route_return_flash__restore()
    {
        $this->checkRestoreMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $response = $this->post(route($this->route . '.restore', $this->getRestoreRouteParams()));
        $response->assertSessionHas('success');
        $response->assertSessionHas('success', $this->restoreFlashMessage);
    }

    public function test_route_return_flash__force_delete()
    {
        $this->checkForceDeleteMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $response = $this->delete(route($this->route . '.force-delete', $this->getforceDeleteRouteParams()));
        $response->assertSessionHas('success');
        $response->assertSessionHas('success', $this->forceDeleteFlashMessage);
    }
}
