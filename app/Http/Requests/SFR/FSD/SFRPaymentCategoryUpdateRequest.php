<?php

namespace App\Http\Requests\SFR\FSD;

use Illuminate\Foundation\Http\FormRequest;

class SFRPaymentCategoryUpdateRequest extends FormRequest
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
            'pay_number'    => ['required', 'string', 'min:1', 'max:255']
        ];
    }
}
