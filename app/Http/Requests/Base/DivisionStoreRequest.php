<?php

namespace App\Http\Requests\Base;

use App\Models\Division;
use Illuminate\Foundation\Http\FormRequest;

class DivisionStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'min:3', 'max:255', 'unique:' . Division::class . ',name']
        ];
    }
}
