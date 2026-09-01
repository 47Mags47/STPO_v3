<?php

namespace App\Models\Base;

use App\Classes\BaseModel;
use Illuminate\Support\Arr;

class Config extends BaseModel
{
    ### Настройки
    ##################################################
    protected $table = 'base__config';

    protected $fillable = [
        'key',
        'value'
    ];

    public $timestamps = false;

    ### Методы
    ##################################################
    public static function array(?string $key = null)
    {
        $records = self::all();
        $result = [];

        foreach ($records as $record) {
            Arr::set($result, $record->key, $record->value);
        }

        return $key === null
            ? $result
            : Arr::get($result, $key);
    }
}
