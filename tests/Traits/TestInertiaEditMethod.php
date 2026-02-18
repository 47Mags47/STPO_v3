<?php

namespace Tests\Traits;

use Inertia\Testing\AssertableInertia as Assert;

trait TestInertiaEditMethod {
    public function test_edit_method_exist()
    {
        $this->checkMethodExistance('edit');
    }

    public function test_edit_method_return_vue_component(){
        $record = $this->model::factory()->create();

        $this->getEditResponse($record->id)->assertInertia(fn(Assert $page) => $page
            ->component($this->pageComponentPath . '/edit')
        );
    }
}
