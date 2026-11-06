<?php

namespace Tests\Feature\Controller\Traits;

trait RouteReturnFlash
{
    ### Settings
    ##################################################
    public ?string $storeFlashMessage        = 'Запись успешно создана';
    public ?string $updateFlashMessage       = 'Запись успешно обновлена';
    public ?string $destroyFlashMessage      = 'Запись удалена';
    public ?string $restoreFlashMessage      = 'Запись успешно восстановлена';
    public ?string $forceDeleteFlashMessage  = 'Запись безвозвратно удалена';

    ### Methods
    ##################################################
    protected function checkStoreFlashExist(): bool
    {
        if($this->storeFlashMessage === null)
            $this->markTestSkipped('Пропуск проверки flash store');

        return $this->storeFlashMessage;
    }

    protected function checkUpdateFlashExist(): bool
    {
        if($this->updateFlashMessage === null)
            $this->markTestSkipped('Пропуск проверки flash update');

        return $this->updateFlashMessage;
    }

    protected function checkDestroyFlashExist(): bool
    {
        if($this->destroyFlashMessage === null)
            $this->markTestSkipped('Пропуск проверки flash destroy');

        return $this->destroyFlashMessage;
    }

    protected function checkRestoreFlashExist(): bool
    {
        if($this->restoreFlashMessage === null)
            $this->markTestSkipped('Пропуск проверки flash restore');

        return $this->restoreFlashMessage;
    }

    protected function checkForceDeleteFlashExist(): bool
    {
        if($this->forceDeleteFlashMessage === null)
            $this->markTestSkipped('Пропуск проверки flash force delete');

        return $this->forceDeleteFlashMessage;
    }

    ### Tests
    ##################################################
    public function test_route_return_flash__store()
    {
        $this->checkStoreMethodExist();
        $this->checkStoreFlashExist();

        $data = $this->createTestData();

        $response = $this->post(route($this->route . '.store', $this->getStoreRouteParams()), $data);
        $response->assertSessionHas('success');
        $response->assertSessionHas('success', $this->storeFlashMessage);
    }

    public function test_route_return_flash__update()
    {
        $this->checkUpdateMethodExist();
        $this->checkUpdateFlashExist();

        $data = $this->createTestData();

        $response = $this->put(route($this->route . '.update', $this->getUpdateRouteParams()), $data);
        $response->assertSessionHas('success');
        $response->assertSessionHas('success', $this->updateFlashMessage);
    }

    public function test_route_return_flash__destroy()
    {
        $this->checkDestroyMethodExist();
        $this->checkDestroyFlashExist();

        $response = $this->delete(route($this->route . '.destroy', $this->getDestroyRouteParams()));
        $response->assertSessionHas('success');
        $response->assertSessionHas('success', $this->destroyFlashMessage);
    }

    public function test_route_return_flash__restore()
    {
        $this->checkRestoreMethodExist();
        $this->checkRestoreFlashExist();

        $response = $this->post(route($this->route . '.restore', $this->getRestoreRouteParams()));
        $response->assertSessionHas('success');
        $response->assertSessionHas('success', $this->restoreFlashMessage);
    }

    public function test_route_return_flash__force_delete()
    {
        $this->checkForceDeleteMethodExist();
        $this->checkForceDeleteFlashExist();

        $response = $this->delete(route($this->route . '.force-delete', $this->getforceDeleteRouteParams()));
        $response->assertSessionHas('success');
        $response->assertSessionHas('success', $this->forceDeleteFlashMessage);
    }
}
