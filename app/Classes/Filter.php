<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class Filter
{
    protected Request $request;
    protected Builder $builder;

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
        $this->request = request();
    }

    public function search()
    {
        if (!$this->request->has('search') or $this->request->input('search') === null or $this->request->input('search') === '')
            return $this->builder;

        return $this->builder->where(function ($query) {
            $model = $query->getModel();

            foreach ($model->searchCollumns as $collumn) {
                if (Schema::hasColumn($model->getTableName(), $collumn))
                    $query->orWhereLike($collumn, '%' . $this->request->input('search') . '%');
            }
        });
    }

    public function sort()
    {
        if (request()->has('sort')) {
            $this->builder->reorder();
            $sort = request()->input('sort');
            if (is_string($sort))
                $this->builder = $this->builder->reorder($sort);
            if (is_array($sort))
                foreach ($sort as $collumn => $desk) {
                    $this->builder = $this->builder->reorder($collumn, $desk);
                }
        }
    }

    public function filter()
    {
        $this->builder->where(function () {
            foreach ($this->request->input('filters') as $method => $value) {
                $methodName = Str::camel($method);

                if (method_exists($this, $methodName)) {
                    $this->{$methodName}($value);
                } else {
                    if (Schema::hasColumn($this->builder->getModel()->getTableName(), $method))
                        if (is_string($value))
                            $this->builder->whereLike($method, $value);
                        else if (is_array($value))
                            $this->builder->whereIn($method, $value);
                        else
                            $this->builder->where($method, $value);
                }
            }
        });
    }

    public function apply(): Builder
    {
        if ($this->request->has('search'))
            $this->search();

        if ($this->request->has('filters'))
            $this->filter();

        if ($this->request->has('sort'))
            $this->sort();

        return $this->builder;
    }
}
