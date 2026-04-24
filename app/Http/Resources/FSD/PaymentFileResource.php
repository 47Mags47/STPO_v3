<?php

namespace App\Http\Resources\FSD;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentFileResource extends JsonResource
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
            'file' => [
                'name' => $this->file->origin_name,
            ],
            'payments' => [
                'count' => $this->payments()->count()
            ],
            'type' => [
                'name' => $this->type->name,
                'pay_code' => $this->type->pay_code,
            ],
            'in_month' => $this->in_month->translatedFormat('F Y'),
        ];
    }
}
