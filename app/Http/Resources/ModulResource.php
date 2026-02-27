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
            'id' => $this->id,
            'name' => $this->name,
            'route_name' => $this->route_name,
            'creator' => $this->creator !== null
                ? [
                    'full_name' => $this->creator->full_name
                ]
                : null,
            'group' => [
                'id' => $this->group->id,
                'name' => $this->group->name,
            ]
        ];
    }
}
