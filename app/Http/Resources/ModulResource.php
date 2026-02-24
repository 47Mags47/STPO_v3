<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModulResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'route_name' => $this->route_name,
            'creator' => [
                'full_name' => $this->creator?->full_name
            ],
            'group' => [
                'id' => $this->group->id,
            ]
        ];
    }
}
