<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
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
            'moduls' => $this->moduls->map(fn($modul) => [
                'name' => $modul->name,
                'route_name' => $modul->route_name,
            ]),
        ];
    }
}
