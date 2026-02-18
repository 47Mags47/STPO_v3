<?php

namespace Tests\Traits;

use Inertia\Testing\AssertableInertia as Assert;

trait TestInertiaCreateMethod {
    public function test_create_method_exist()
    {
        $this->checkMethodExistance('create');
    }

    public function test_create_method_return_vue_component(){
        $this->getCreateResponse()->assertInertia(fn(Assert $page) => $page
            ->component($this->pageComponentPath . '/create')
        );
    }
}
