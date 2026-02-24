<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModulGroupResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'moduls' => $this->moduls->map(fn($modul) => [
                'id' => $modul->id,
                'name' => $modul->name,
                'route_name' => $modul->route_name,
            ]),
        ];
    }
}
