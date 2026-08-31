<?php

namespace Tests\Feature\App\Requests\Administrate;

use Inertia\Testing\AssertableInertia as Assert;
use App\Models\Administrate\City;
use Illuminate\Support\Collection;
use Tests\TestCase;


class CityRequestTest extends TestCase
{
    private static $MODEL_CLASS = 'App\Models\Administrate\City';
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

        $this->post(route('administrate.cities.store'), $data);

        $this->assertDatabaseHas(self::$MODEL_CLASS::getTableName(), $data);
    }

    public function test_store_request_validate_name_required()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        unset($data['name']);

        $response = $this->post(route('administrate.cities.store'), $data);
        $response->assertInvalid('name');
    }

    public function test_store_request_validate_name_is_string()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['name'] = [];

        $response = $this->post(route('administrate.cities.store'), $data);
        $response->assertInvalid('name');
    }

    public function test_store_request_validate_name_min_length()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['name'] = '';

        $response = $this->post(route('administrate.cities.store'), $data);

        $response->assertInvalid('name');
    }

    public function test_store_request_validate_name_max_length()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['name'] = str_pad('', 256, '#');

        $response = $this->post(route('administrate.cities.store'), $data);
        $response->assertInvalid('name');
    }

    public function test_store_request_validate_name_is_unique()
    {
        $city = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();
        $data['name'] = $city->name;

        $response = $this->post(route('administrate.cities.store'), $data);
        $response->assertInvalid('name');
    }

    public function test_store_return_redirect_status_302()
    {
        $data = City::factory()->make()->toArray();

        $response = $this->post(route('administrate.cities.store'), $data);

        $response->assertStatus(302);
    }

    public function test_store_return_redirect_to_index()
    {
        $data = City::factory()->make()->toArray();

        $response = $this->post(route('administrate.cities.store'), $data);

        $response->assertRedirect((route('administrate.cities.index')));
    }

    public function test_update_request_exist()
    {
        $this->assertTrue(self::$MODEL_CLASS::getGuessNames('updateRequest') !== false);
    }

    public function test_update_request_edit_record()
    {
        $record = self::$MODEL_CLASS::factory()->create();

        $this->post(route('administrate.cities.update', ['city' => $record->id]), $record->toArray());

        $search = [];
        foreach ($record->toArray() as $key => $value) {
            if (in_array($key, new self::$MODEL_CLASS()->getFillable()))
                $search[$key] = $value;
        }

        $this->assertDatabaseHas(City::getTableName(), $search);
    }

    public function test_update_request_validate_name_required()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();
        $city = self::$MODEL_CLASS::factory()->create();

        unset($data['name']);

        $response = $this->put(route('administrate.cities.update', ['city' => $city->id]), $data);
        $response->assertInvalid(['name']);
    }

    public function test_update_request_validate_name_is_string()
    {
        $city = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['name'] = [];

        $response = $this->put(route('administrate.cities.update', ['city' => $city->id]), $data);
        $response->assertInvalid('name');
    }

    public function test_update_request_validate_name_min_length()
    {
        $city = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['name'] = '';

        $response = $this->put(route('administrate.cities.update', ['city' => $city->id]), $data);

        $response->assertInvalid('name');
    }

    public function test_update_request_validate_name_max_length()
    {
        $city = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['name'] = str_pad('', 256, '#');

        $response = $this->put(route('administrate.cities.update', ['city' => $city->id]), $data);
        $response->assertInvalid('name');
    }

    public function test_update_request_validate_name_is_unique()
    {
        $city1 = self::$MODEL_CLASS::factory()->create();
        $city2 = self::$MODEL_CLASS::factory()->create();

        $data = self::$MODEL_CLASS::factory()->make()->toArray();
        $data['name'] = $city2->name;

        $response = $this->put(route('administrate.cities.update', ['city' => $city1->id]), $data);
        $response->assertInvalid('name');
    }

    public function test_destroy_request_delete_record()
    {
        $city = self::$MODEL_CLASS::factory()->create();

        $fillable_columns = $city->getFillable();
        $search = [];
        foreach ($fillable_columns as $fillable_column) {
            $search[$fillable_column] = $city->$fillable_column;
        }

        $this->delete(route('administrate.cities.destroy', ['city' => $city->id]));

        $this->assertDatabaseMissing(self::$MODEL_CLASS::getTableName(), $search);
    }
}
