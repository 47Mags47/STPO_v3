<?php

namespace App\Http\Resources\Appeal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThemeGROUPBYGroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'group' => $this->toResource(),
            'themes' => $this->themes->toResourceCollection()
        ];
    }
}
