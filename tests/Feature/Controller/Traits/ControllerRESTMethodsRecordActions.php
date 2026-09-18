<?php

namespace Tests\Feature\Controller\Traits;

use Inertia\Testing\AssertableInertia as Assert;

trait ControllerRESTMethodsRecordActions
{
    public function test_controller_method_store_create_record()
    {
        $this->checkStoreMethodExist();
        $this->disableAuthMiddleware();

        $data = $this->createTestData();
        $this->post(route($this->route . '.store'), $data);

        $this->assertDatabaseHas($this->modelClass::getTableName(), $data);
    }

    public function test_controller_method_show_return_record()
    {
        $this->checkShowMethodExist();
        $this->disableAuthMiddleware();

        $record = $this->createTestRecord();
        $response = $this
            ->get(route($this->route . '.show', [$this->getRouteParameterName() => $record]));

        $response->assertInertia(
            fn(Assert $page) => $page->has(
                $this->props['show'] . '.data',
                function (Assert $page) use ($record) {
                    foreach ($record->toResource()->toArray(request()) as $key => $value) {
                        $page->where($key, $value);
                    }

                    return $page;
                }
            )
        );
    }

    public function test_controller_method_update_edit_record()
    {
        $this->checkUpdateMethodExist();
        $this->disableAuthMiddleware();

        $record = $this->createTestRecord();
        $data = $this->createTestData();

        $this->put(route($this->route . '.update', [$this->getRouteParameterName() => $record]), $data);

        $this->assertDatabaseHas($this->modelClass::getTableName(), $data);
    }

    public function test_controller_method_destroy_delete_record() {
        $this->checkDestroyMethodExist();
        $this->disableAuthMiddleware();

        $record = $this->createTestRecord();
        $this->delete(route($this->route . '.destroy', [$this->getRouteParameterName() => $record]));

        $this->assertDatabaseMissing($this->modelClass::getTableName(), $record->toArray());
    }
}
