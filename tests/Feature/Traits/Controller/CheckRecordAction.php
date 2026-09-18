<?php

namespace Tests\Feature\Traits\Controller;

use Illuminate\Container\Attributes\Log;
use Inertia\Testing\AssertableInertia as Assert;

trait CheckRecordAction
{
    public function test_controller_method_index_return_records()
    {
        $this->checkIndexMethodExist();

        $response = $this
            ->get(route($this->route . '.index'));

        $response->assertInertia(
            fn(Assert $page) => $page
                ->has($this->props['index'])
                ->has($this->props['index'] . '.data')
        );
    }

    public function test_controller_method_store_create_record()
    {
        $this->checkStoreMethodExist();

        $data = $this->createTestData();
        $this->post(route($this->route . '.store'), $data);

        $this->assertDatabaseHas($this->modelClass::getTableName(), $data);
    }

    public function test_controller_method_show_return_record()
    {
        $this->checkShowMethodExist();

        $record = $this->createTestRecord();
        $response = $this
            ->get(route($this->route . '.show', [$this->getParameterName() => $record]));

        $response->assertInertia(
            fn(Assert $page) => $page->has(
                $this->props['show'],
                function (Assert $page) use ($record) {
                    foreach ($record->toArray() as $key => $value) {
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

        $record = $this->createTestRecord();
        $data = $this->createTestData();
        $route = route($this->route . '.update', ['bank' => $record->id]);

        dump([
            'record' => $record->toArray(),
            'data' => $data,
            'route' => $route
        ]);

        $response = $this->put($route, $data);
        $response
            ->assertValid();

        $this->assertDatabaseHas($this->modelClass::getTableName(), $data);
    }
}
