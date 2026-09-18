<?php

namespace App\Http\Requests\Administrate;

use App\Models\Administrate\Bank;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BankUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code'      => ['required', 'string', 'max:255', Rule::unique(Bank::class, 'code')->ignore($this->route('bank'))],
            'name'      => ['required', 'string', 'max:255'],
            'number'    => ['required', 'string', 'max:15']
        ];
    }
}
