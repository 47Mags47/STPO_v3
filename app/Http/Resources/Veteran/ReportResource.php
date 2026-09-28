<?php

namespace App\Http\Resources\Veteran;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'start_at'      => $this->start_at,
            'is_active'     => $this->is_active,

            'amount'        => $this->records->sum('amount'),
            'online_form'   => $this->records->sum('online_form'),
            'MFC'           => $this->records->sum('MFC'),

            'deleted_at'    => $this->deleted_at
        ];
    }
}
