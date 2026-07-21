<?php

namespace App\Http\Resources\Payment;

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
            'id'                => $this->id,
            'recipients_count'  => $this->recipients()->count(),
            'amount'            => $this->recipients()->sum('amount'),
            'file'              => $this->file->toResource(),
            'bank'              => $this->bank->toResource(),
            'division'          => $this->division->toResource(),
            'payment'           => $this->event->payment->toResource(),
        ];
    }
}
