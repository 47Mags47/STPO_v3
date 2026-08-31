<?php

namespace Tests\Feature\App\Requests\Administrate;

use Illuminate\Support\Collection;
use App\Models\Administrate\Bank;
use Tests\TestCase;

class BankRequestTest extends TestCase
{
    private static $MODEL_CLASS = 'App\Models\Administrate\Bank';
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

        $this->post(route('administrate.banks.store'), $data);

        $this->assertDatabaseHas(self::$MODEL_CLASS::getTableName(), $data);
    }


    public function test_store_request_validate_code_required()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        unset($data['code']);

        $response = $this->post(route('administrate.banks.store'), $data);
        $response->assertInvalid('code');
    }

    public function test_store_request_validate_code_is_string()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['code'] = [];

        $response = $this->post(route('administrate.banks.store'), $data);
        $response->assertInvalid('code');
    }

    public function test_store_request_validate_code_min_length()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['code'] = '';

        $response = $this->post(route('administrate.banks.store'), $data);

        $response->assertInvalid('code');
    }

    public function test_store_request_validate_code_max_length()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['code'] = str_pad('', 256, '#');

        $response = $this->post(route('administrate.banks.store'), $data);
        $response->assertInvalid('code');
    }

    public function test_store_request_validate_code_is_unique()
    {
        $bank = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();
        $data['code'] = $bank->code;

        $response = $this->post(route('administrate.banks.store'), $data);
        $response->assertInvalid('code');
    }

    public function test_store_request_validate_name_required()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        unset($data['name']);

        $response = $this->post(route('administrate.banks.store'), $data);
        $response->assertInvalid('name');
    }

    public function test_store_request_validate_name_is_string()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['name'] = [];

        $response = $this->post(route('administrate.banks.store'), $data);
        $response->assertInvalid('name');
    }

    public function test_store_request_validate_name_min_length()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['name'] = '';

        $response = $this->post(route('administrate.banks.store'), $data);

        $response->assertInvalid('name');
    }

    public function test_store_request_validate_name_max_length()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['name'] = str_pad('', 256, '#');

        $response = $this->post(route('administrate.banks.store'), $data);
        $response->assertInvalid('name');
    }

    public function test_update_request_exist()
    {
        $this->assertTrue(self::$MODEL_CLASS::getGuessNames('updateRequest') !== false);
    }

    public function test_update_request_edit_record()
    {
        $record = self::$MODEL_CLASS::factory()->create();

        $this->prepareCookiesForRequest(route('administrate.banks.update', ['bank' => $record->id]), $record->toArray());

        $search = [];
        foreach ($record->toArray() as $key => $value) {
            if (in_array($key, new self::$MODEL_CLASS()->getFillable()))
                $search[$key] = $value;
        }

        $this->assertDatabaseHas(Bank::getTableName(), $search);
    }

    public function test_update_request_validate_code_required()
    {
        $bank = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        unset($data['code']);

        $response = $this->put(route('administrate.banks.update', [ 'bank' => $bank->id ]), $data);
        $response->assertInvalid('code');
    }

    public function test_update_request_validate_code_is_string()
    {
        $bank = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['code'] = [];

        $response = $this->put(route('administrate.banks.update', [ 'bank' => $bank->id ]), $data);
        $response->assertInvalid('code');
    }

    public function test_update_request_validate_code_min_length()
    {
        $bank = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['code'] = '';

        $response = $this->put(route('administrate.banks.update', [ 'bank' => $bank->id ]), $data);

        $response->assertInvalid('code');
    }

    public function test_update_request_validate_code_max_length()
    {
        $bank = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['code'] = str_pad('', 256, '#');

        $response = $this->put(route('administrate.banks.update', [ 'bank' => $bank->id ]), $data);
        $response->assertInvalid('code');
    }

    public function test_update_request_validate_code_is_unique()
    {
        $bank1 = self::$MODEL_CLASS::factory()->create();
        $bank2 = self::$MODEL_CLASS::factory()->create();

        $data = self::$MODEL_CLASS::factory()->make()->toArray();
        $data['code'] = $bank1->code;

        $response = $this->put(route('administrate.banks.update', [ 'bank' => $bank2->id ]), $data);
        $response->assertInvalid('code');
    }

    public function test_update_request_validate_name_required()
    {
        $bank = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        unset($data['name']);

        $response = $this->put(route('administrate.banks.update', [ 'bank' => $bank->id ]), $data);
        $response->assertInvalid('name');
    }

    public function test_update_request_validate_name_is_string()
    {
        $bank = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['name'] = [];

        $response = $this->put(route('administrate.banks.update', [ 'bank' => $bank->id ]), $data);
        $response->assertInvalid('name');
    }

    public function test_update_request_validate_name_min_length()
    {
        $bank = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['name'] = '';

        $response = $this->put(route('administrate.banks.update', [ 'bank' => $bank->id ]), $data);

        $response->assertInvalid('name');
    }

    public function test_update_request_validate_name_max_length()
    {
        $bank = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['name'] = str_pad('', 256, '#');

        $response = $this->put(route('administrate.banks.update', [ 'bank' => $bank->id ]), $data);
        $response->assertInvalid('name');
    }

         public function test_destroy_request_delete_record()
    {
        $bank = self::$MODEL_CLASS::factory()->create();

        $fillable_columns = $bank->getFillable();
        $search = [];
        foreach ($fillable_columns as $fillable_column) {
            $search[$fillable_column] = $bank->$fillable_column;
        }

        $this->delete(route('administrate.banks.destroy', ['bank' => $bank->id]));

        $this->assertDatabaseMissing(self::$MODEL_CLASS::getTableName(), $search);
    }
}
