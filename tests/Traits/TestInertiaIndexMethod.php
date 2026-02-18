<?php

namespace Tests\Traits;

use Inertia\Testing\AssertableInertia as Assert;

trait TestInertiaIndexMethod
{
    public function test_index_method_exist()
    {
        $this->checkMethodExistance('index');
    }

    public function test_index_method_return_vue_component(){
        $this->getIndexResponse()->assertInertia(fn(Assert $page) => $page
            ->component($this->pageComponentPath . '/index')
        );
    }

    public function test_index_method_return_props(){
        $this->getIndexResponse()->assertInertia(fn(Assert $page) => $page
            ->has($this->propKey)
        );
    }

    public function test_index_method_has_paginate(){
        $this->getIndexResponse()->assertInertia(fn(Assert $page) => $page
            ->has($this->propKey . '.links')
        );
    }

    public function test_index_method_can_return_full_list(){
        $this->getIndexResponse(['paginate' => false])->assertInertia(fn(Assert $page) => $page
            ->missing($this->propKey . '.links')
        );
    }
}
