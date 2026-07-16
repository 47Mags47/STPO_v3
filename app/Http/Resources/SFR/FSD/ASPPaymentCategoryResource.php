<?php

namespace App\Http\Resources\SFR\FSD;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ASPPaymentCategoryResource extends JsonResource
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
            'sfr_category' => [
                'id' => $this->SFRCategory->id,
                'name' => $this->SFRCategory->name,
                'pay_number' => $this->SFRCategory->pay_number,
            ]
        ];
    }
}
