<?php

namespace Tests\Feature\Controller\Traits;

trait ControllerRESTMethodReturnRedirect
{
    public function test_controller_method_store_return_redirect()
    {
        $this->checkStoreMethodExist();
        $this->disableAuthMiddleware();

        $data = $this->createTestData();
        $response = $this->post(route($this->route . '.store'), $data);

        $response->assertStatus(302);
        $response->assertredirect(route($this->route . '.index'));
        $response->assertSessionHas('success');
        $response->assertSessionHas('success', 'Запись успешно создана');
    }

    public function test_controller_method_update_return_redirect()
    {
        $this->checkStoreMethodExist();
        $this->disableAuthMiddleware();

        $record = $this->createTestRecord();
        $data = $this->createTestData();
        $response = $this->put(route($this->route . '.update', [$this->getRouteParameterName() => $record]), $data);

        $response->assertStatus(302);
        $response->assertredirect(route($this->route . '.index'));
        $response->assertSessionHas('success', 'Запись успешно обновлена');
    }

    public function test_controller_method_destroy_return_redirect()
    {
        $this->checkStoreMethodExist();
        $this->disableAuthMiddleware();

        $record = $this->createTestRecord();
        $response = $this->delete(route($this->route . '.destroy', [$this->getRouteParameterName() => $record]));

        $response->assertStatus(302);
        $response->assertredirect(route($this->route . '.index'));
        $response->assertSessionHas('success');
        $response->assertSessionHas('success', 'Запись удалена');
    }
}
