<?php

namespace Tests\Traits;

trait TestInertiaDestroyMethod {
    public function test_destroy_method_exist()
    {
        $this->checkMethodExistance('destroy');
    }

    public function test_destroy_method_return_302()
    {
        $record = $this->createRecord();

        $this->getDeleteResponse($record->id)->assertStatus(302);
    }

    public function test_destroy_method_redirect_to_index_page()
    {
        $record = $this->createRecord();

        $this->getDeleteResponse($record->id)->assertRedirect(route($this->routeName . '.index'));
    }

    public function test_destroy_method_return_session_success()
    {
        $record = $this->createRecord();

        $this->getDeleteResponse($record->id)->assertSessionHas('succes', 'Запись удалена');
    }

    public function test_destroy_method_delete_record_in_the_database(){
        $record = $this->model::factory()->create();
        $fillable = (new $this->model)->getFillable();
        $search = array_intersect_key($record->toArray(), array_flip($fillable));

        $this->getDeleteResponse($record->id);
        $this->assertDatabaseMissing($this->model::getTableName(), $search);
    }
}
