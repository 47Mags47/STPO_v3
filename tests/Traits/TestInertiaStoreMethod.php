<?php

namespace Tests\Traits;

trait TestInertiaStoreMethod
{
    public function test_store_method_exist()
    {
        $this->checkMethodExistance('store');
    }

    public function test_store_method_return_302()
    {
        $this->getStoreResponse()->assertStatus(302);
    }

    public function test_store_method_redirect_to_index_page()
    {
        $this->getStoreResponse()->assertRedirect(route($this->routeName . '.index'));
    }

    public function test_store_method_return_session_success()
    {
        $this->getStoreResponse()->assertSessionHas('succes', 'Запись успешно создана');
    }

    public function test_store_method_create_record_in_the_database()
    {
        $payload = $this->getPayload();
        $this->sendStoreRequest($payload);

        $this->assertDatabaseHas($this->model::getTableName(), $payload);
    }
}
