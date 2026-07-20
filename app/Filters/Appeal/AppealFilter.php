<?php

namespace App\Filters\Appeal;

use App\Classes\Filter;

class AppealFilter extends Filter
{
    public function statusIds(array $ids){
        return $this->builder->whereIn('status_id', $ids);
    }
}
