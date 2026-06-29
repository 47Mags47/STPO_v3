<?php

namespace App\Http\Resources\FSD;

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
            'file' => [
                'name'      => $this->origin_name,
                'errors'    => $this->errors,
            ],
            'date_start'    => $this->date_start,
            'date_end'      => $this->date_end,
            'upload_at'     => $this->created_at
        ];
    }
}
