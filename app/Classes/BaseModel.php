<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use ReflectionClass;

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

        $namespace_parts = explode('\\', $modelClass);
        $path = Str::before($modelClass, 'Models') . 'Models';

        $class_name = end($namespace_parts);
        $class_path = Str::before($relativeNamespace, '\\' . $class_name);

        $names = [
            'class'             => $modelClass,
            'className'         => $relativeNamespace,
            'path'              => $path,
            'factory'           => self::getClassKnowingFolderAndEnding('Database\\Factories', $relativeNamespace, 'Factory'),
            'localSeeder'       => self::getClassKnowingFolderAndEnding('Database\\Seeders\\Local', $relativeNamespace, 'Seeder'),
            'prodSeeder'        => self::getClassKnowingFolderAndEnding('Database\\Seeders\\Prod', $relativeNamespace, 'Seeder'),
            'filter'            => self::getClassKnowingFolderAndEnding('App\\Filters', $relativeNamespace, 'Filter'),
            'controller'        => self::getClassKnowingFolderAndEnding('App\\Http\\Controllers', $relativeNamespace, 'Controller'),
            'policy'            => self::getClassKnowingFolderAndEnding('App\\Policies', $relativeNamespace, 'Policy'),
            'storeRequest'      => self::getClassKnowingFolderAndEnding('App\\Http\\Requests', $class_path . '\\' . $class_name . 'Store', 'Request'),
            'updateRequest'     => self::getClassKnowingFolderAndEnding('App\\Http\\Requests', $class_path . '\\' . $class_name . 'Update', 'Request'),
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

    public static function getResource(string|array|null $order = 'id', ?string $orderDesc = 'asc')
    {
        $query = self::Filter();

        if (is_array($order))
            foreach ($order as $key => $value) {
                if (is_string($key))
                    $query->orderBy($key, $value);
                else
                    $query->orderBy($value, 'asc');
            }
        else
            $query->orderBy($order, $orderDesc);

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
        $path = base_path($namespace . '\\' . $class . $ending);
        $path = str_replace('\\', '/', $path);
        $path = str_replace('/App/', '/app/', $path);
        $path = $path . '.php';

        if (class_exists($namespace . '\\' . $class . $ending))
            return $namespace . '\\' . $class . $ending;

        if (class_exists($namespace . '\\' . $class))
            return $namespace . '\\' . $class;

        return false;
    }
}
