<?php

namespace App\Http\Requests\Payment;

use App\Models\Payment\Bank;
use Illuminate\Foundation\Http\FormRequest;

class BankStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code'  => ['required', 'string', 'max:255', 'unique:'. Bank::class .',code'],
            'name'  => ['required', 'string', 'max:255'],
        ];
    }
}
