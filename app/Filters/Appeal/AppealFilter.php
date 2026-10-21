<?php

namespace App\Filters\Appeal;

use App\Classes\Filter;
use Carbon\Carbon;

class AppealFilter extends Filter
{
    public function statusIds(array $ids)
    {
        return $this->builder->whereIn('status_id', $ids);
    }

    public function themIds(array $ids)
    {
        return $this->builder->whereIn('them_id', $ids);
    }

    public function senderIds(array $ids)
    {
        return $this->builder->whereIn('sender_id', $ids);
    }

    public function createdAt(array $date)
    {
        $from = isset($date['_from'])
            ? Carbon::parse($date['_from'])
            : null;

        $to = isset($date['_to'])
            ? Carbon::parse($date['_to'])
            : null;

        if ($from && $to) {
            return $this->builder->whereBetween('created_at', [
                $from->startOfDay(),
                $to->endOfDay(),
            ]);
        }

        if ($from) {
            return $this->builder->where('created_at', '>=', $from->startOfDay());
        }

        if ($to) {
            return $this->builder->where('created_at', '<=', $to->endOfDay());
        }

        return $this->builder;
    }
}
