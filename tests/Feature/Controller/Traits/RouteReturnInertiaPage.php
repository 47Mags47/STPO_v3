<?php

namespace Tests\Feature\Controller\Traits;

use Inertia\Testing\AssertableInertia as Assert;

trait RouteReturnInertiaPage
{
    ### Settings
    ##################################################
    // Inertia Компоненты страниц
    public array $pageComponents = [
        'index'     => null,
        'create'    => null,
        'show'      => null,
        'edit'      => null
    ];

    ### Methods
    ##################################################
    protected function getIndexPageComponent(): string
    {
        return array_key_exists('index', $this->pageComponents)
            ? stringDotToSlash($this->pageComponents['index'])
            : stringDotToSlash($this->route) . '/index';
    }

    protected function getCreatePageComponent(): string
    {
        return array_key_exists('create', $this->pageComponents)
            ? stringDotToSlash($this->pageComponents['create'])
            : stringDotToSlash($this->route) . '/create';
    }

    protected function getShowPageComponent(): string
    {
        return array_key_exists('show', $this->pageComponents)
            ? stringDotToSlash($this->pageComponents['show'])
            : stringDotToSlash($this->route) . '/show';
    }

    protected function getEditPageComponent(): string
    {
        return array_key_exists('edit', $this->pageComponents)
            ? stringDotToSlash($this->pageComponents['edit'])
            : stringDotToSlash($this->route) . '/edit';
    }

    ### Tests
    ##################################################
    public function test_route_return_inertia_page__index()
    {
        $this->checkIndexMethodExist();

        $this->disableAuthMiddleware();

        $response = $this->get(route($this->route . '.index', $this->getIndexRouteParams()));
        $response->assertInertia(fn(Assert $page) => $page->component($this->getIndexPageComponent()));
    }

    public function test_route_return_inertia_page__create()
    {
        $this->checkCreateMethodExist();

        $this->disableAuthMiddleware();

        $response = $this->get(route($this->route . '.create', $this->getCreateRouteParams()));
        $response->assertInertia(fn(Assert $page) => $page->component($this->getCreatePageComponent()));
    }

    public function test_route_return_inertia_page__show()
    {
        $this->checkShowMethodExist();

        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $record = $this->createTestRecord();

        $response = $this->get(route($this->route . '.show', $this->getShowRouteParams(record: $record)));
        $response->assertInertia(fn(Assert $page) => $page->component($this->getShowPageComponent()));
    }

    public function test_route_return_inertia_page__edit()
    {
        $this->checkEditMethodExist();
        $this->disableAuthMiddleware();
        $this->runProdSeeder();

        $record = $this->createTestRecord();

        $response = $this->get(route($this->route . '.edit', $this->getEditRouteParams(record: $record)));
        $response->assertInertia(fn(Assert $page) => $page->component($this->getEditPageComponent()));
    }
}
