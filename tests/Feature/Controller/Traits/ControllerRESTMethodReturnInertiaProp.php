<?php
namespace Tests\Feature\Controller\Traits;

use Inertia\Testing\AssertableInertia as Assert;

trait ControllerRESTMethodReturnInertiaProp
{
    public function test_controller_method_index_return_inertia_prop()
    {
        $this->checkIndexMethodExist();

        $this->disableAuthMiddleware();

        $response = $this->get(route($this->route . '.index', $this->getIndexRouteParams()));
        $response->assertInertia(fn(Assert $page) => $page->has($this->pageProps['index']));
    }

    public function test_controller_index_prop_has_data()
    {
        $this->checkIndexMethodExist();

        $this->disableAuthMiddleware();

        $response = $this->get(route($this->route . '.index', $this->getIndexRouteParams()));
        $response->assertInertia(fn(Assert $page) => $page->has($this->pageProps['index'] . '.data'));
    }

    public function test_controller_method_show_return_prop()
    {
        $this->checkShowMethodExist();

        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $record = $this->createTestRecord();

        $response = $this->get(route($this->route . '.show', $this->getShowRouteParams(record: $record)));
        $response->assertInertia(fn(Assert $page) => $page->has($this->pageProps['show']));
    }

    public function test_controller_method_edit_return_prop()
    {
        $this->checkEditMethodExist();

        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $record = $this->createTestRecord();

        $response = $this->get(route($this->route . '.edit', $this->getEditRouteParams(record: $record)));
        $response->assertInertia(fn(Assert $page) => $page->has($this->pageProps['edit']));
    }
}
