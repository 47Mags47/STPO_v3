<?php

namespace App\Http\Resources\SFR\FSD;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SFRFileResource extends JsonResource
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
            'date_start'    => $this->date_start,
            'date_end'      => $this->date_end,
            'file'          => $this->file->toResource(),
        ];
    }
}
