<?php

namespace Tests\Feature\Controller\Traits;

trait ControllerRESTMethodReturnRedirect
{
    public string $storeFlashMessage = 'Запись успешно создана';
    public string $updateFlashMessage = 'Запись успешно обновлена';
    public string $destroyFlashMessage = 'Запись удалена';
    public string $restoreFlashMessage = 'Запись успешно восстановлена';
    public string $forceDeleteFlashMessage = 'Запись безвозвратно удалена';

    public function test_controller_method_store_return_redirect()
    {
        $this->checkStoreMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $data = $this->createTestData();
        $response = $this->post(route($this->route . '.store', $this->getStoreRouteParams()), $data);

        $response->assertStatus(302);
        $response->assertredirect(route($this->route . '.index', $this->getIndexRouteParams()));
    }

    public function test_controller_method_store_return_flash()
    {
        $this->checkStoreMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $data = $this->createTestData();
        $response = $this->post(route($this->route . '.store', $this->getStoreRouteParams()), $data);

        $response->assertSessionHas('success');
        $response->assertSessionHas('success', $this->storeFlashMessage);
    }

    public function test_controller_method_update_return_redirect()
    {
        $this->checkUpdateMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $data = $this->createTestData();
        $response = $this->put(route($this->route . '.update', $this->getUpdateRouteParams()), $data);

        $response->assertStatus(302);
        $response->assertredirect(route($this->route . '.index'));
    }

    public function test_controller_method_update_return_flash()
    {
        $this->checkUpdateMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $data = $this->createTestData();
        $response = $this->put(route($this->route . '.update', $this->getUpdateRouteParams()), $data);

        $response->assertSessionHas('success');
        $response->assertSessionHas('success', $this->updateFlashMessage);
    }

    public function test_controller_method_destroy_return_redirect()
    {
        $this->checkDestroyMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $response = $this->delete(route($this->route . '.destroy', $this->getDestroyRouteParams()));
        $response->assertStatus(302);
        $response->assertRedirectBack();
    }

    public function test_controller_method_destroy_return_flash()
    {
        $this->checkDestroyMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $response = $this->delete(route($this->route . '.destroy', $this->getDestroyRouteParams()));

        $response->assertSessionHas('success');
        $response->assertSessionHas('success', $this->destroyFlashMessage);
    }

    public function test_controller_method_restore_return_redirect()
    {
        $this->checkRestoreMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $response = $this->post(route($this->route . '.restore', $this->getRestoreRouteParams()));
        $response->assertStatus(302);
        $response->assertRedirectBack();
    }

    public function test_controller_method_restore_return_flash()
    {
        $this->checkRestoreMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $response = $this->post(route($this->route . '.restore', $this->getRestoreRouteParams()));
        $response->assertSessionHas('success');
        $response->assertSessionHas('success', $this->restoreFlashMessage);
    }

    public function test_controller_method_force_delete_return_redirect()
    {
        $this->checkForceDeleteMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $response = $this->delete(route($this->route . '.force-delete', $this->getforceDeleteRouteParams()));
        $response->assertStatus(302);
        $response->assertRedirectBack();
    }

    public function test_controller_method_force_delete_return_flash()
    {
        $this->checkForceDeleteMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $response = $this->delete(route($this->route . '.force-delete', $this->getforceDeleteRouteParams()));
        $response->assertSessionHas('success');
        $response->assertSessionHas('success', $this->forceDeleteFlashMessage);
    }
}
