<?php

namespace App\Http\Resources\Payment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BankResource extends JsonResource
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
            'number' => $this->number,
            'payment-files' => [
                'count' => $request->event !== null
                    ? $this->paymentFilesFromEvent($request->event)->count()
                    : $this->payment_paymentFiles()->count(),
                'division_count' => $request->event !== null
                    ? $this->paymentFilesFromEvent($request->event)->get('division_id')->pluck('division_id')->unique()->count()
                    : $this->payment_paymentFiles->groupBy('division_id')->count()
            ]
        ];
    }
}
