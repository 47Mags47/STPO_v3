<?php

namespace Tests\Feature\App\Database\Factories;

use App\Models\Administrate\Bank;
use Tests\TestCase;

class BankFactoryTest extends TestCase
{
    private static $MODEL_CLASS = 'App\Models\Administrate\Bank';

    protected function setUp(): void
    {
        parent::setUp();
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

        $factory_data = Bank::factory()->make()->toArray();

        $this->assertTrue(count(array_diff($fillable_columns, array_keys($factory_data))) === 0);
        $this->assertTrue(count(array_diff(array_keys($factory_data), $fillable_columns)) === 0);
    }

    public function test_factory_created_valid_data()
    {
        $factory_data = self::$MODEL_CLASS::factory()->make()->toArray();
        $model = self::$MODEL_CLASS::create($factory_data);
        $this->assertTrue(self::$MODEL_CLASS::whereKey($model->id)->exists());
    }
}
