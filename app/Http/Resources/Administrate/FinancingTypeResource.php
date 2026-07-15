<?php

namespace App\Http\Resources\Administrate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FinancingTypeResource extends JsonResource
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
            'asp_name' => $this->asp_name,
            'sfr_fsd_code' => $this->sfr_fsd_code,
        ];
    }
}
