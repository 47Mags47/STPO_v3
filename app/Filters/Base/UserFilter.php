<?php

namespace App\Filters\Base;

use App\Classes\Filter;
use App\Models\Administrate\Division;

class UserFilter extends Filter
{
    public function division(int $id)
    {
        $this->builder->whereHas('divisions', fn($query) => $query->whereKey($id));
    }

    public function divisionIds(array $ids)
    {
        $this->builder->where(function ($query) use ($ids) {
            $query->whereHas('divisions', fn($query) => $query->whereIn(Division::getTableName() . '.id', $ids));
        });
    }
}
