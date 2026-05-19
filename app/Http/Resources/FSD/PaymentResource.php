<?php

namespace App\Http\Resources\FSD;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'SNILS' => $this->SNILS,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'payment' => [
                'in_month' => $this->PaymentFile->in_month,
                'name' => $this->PaymentFile->type->name,
                'code' => $this->PaymentFile->type->pay_code,
            ],
        ];
    }
}
