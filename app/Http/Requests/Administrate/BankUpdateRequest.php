<?php

namespace App\Http\Requests\Administrate;

use App\Models\Administrate\Bank;
use Illuminate\Foundation\Http\FormRequest;

class BankUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code'      => ['required', 'string', 'max:255', 'unique:'. Bank::class .',code,' . $this->route('bank')->id],
            'name'      => ['required', 'string', 'max:255'],
            'number'    => ['required', 'string', 'max:15']
        ];
    }
}
