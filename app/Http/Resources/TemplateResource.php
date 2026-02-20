<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TemplateResource extends JsonResource
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
            'chunk' => $this->chunk,
            'type' => [
                'id' => $this->type->id,
                'code' => $this->type->code,
                'name' => $this->type->name,
            ],
            'style' => [
                'id' => $this->style->id,
                'code' => $this->style->code,
                'name' => $this->style->name,
            ],
        ];
    }
}
