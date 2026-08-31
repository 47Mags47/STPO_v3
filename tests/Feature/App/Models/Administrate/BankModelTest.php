<?php

namespace Tests\Feature\App\Models\Administrate;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\Administrate\Bank;
use Tests\TestCase;

class BankModelTest extends TestCase
{
    private static $MODEL_CLASS = 'App\Models\Administrate\Bank';
    private ?Collection $records;

    protected function setUp(): void
    {
        parent::setUp();

        $this->records = self::$MODEL_CLASS::factory(3)->create();
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
        $table_columns = DB::getSchemaBuilder()->getColumnListing(Bank::getTableName());

        foreach ($table_columns as $index => $column) {
            if (in_array($column, ['id', 'created_at', 'updated_at', 'deleted_at']))
                unset($table_columns[$index]);
        }

        $this->assertTrue(count(array_diff($model_columns, $table_columns)) === 0);
        $this->assertTrue(count(array_diff($table_columns, $model_columns)) === 0);
    }
}
