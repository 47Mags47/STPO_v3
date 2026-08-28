<?php

namespace Tests\Feature\App\Models\Administrate;

use Inertia\Testing\AssertableInertia as Assert;
use App\Models\Administrate\City;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Tests\Feature\Cases\ModelTestCase;
use Tests\TestCase;


class CityTest extends TestCase
{
    private static $MODEL_CLASS = 'App\Models\Administrate\City';
    private ?Collection $records;

    protected function setUp(): void
    {
        parent::setUp();

        $this->records = self::$MODEL_CLASS::factory(3)->create();

        $this->withMiddleware(['inertia']);
    }

    public function test_model_exist()
    {
        $this->assertTrue(class_exists(self::$MODEL_CLASS));
    }

    public function test_collumns_is_fillable_or_guarded()
    {
        $fillable = new self::$MODEL_CLASS()->getFillable();
        if (array_search('*', $fillable) !== false)
            unset($fillable[array_search('*', $fillable)]);

        $guarded = new self::$MODEL_CLASS()->getGuarded();
        if (array_search('*', $guarded) !== false)
            unset($guarded[array_search('*', $guarded)]);

        $model_columns = array_merge($fillable, $guarded);
        $table_columns = DB::getSchemaBuilder()->getColumnListing(City::getTableName());

        foreach ($table_columns as $index => $column) {
            if (in_array($column, ['id', 'created_at', 'updated_at', 'deleted_at']))
                unset($table_columns[$index]);
        }

        $this->assertTrue(count(array_diff($model_columns, $table_columns)) === 0);
        $this->assertTrue(count(array_diff($table_columns, $model_columns)) === 0);
    }

    public function test_factory_exist()
    {
        $this->assertTrue(self::$MODEL_CLASS::getGuessNames('factory') !== false);
    }

    public function test_factory_created_fillable_columns()
    {
        $fillable_columns = new self::$MODEL_CLASS()->getFillable();
        if (array_search('*', $fillable_columns) !== false)
            unset($fillable_columns[array_search('*', $fillable_columns)]);

        $factory_data = City::factory()->make()->toArray();

        $this->assertTrue(count(array_diff($fillable_columns, array_keys($factory_data))) === 0);
        $this->assertTrue(count(array_diff(array_keys($factory_data), $fillable_columns)) === 0);
    }

    public function test_factory_created_valid_data()
    {
        $factory_data = self::$MODEL_CLASS::factory()->make()->toArray();
        $model = self::$MODEL_CLASS::create($factory_data);
        $this->assertTrue(self::$MODEL_CLASS::whereKey($model->id)->exists());
    }

    public function test_index_return_page()
    {
        $response = $this->get(route('administrate.cities.index'));

        $response->assertInertia();
    }

    public function test_index_return_necessary_props()
    {
        $response = $this->get(route('administrate.cities.index'));

        $response->assertInertia(function ($page) {
            $page->component('administrate/cities/index');

            // Возвращает только эти пропсы (ни больше ни меньше ни другого имени)
            $this->assertSame(
                ['cities'],
                array_keys($page->toArray()['props'])
            );
        });
    }

    public function test_create_return_page()
    {
        $response = $this->get(route('administrate.cities.create'));

        $response->assertInertia();
    }

    public function test_create_return_necessary_props()
    {
        $response = $this->get(route('administrate.cities.create'));

        $response->assertInertia(function ($page) {
            $page->component('administrate/cities/create');

            // Возвращает только эти пропсы (ни больше ни меньше ни другого имени)
            // Здесь пропсов нет
            $this->assertSame(
                [],
                array_keys($page->toArray()['props'])
            );
        });
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

    public function test_edit_return_page()
    {
        $city = City::factory()->create();

        $response = $this->get(route('administrate.cities.edit', [ 'city' => $city->id ]));

        $response->assertInertia();
    }

    public function test_edit_return_necessary_props()
    {
        $city = City::factory()->create();
        $response = $this->get(route('administrate.cities.edit', [ 'city' => $city->id ]));

        $response->assertInertia(function ($page) {
            $page->component('administrate/cities/edit');

            // Возвращает только эти пропсы (ни больше ни меньше ни другого имени)
            $this->assertSame(
                ['city'],
                array_keys($page->toArray()['props'])
            );
        });
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

    public function test_update_return_redirect_status_302()
    {
        $city = City::factory()->create();
        $data = City::factory()->make()->toArray();

        $response = $this->put(route('administrate.cities.update', [ 'city' => $city->id ]), $data);

        $response->assertStatus(302);
    }

    public function test_update_return_redirect_to_index()
    {
        $city = City::factory()->create();
        $data = City::factory()->make()->toArray();

        $response = $this->put(route('administrate.cities.update', [ 'city' => $city->id ]), $data);

        $response->assertRedirect((route('administrate.cities.index')));
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

        $this->assertSoftDeleted(self::$MODEL_CLASS::getTableName(), $search);
    }

    public function test_destroy_return_redirect_status_302()
    {
        $city = City::factory()->create();

        $response = $this->delete(route('administrate.cities.destroy', [ 'city' => $city->id ]));

        $response->assertStatus(302);
    }

    public function test_destroy_return_redirect_to_index()
    {
        $city = City::factory()->create();

        $response = $this->delete(route('administrate.cities.destroy', [ 'city' => $city->id ]));

        $response->assertRedirect((route('administrate.cities.index')));
    }
}
