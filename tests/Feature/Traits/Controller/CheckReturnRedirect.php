<?php

namespace Tests\Feature\Traits\Controller;

trait CheckReturnRedirect
{
    public function test_controller_method_store_return_redirect()
    {
        $this->checkStoreMethodExist();

        $response = $this
            ->post(route($this->route . '.store'), $this->createTestData());

        $response
            ->assertValid()
            ->assertStatus(302);
    }

    public function test_controller_method_update_return_redirect()
    {
        $this->checkUpdateMethodExist();

        $response = $this
            ->put(route($this->route . '.update', [$this->getParameterName() => $this->createTestRecord()]), $this->createTestData());

        $response
            ->assertValid()
            ->assertStatus(302);
    }

    public function test_controller_method_destroy_return_redirect()
    {
        $this->checkDestroyMethodExist();

        $response = $this
            ->delete(route($this->route . '.destroy', [$this->getParameterName() => $this->createTestRecord()]));

        $response
            ->assertValid()
            ->assertStatus(302);
    }
}
