<?php

namespace App\Http\Requests\Veteran;

use Illuminate\Foundation\Http\FormRequest;

class DateStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'in_date'       => ['required', 'date', 'after:today'],
            'is_active'     => ['required', 'boolean']
        ];
    }
}
