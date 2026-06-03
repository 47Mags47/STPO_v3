<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class PaymentStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code'  => ['required', 'string', 'max:255'],
            'name'  => ['required', 'string', 'max:255'],
            'kbk'   => ['required', 'string', 'regex:/[0-9]{20}/'],
        ];
    }
}
