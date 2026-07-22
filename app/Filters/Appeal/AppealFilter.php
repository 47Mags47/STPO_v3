<?php

namespace App\Filters\Appeal;

use App\Classes\Filter;

class AppealFilter extends Filter
{
    public function statusIds(array $ids){
        return $this->builder->whereIn('status_id', $ids);
    }

    public function themIds(array $ids){
        return $this->builder->whereIn('them_id', $ids);
    }

    public function senderIds(array $ids){
        return $this->builder->whereIn('sender_id', $ids);
    }

    public function createdAt(array $date)
    {
        $from = $date['_from'] ?? null;
        $to   = $date['_to'] ?? null;

        if ($from && $to) {
            return $this->builder->whereBetween('created_at', [$from, $to]);
        }

        if ($from) {
            return $this->builder->whereDate('created_at', '>=', $from);
        }

        if ($to) {
            return $this->builder->whereDate('created_at', '<=', $to);
        }

        return $this->builder;
}
}
