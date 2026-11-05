<?php

namespace Tests\Feature\Controller\Traits;

use Inertia\Testing\AssertableInertia as Assert;

trait ControllerRESTMethodsRecordActions
{
    public function test_route_performs_an_action__store()
    {
        $this->checkStoreMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $data = $this->createTestData();
        $this->post(route($this->route . '.store', $this->getStoreRouteParams()), $data);

        $this->assertDatabaseHas($this->modelClass::getTableName(), $this->modifyCheckData($data));
    }

    public function test_route_performs_an_action__show()
    {
        $this->checkShowMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $record = $this->createTestRecord();
        $response = $this->get(route($this->route . '.show', $this->getShowRouteParams($record)));

        $response->assertInertia(
            fn(Assert $page) => $page->has(
                $this->pageProps['show'] . '.data',
                function (Assert $page) use ($record) {
                    foreach ($record->toResource()->toArray(request()) as $key => $value) {
                        $page->where($key, $value);
                    }

                    return $page;
                }
            )
        );
    }

    public function test_route_performs_an_action__update()
    {
        $this->checkUpdateMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $record = $this->createTestRecord();
        $data = $this->createTestData();

        $this->put(route($this->route . '.update', $this->getUpdateRouteParams($record)), $data);

        $this->assertDatabaseHas($this->modelClass::getTableName(), $this->modifyCheckData($data));
    }

    public function test_route_performs_an_action__destroy() {
        $this->checkDestroyMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $record = $this->createTestRecord();
        $this->delete(route($this->route . '.destroy', $this->getDestroyRouteParams($record)));

        if (in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive($this->modelClass)))
            $this->assertSoftDeleted($record);
        else
            $this->assertDatabaseMissing($this->modelClass::getTableName(), $record->getAttributes());
    }

    public function test_route_performs_an_action__restore() {
        $this->checkRestoreMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $record = $this->createTestRecord();

        $this->post(route($this->route . '.restore', $this->getRestoreRouteParams($record)));

        $this->assertDatabaseHas($this->modelClass::getTableName(), array_merge($record->getAttributes(), ['deleted_at' => null]));
    }

    public function test_route_performs_an_action__force_delete() {
        $this->checkForceDeleteMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $record = $this->createTestRecord();
        $this->delete(route($this->route . '.force-delete', $this->getForceDeleteRouteParams($record)));

        $this->assertDatabaseMissing($this->modelClass::getTableName(), $record->getAttributes());
    }
}
