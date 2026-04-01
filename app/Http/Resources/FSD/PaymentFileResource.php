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
            'file' => [
                'name' => $this->file->origin_name,
            ],
            'payments' => [
                'count' => $this->payments->count()
            ],
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
        ];
    }
}
