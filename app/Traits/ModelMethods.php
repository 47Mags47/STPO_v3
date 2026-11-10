<?php

namespace App\Traits;

trait ModelMethods
{
    ### Методы
    ##################################################
    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public function getFillableAttributes(): array
    {
        $fillable = new $this()->getFillable();
        if (array_search('*', $fillable) !== false)
            unset($fillable[array_search('*', $fillable)]);

        $attributes = [];
        foreach ($fillable as $attribute) {
            $attributes[$attribute] = $this->$attribute;
        }

        return $attributes;
    }
}
