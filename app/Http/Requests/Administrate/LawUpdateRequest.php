<?php

namespace App\Http\Requests\Administrate;

use Illuminate\Foundation\Http\FormRequest;

class LawUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'number'        => ['required', 'string', 'min:1', 'max:255'],
            'name'          => ['required', 'string', 'min:1', 'max:255'],
        ];
    }
}
