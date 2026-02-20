<?php

namespace Tests\Traits;

use Illuminate\Support\Str;

trait TestInertiaUpdateMethod
{
    public function createRecord()
    {
        return $this->model::factory()->create();
    }

    public function test_update_method_exist()
    {
        $this->checkMethodExistance('update');
    }

    public function test_update_method_return_302()
    {
        $record = $this->createRecord();

        $this->getUpdateResponse($record->id)->assertStatus(302);
    }

    public function test_update_method_redirect_to_index_page()
    {
        $record = $this->createRecord();

        $this->getUpdateResponse($record->id)->assertRedirect(route($this->routeName . '.index'));
    }

    public function test_update_method_return_session_success()
    {
        $record = $this->createRecord();

        $this->getUpdateResponse($record->id)->assertSessionHas('succes', 'Запись успешно обновлена');
    }

    public function test_update_method_edit_record_in_the_database()
    {
        $record = $this->createRecord();

        $payload = $this->getPayload();
        $fillable = (new $this->model)->getFillable();
        $search = array_intersect_key($payload, array_flip($fillable));

        $this->sendUpdateRequest($record->id, $payload);

        $this->assertDatabaseHas($this->model::getTableName(), $search);
    }
}
