<?php

namespace App\Http\Resources\SFR\FSD;

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
            'file'          => $this->file->toResource(),
            'payments' => [
                'count' => $this->payments()->count()
            ],
            'in_date' => $this->in_date->translatedFormat('F Y'),
        ];
    }
}
