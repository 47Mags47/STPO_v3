<?php

namespace App\Http\Resources\SFR\FSD;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransitFileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'file' => $this->file->toResource(),
            'created_at' => $this->created_at
        ];
    }
}
