<?php

namespace App\Http\Resources\SFR\FSD;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransitEquivalentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'equivalent' => $this->equivalent,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name
            ],
        ];
    }
}
