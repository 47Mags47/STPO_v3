<?php
namespace Tests\Feature\Controller\Traits;

use Inertia\Testing\AssertableInertia as Assert;

trait RouteReturnInertiaProp
{
    ### METHODS
    ##################################################
    protected function checkHasPropIndex(): bool
    {
        if($this->pageProps === null or in_array('index', $this->pageProps))
            $this->markTestSkipped('Пропуск проверки prop index');

        return in_array('index', $this->pageProps);
    }

    protected function checkHasPropShow(): bool
    {
        if($this->pageProps === null or in_array('show', $this->pageProps))
            $this->markTestSkipped('Пропуск проверки prop show');

        return in_array('show', $this->pageProps);
    }

    protected function checkHasPropEdit(): bool
    {
        if($this->pageProps === null or in_array('edit', $this->pageProps))
            $this->markTestSkipped('Пропуск проверки prop edit');

        return in_array('edit', $this->pageProps);
    }

    ### TESTS
    ##################################################
    public function test_route_return_inertia_prop__index()
    {
        $this->checkIndexMethodExist();
        $this->checkHasPropIndex();

        $this->disableAuthMiddleware();

        $response = $this->get(route($this->route . '.index', $this->getIndexRouteParams()));
        $response->assertInertia(fn(Assert $page) => $page->has($this->pageProps['index']));
    }

    public function test_route_return_inertia_prop__show()
    {
        $this->checkShowMethodExist();
        $this->checkHasPropShow();

        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $record = $this->createTestRecord();

        $response = $this->get(route($this->route . '.show', $this->getShowRouteParams(record: $record)));
        $response->assertInertia(fn(Assert $page) => $page->has($this->pageProps['show']));
    }

    public function test_route_return_inertia_prop_edit()
    {
        $this->checkEditMethodExist();
        $this->checkHasPropEdit();

        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $record = $this->createTestRecord();

        $response = $this->get(route($this->route . '.edit', $this->getEditRouteParams(record: $record)));
        $response->assertInertia(fn(Assert $page) => $page->has($this->pageProps['edit']));
    }

    public function test_route_return_prop_has_data__index()
    {
        $this->checkIndexMethodExist();
        $this->checkHasPropIndex();

        $this->disableAuthMiddleware();

        $response = $this->get(route($this->route . '.index', $this->getIndexRouteParams()));
        $response->assertInertia(fn(Assert $page) => $page->has($this->pageProps['index'] . '.data'));
    }
}
