<?php

namespace App\Http\Requests\Appeal;

use App\Models\Appeal\ThemGroup;
use Illuminate\Foundation\Http\FormRequest;

class ThemStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:1', 'max:255'],
            'group_id' => ['required', 'exists:' . ThemGroup::class . ',id']
        ];
    }
}
