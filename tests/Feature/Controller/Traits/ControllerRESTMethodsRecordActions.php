<?php

namespace Tests\Feature\Controller\Traits;

use Inertia\Testing\AssertableInertia as Assert;

trait ControllerRESTMethodsRecordActions
{
    public function test_controller_method_store_create_record()
    {
        $this->checkStoreMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $data = $this->createTestData();
        $this->post(route($this->route . '.store', $this->getStoreRouteParams()), $data);

        $this->assertDatabaseHas($this->modelClass::getTableName(), $this->modifyCheckData($data));
    }

    public function test_controller_method_show_return_record()
    {
        $this->checkShowMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $record = $this->createTestRecord();
        $response = $this->get(route($this->route . '.show', $this->getShowRouteParams($record)));

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
        $this->runProdSeeder();

        $record = $this->createTestRecord();
        $data = $this->createTestData();

        $this->put(route($this->route . '.update', $this->getUpdateRouteParams($record)), $data);

        $this->assertDatabaseHas($this->modelClass::getTableName(), $this->modifyCheckData($data));
    }

    public function test_controller_method_destroy_delete_record() {
        $this->checkDestroyMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $record = $this->createTestRecord();
        $this->delete(route($this->route . '.destroy', $this->getDestroyRouteParams($record)));

        if(in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses($this->modelClass)))
            $this->assertSoftDeleted($record);
        else
            $this->assertDatabaseMissing($this->modelClass::getTableName(), array_merge($record->getAttributes()));
    }

    public function test_controller_method_restore_restore_record() {
        $this->checkRestoreMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $record = $this->createTestRecord();

        $this->post(route($this->route . '.restore', $this->getRestoreRouteParams($record)));

        $this->assertDatabaseHas($this->modelClass::getTableName(), array_merge($record->getAttributes(), ['deleted_at' => null]));
    }

    public function test_controller_method_force_delete_delete_record() {
        $this->checkForceDeleteMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $record = $this->createTestRecord();
        $this->delete(route($this->route . '.force-delete', $this->getForceDeleteRouteParams($record)));

        $this->assertDatabaseMissing($this->modelClass::getTableName(), $record->getAttributes());
    }
}
