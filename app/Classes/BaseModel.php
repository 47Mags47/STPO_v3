<?php

namespace App\Classes;

use App\Traits\ModelMethods;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;

abstract class BaseModel extends Model
{
    use ModelMethods;

    public array $searchCollumns = [
        'code',
        'name',
        'number'
    ];

    ### SCOPES
    ##################################################
    /**
     * Возвращает отфильтрованный и отсортированный ресурс
     *
     * @param Builder $query
     * @param string $order
     * @param boolean|null $withTrashed
     * @return ResourceCollection Отфильтрованный и отсортированный ресурс
     */
    public static function scopeGetResource(
        Builder $query,
        string|array|null $order = 'id',
        ?bool $withTrashed = false,
        ?int $paginate = 25,
        ?string $resource = null
    ): ResourceCollection {
        if ($withTrashed)
            $query = $query->withTrashed();

        // search, filters and sort
        $query = $query->sort($order);
        $query = $query->filter();

        // paginate
        $queryResult = $paginate !== null
            ? $query->paginate($paginate)
            : $query->get();

        // resource
        if ($resource !== null)
            return $resource::collection($queryResult);
        else
            return self::getGuessNames('resource')
                ? self::getGuessNames('resource')::collection($queryResult)
                : $queryResult->toResourceCollection();
    }

    public static function scopeFilter(Builder $builder): Builder
    {
        return self::getGuessNames('filter')
            ? new (self::getGuessNames('filter'))($builder)->apply()
            : new \App\Classes\Filter($builder)->apply();
    }

    public static function scopeSort(Builder $builder, string|array|null $order = 'id'): Builder
    {
        if(is_array($order))
            foreach ($order as $column => $value) {
                if(is_string($column))
                    $builder->orderBy($column, $value);
                else
                    $builder->orderBy($value);
            }

        if(is_string($order))
            $builder->orderBy($order);

        return $builder;
    }

    ### Методы
    ##################################################
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
            'filter'            => self::getClassKnowingFolderAndEnding('App\\Filters', $relativeNamespace, 'Filter'),
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

        if (!file_exists($path))
            return false;

        if (class_exists($namespace . '\\' . $class . $ending))
            return $namespace . '\\' . $class . $ending;

        if (class_exists($namespace . '\\' . $class))
            return $namespace . '\\' . $class;

        return false;
    }
}
