<?php

namespace App\Http\Requests\Administrate;

use Illuminate\Foundation\Http\FormRequest;

class FinancingTypeUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'          => ['required', 'string', 'min:1', 'max:255'],
            'sfr_fsd_code'  => ['required', 'string', 'min:1', 'max:255'],
            'asp_name'      => ['required', 'string', 'min:1', 'max:255'],
        ];
    }
}
