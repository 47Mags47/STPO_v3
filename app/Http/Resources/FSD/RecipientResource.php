<?php

namespace App\Http\Resources\FSD;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'division_code' => $this->division_code,
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'middle_name'   => $this->middle_name,
            'SNILS'         => $this->SNILS,
            'status' => [
                'code' => $this->status->code,
                'name' => $this->status->name,
            ],
        ];
    }
}
