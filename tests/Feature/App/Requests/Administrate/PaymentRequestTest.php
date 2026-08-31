<?php

namespace Tests\Feature\App\Requests\Administrate;

use Illuminate\Support\Collection;
use App\Models\Administrate\Payment;
use Tests\TestCase;

class PaymentRequestTest extends TestCase
{
    private static $MODEL_CLASS = 'App\Models\Administrate\Payment';
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

        $this->post(route('administrate.payments.store'), $data);

        $this->assertDatabaseHas(self::$MODEL_CLASS::getTableName(), $data);
    }

    public function test_store_request_validate_code_required()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        unset($data['code']);

        $response = $this->post(route('administrate.payments.store'), $data);
        $response->assertInvalid('code');
    }

    public function test_store_request_validate_code_is_string()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['code'] = [];

        $response = $this->post(route('administrate.payments.store'), $data);
        $response->assertInvalid('code');
    }

    public function test_store_request_validate_code_min_length()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['code'] = '';

        $response = $this->post(route('administrate.payments.store'), $data);

        $response->assertInvalid('code');
    }

    public function test_store_request_validate_code_max_length()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['code'] = str_pad('', 256, '#');

        $response = $this->post(route('administrate.payments.store'), $data);
        $response->assertInvalid('code');
    }

    public function test_store_request_validate_code_is_unique()
    {
        $payment = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();
        $data['code'] = $payment->code;

        $response = $this->post(route('administrate.payments.store'), $data);
        $response->assertInvalid('code');
    }

    public function test_store_request_validate_name_required()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        unset($data['name']);

        $response = $this->post(route('administrate.payments.store'), $data);
        $response->assertInvalid('name');
    }

    public function test_store_request_validate_name_is_string()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['name'] = [];

        $response = $this->post(route('administrate.payments.store'), $data);
        $response->assertInvalid('name');
    }

    public function test_store_request_validate_name_min_length()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['name'] = '';

        $response = $this->post(route('administrate.payments.store'), $data);

        $response->assertInvalid('name');
    }

    public function test_store_request_validate_name_max_length()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['name'] = str_pad('', 256, '#');

        $response = $this->post(route('administrate.payments.store'), $data);
        $response->assertInvalid('name');
    }

    public function test_store_request_validate_name_is_unique()
    {
        $payment = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();
        $data['name'] = $payment->name;

        $response = $this->post(route('administrate.payments.store'), $data);
        $response->assertInvalid('name');
    }

    public function test_store_request_validate_kbk_required()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        unset($data['kbk']);

        $response = $this->post(route('administrate.payments.store'), $data);
        $response->assertInvalid('kbk');
    }

    public function test_store_request_validate_kbk_is_string()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['kbk'] = [];

        $response = $this->post(route('administrate.payments.store'), $data);
        $response->assertInvalid('kbk');
    }

    public function test_store_request_validate_kbk_min_length()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['kbk'] = '';

        $response = $this->post(route('administrate.payments.store'), $data);

        $response->assertInvalid('kbk');
    }

    public function test_store_request_validate_kbk_max_length()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['kbk'] = str_pad('', 256, '#');

        $response = $this->post(route('administrate.payments.store'), $data);
        $response->assertInvalid('kbk');
    }

    public function test_store_request_validate_kbk_regex()
    {
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['kbk'] = str_pad('', '128', '#');

        $response = $this->post(route('administrate.payments.store'), $data);
        $response->assertInvalid('kbk');
    }

    public function test_update_request_exist()
    {
        $this->assertTrue(self::$MODEL_CLASS::getGuessNames('updateRequest') !== false);
    }

    public function test_update_request_edit_record()
    {
        $record = self::$MODEL_CLASS::factory()->create();

        $this->prepareCookiesForRequest(route('administrate.payments.update', ['payment' => $record->id]), $record->toArray());

        $search = [];
        foreach ($record->toArray() as $key => $value) {
            if (in_array($key, new self::$MODEL_CLASS()->getFillable()))
                $search[$key] = $value;
        }

        $this->assertDatabaseHas(Payment::getTableName(), $search);
    }

    public function test_update_request_validate_code_required()
    {
        $record = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        unset($data['code']);

        $response = $this->put(route('administrate.payments.update', ['payment' => $record->id]), $data);
        $response->assertInvalid('code');
    }

    public function test_update_request_validate_code_is_string()
    {
        $record = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['code'] = [];

        $response = $this->put(route('administrate.payments.update', ['payment' => $record->id]), $data);
        $response->assertInvalid('code');
    }

    public function test_update_request_validate_code_min_length()
    {
        $record = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['code'] = '';

        $response = $this->put(route('administrate.payments.update', ['payment' => $record->id]), $data);

        $response->assertInvalid('code');
    }

    public function test_update_request_validate_code_max_length()
    {
        $record = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['code'] = str_pad('', 256, '#');

        $response = $this->put(route('administrate.payments.update', ['payment' => $record->id]), $data);
        $response->assertInvalid('code');
    }

    public function test_update_request_validate_code_is_unique()
    {
        $record1 = self::$MODEL_CLASS::factory()->create();
        $record2 = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();
        $data['code'] = $record1->code;

        $response = $this->put(route('administrate.payments.update', ['payment' => $record2->id]), $data);
        $response->assertInvalid('code');
    }

    public function test_update_request_validate_name_required()
    {
        $record = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        unset($data['name']);

        $response = $this->put(route('administrate.payments.update', ['payment' => $record->id]), $data);
        $response->assertInvalid('name');
    }

    public function test_update_request_validate_name_is_string()
    {
        $record = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['name'] = [];

        $response = $this->put(route('administrate.payments.update', ['payment' => $record->id]), $data);
        $response->assertInvalid('name');
    }

    public function test_update_request_validate_name_min_length()
    {
        $record = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['name'] = '';

        $response = $this->put(route('administrate.payments.update', ['payment' => $record->id]), $data);

        $response->assertInvalid('name');
    }

    public function test_update_request_validate_name_max_length()
    {
        $record = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['name'] = str_pad('', 256, '#');

        $response = $this->put(route('administrate.payments.update', ['payment' => $record->id]), $data);
        $response->assertInvalid('name');
    }

    public function test_update_request_validate_name_is_unique()
    {
        $record1 = self::$MODEL_CLASS::factory()->create();
        $record2 = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();
        $data['name'] = $record1->name;

        $response = $this->put(route('administrate.payments.update', ['payment' => $record2->id]), $data);
        $response->assertInvalid('name');
    }

    public function test_update_request_validate_kbk_required()
    {
        $record = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        unset($data['kbk']);

        $response = $this->put(route('administrate.payments.update', ['payment' => $record->id]), $data);
        $response->assertInvalid('kbk');
    }

    public function test_update_request_validate_kbk_is_string()
    {
        $record = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['kbk'] = [];

        $response = $this->put(route('administrate.payments.update', ['payment' => $record->id]), $data);
        $response->assertInvalid('kbk');
    }

    public function test_update_request_validate_kbk_min_length()
    {
        $record = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['kbk'] = '';

        $response = $this->put(route('administrate.payments.update', ['payment' => $record->id]), $data);

        $response->assertInvalid('kbk');
    }

    public function test_update_request_validate_kbk_max_length()
    {
        $record = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['kbk'] = str_pad('', 256, '#');

        $response = $this->put(route('administrate.payments.update', ['payment' => $record->id]), $data);
        $response->assertInvalid('kbk');
    }

    public function test_update_request_validate_kbk_regex()
    {
        $record = self::$MODEL_CLASS::factory()->create();
        $data = self::$MODEL_CLASS::factory()->make()->toArray();

        $data['kbk'] = str_pad('', '128', '#');

        $response = $this->post(route('administrate.payments.store', ['payment' => $record->id]), $data);
        $response->assertInvalid('kbk');
    }

    public function test_destroy_request_delete_record()
    {
        $record = self::$MODEL_CLASS::factory()->create();

        $fillable_columns = $record->getFillable();
        $search = [];
        foreach ($fillable_columns as $fillable_column) {
            $search[$fillable_column] = $record->$fillable_column;
        }

        $this->delete(route('administrate.payments.destroy', ['payment' => $record->id]));

        $this->assertDatabaseMissing(self::$MODEL_CLASS::getTableName(), $search);
    }
}
