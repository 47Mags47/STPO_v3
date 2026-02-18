<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class BaseModel extends Model
{
    ### Методы
    ##################################################
    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    protected static function getGuessNames(?string $name = null): array| string| bool
    {
        $modelClass = static::class;

        if (! Str::contains($modelClass, '\\Models\\')) {
            return [];
        }

        $relativeNamespace = Str::after($modelClass, '\\Models\\');
        $path = Str::before($modelClass, 'App\\Models');

        $names = [
            'class'             => $modelClass,
            'className'         => $relativeNamespace,
            'path'              => $path,
            'factory'           => self::getClassKnowingFolderAndEnding('Database\\Factories', $relativeNamespace, 'Factory'),
            'localseeder'       => self::getClassKnowingFolderAndEnding('Database\\Seeders\\Local', $relativeNamespace, 'Seeder'),
            'prodseeder'        => self::getClassKnowingFolderAndEnding('Database\\Seeders\\Prod', $relativeNamespace, 'Seeder'),
            'filter'            => self::getClassKnowingFolderAndEnding('Database\\Filters', $relativeNamespace, 'Filter'),
            'controller'        => self::getClassKnowingFolderAndEnding('App\\Http\\Controllers', $relativeNamespace, 'Controller'),
            'policy'            => self::getClassKnowingFolderAndEnding('App\\Policies', $relativeNamespace, 'Policy'),
            'storerequest'      => self::getClassKnowingFolderAndEnding('App\\Http\\Requests', 'Store' . $relativeNamespace, 'Request'),
            'updaterequest'     => self::getClassKnowingFolderAndEnding('App\\Http\\Requests', 'Update' . $relativeNamespace, 'Request'),
            'resource'          => self::getClassKnowingFolderAndEnding('App\\Http\\Resources', $relativeNamespace, 'Resource'),
        ];

        return $name !== null
            ? $names[$name]
            : $names;
    }

    public function scopeFilter(Builder $builder): Builder
    {
        return self::getGuessNames('filter')
            ? new (self::getGuessNames('filter'))($builder)->apply()
            : new \App\Classes\Filter($builder)->apply();
    }

    public static function getResource()
    {
        $query = self::Filter();

        $paginate = getRequestPaginate();

        $data = $paginate !== false
            ? $query->paginate($paginate)
            : $query->get();

        return self::getGuessNames('resource')
            ? self::getGuessNames('resource')::collection($data)
            : $data->toResourceCollection();
    }

    public static function randomOrCreate(array $attributes = [])
    {
        return self::count() > 0
            ? self::all()->random()
            : self::factory()->create($attributes);
    }

    private static function getClassKnowingFolderAndEnding(string $namespace, string $class, string $ending = ''): string|bool
    {
        if (class_exists($namespace . '\\' . $class . $ending))
            return $namespace . '\\' . $class . $ending;

        if (class_exists($namespace . '\\' . $class))
            return $namespace . '\\' . $class;

        return false;
    }
}
