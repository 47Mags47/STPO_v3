<?php

namespace Tests\Feature\App\Requests\Administrate;

use Inertia\Testing\AssertableInertia as Assert;
use App\Models\Administrate\Division;
use Illuminate\Support\Collection;
use Tests\TestCase;


class DivisionRequestTest extends TestCase
{
    private static $MODEL_CLASS = 'App\Models\Administrate\Division';
    private ?Collection $records;

    protected function setUp(): void
    {
        parent::setUp();

        $this->records = self::$MODEL_CLASS::factory(3)->create();
    }

    public function test_store_request_exist()
    {
        $this->assertTrue(self::$MODEL_CLASS::getGuessNames('storeRequest') !== false);
    }

    public function test_store_request_create_record()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $this->post(route('administrate.divisions.store'), $data);

        $this->assertDatabaseHas(self::$MODEL_CLASS::getTableName(), $data);
    }

    public function test_store_request_validate_name_required()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        unset($data['name']);

        $response = $this->post(route('administrate.divisions.store'), $data);
        $response->assertInvalid('name');
    }

    public function test_store_request_validate_name_is_string()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['name'] = [];

        $response = $this->post(route('administrate.divisions.store'), $data);
        $response->assertInvalid('name');
    }

    public function test_store_request_validate_name_min_length()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['name'] = '';

        $response = $this->post(route('administrate.divisions.store'), $data);

        $response->assertInvalid('name');
    }

    public function test_store_request_validate_name_max_length()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['name'] = str_pad('', 256, '#');

        $response = $this->post(route('administrate.divisions.store'), $data);
        $response->assertInvalid('name');
    }

    public function test_store_request_validate_name_is_unique()
    {
        $division = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();
        $data['name'] = $division->name;

        $response = $this->post(route('administrate.divisions.store'), $data);
        $response->assertInvalid('name');
    }

    public function test_store_request_validate_city_id_required()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        unset($data['city_id']);

        $response = $this->post(route('administrate.divisions.store'), $data);
        $response->assertInvalid('city_id');
    }

    public function test_store_request_validate_city_id_is_integer()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['city_id'] = [];

        $response = $this->post(route('administrate.divisions.store'), $data);
        $response->assertInvalid('city_id');
    }

    public function test_store_request_validate_city_id_is_exist_in_db()
    {
        $division = self::$MODEL_CLASS::factory()->create();

        $this->assertDatabaseHas('administrate__cities', [
            'id' => $division->city_id
        ]);
    }

    public function test_update_request_exist()
    {
        $this->assertTrue(self::$MODEL_CLASS::getGuessNames('updateRequest') !== false);
    }

    public function test_update_request_edit_record()
    {
        $record = self::$MODEL_CLASS::factory()->create();

        $this->prepareCookiesForRequest(route('administrate.divisions.update', ['division' => $record->id]), $record->toArray());

        $search = [];
        foreach ($record->toArray() as $key => $value) {
            if (in_array($key, new self::$MODEL_CLASS()->getFillable()))
                $search[$key] = $value;
        }

        $this->assertDatabaseHas(Division::getTableName(), $search);
    }

     public function test_update_request_validate_name_required()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();
        $division = self::$MODEL_CLASS::factory()->create();

        unset($data['name']);

        $response = $this->put(route('administrate.divisions.update', ['division' => $division->id]), $data);
        $response->assertInvalid(['name']);
    }

    public function test_update_request_validate_name_is_string()
    {
        $division = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['name'] = [];

        $response = $this->put(route('administrate.divisions.update', ['division' => $division->id]), $data);
        $response->assertInvalid('name');
    }

    public function test_update_request_validate_name_min_length()
    {
        $division = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['name'] = '';

        $response = $this->put(route('administrate.divisions.update', ['division' => $division->id]), $data);

        $response->assertInvalid('name');
    }

    public function test_update_request_validate_name_max_length()
    {
        $division = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['name'] = str_pad('', 256, '#');

        $response = $this->put(route('administrate.divisions.update', ['division' => $division->id]), $data);
        $response->assertInvalid('name');
    }

    public function test_update_request_validate_name_is_unique()
    {
        $division1 = self::$MODEL_CLASS::factory()->create();
        $division2 = self::$MODEL_CLASS::factory()->create();

        $data = self::$MODEL_CLASS::factory()->make()->toArray();
        $data['name'] = $division2->name;

        $response = $this->put(route('administrate.divisions.update', ['division' => $division1->id]), $data);
        $response->assertInvalid('name');
    }

    public function test_update_request_validate_city_id_required()
    {
        $division = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        unset($data['city_id']);

        $response = $this->put(route('administrate.divisions.update', ['division' => $division->id]), $data);
        $response->assertInvalid('city_id');
    }

    public function test_update_request_validate_city_id_is_integer()
    {
        $division = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['city_id'] = [];

        $response = $this->put(route('administrate.divisions.update', ['division' => $division->id]), $data);
        $response->assertInvalid('city_id');
    }

    public function test_update_request_validate_city_id_is_exist_in_db()
    {
        $division = self::$MODEL_CLASS::factory()->create();

        $this->assertDatabaseHas('administrate__cities', [
            'id' => $division->city_id
        ]);
    }

    public function test_destroy_request_delete_record()
    {
        $division = self::$MODEL_CLASS::factory()->create();

        $fillable_columns = $division->getFillable();
        $search = [];
        foreach ($fillable_columns as $fillable_column) {
            $search[$fillable_column] = $division->$fillable_column;
        }

        $this->delete(route('administrate.divisions.destroy', ['division' => $division->id]));

        $this->assertDatabaseMissing(self::$MODEL_CLASS::getTableName(), $search);
    }
}
