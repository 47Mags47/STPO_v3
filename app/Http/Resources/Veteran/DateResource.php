<?php

namespace App\Http\Resources\Veteran;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'in_date'      => $this->in_date,
            'is_active' => $this->is_active,
        ];
    }
}
