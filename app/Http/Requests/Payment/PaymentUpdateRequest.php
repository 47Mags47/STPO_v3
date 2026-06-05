<?php

namespace App\Http\Requests\Payment;

use App\Models\FSD\Payment;
use Illuminate\Foundation\Http\FormRequest;

class PaymentUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code'  => ['required', 'string', 'max:255', 'unique:'. Payment::class .',code,' . $this->route('payment')->id],
            'name'  => ['required', 'string', 'max:255', 'unique:'. Payment::class .',name,' . $this->route('payment')->id],
            'kbk'   => ['required', 'string', 'regex:/[0-9]{20}/'],
        ];
    }
}
