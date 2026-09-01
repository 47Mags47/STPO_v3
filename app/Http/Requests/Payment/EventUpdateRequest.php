<?php

namespace App\Http\Requests\Payment;

use App\Models\Administrate\Payment;
use Illuminate\Foundation\Http\FormRequest;

class EventUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'payment_id'    => ['required', 'exists:' . Payment::class . ',id'],
            'in_date'        => ['required', 'date_format:Y-m-d'],
        ];
    }
}
