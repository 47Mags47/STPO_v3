<?php

namespace App\Http\Resources\Payment;

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
            'id'            => $this->id,
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'middle_name'   => $this->middle_name,
            'd_rojd'        => $this->d_rojd,
            'SNILS'         => $this->SNILS,
            'account'       => $this->account,
            'amount'        => $this->amount,
            'p_series'      => $this->p_series,
            'p_number'      => $this->p_number,
            'p_date'        => $this->p_date,
            'p_div'         => $this->p_div,
        ];
    }
}
