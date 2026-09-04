<?php

namespace App\Http\Requests\Administrate;

use App\Models\Administrate\Payment;
use Illuminate\Foundation\Http\FormRequest;

class PaymentStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code'  => ['required', 'string', 'max:255', 'unique:'. Payment::class .',code'],
            'name'  => ['required', 'string', 'max:255', 'unique:'. Payment::class .',name'],
            'kbk'   => ['required', 'string', 'regex:/[0-9]{20}/'],
        ];
    }
}
