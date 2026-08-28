<?php

namespace App\Http\Requests\Administrate;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Administrate\City;
use Illuminate\Validation\Rule;

class CityUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'max:255', Rule::unique(City::class, 'name')->ignore($this->route('city'))],
        ];
    }
}
