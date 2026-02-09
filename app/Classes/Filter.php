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
        return $this->builder->where(function ($query) {
            if (Schema::hasColumn($this->builder->getModel()->getTableName(), 'id'))
                $query->orWhere('id', $this->request->input('search'));

            if (Schema::hasColumn($this->builder->getModel()->getTableName(), 'code'))
                $query->orWhereLike('code', $this->request->input('search'));

            if (Schema::hasColumn($this->builder->getModel()->getTableName(), 'name'))
                $query->orWhereLike('name', $this->request->input('search'));
        });
    }

    public function filter()
    {
        $this->builder->where(function () {
            foreach ($this->request->input('filter') as $method => $value) {
                if (method_exists($this, $method)) {
                    $methodName = Str::camel($method);

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
        if ($this->request->has('filter'))
            $this->filter();

        if ($this->request->has('search'))
            $this->search();

        return $this->builder;
    }
}
