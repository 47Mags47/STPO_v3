<?php

namespace App\Http\Requests\Base;

use App\Models\ModulGroup;
use Illuminate\Foundation\Http\FormRequest;

class ModulGroupStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'min:1', 'max:255', 'unique:' . ModulGroup::class . ',code'],
            'name' => ['required', 'string', 'min:1', 'max:255']
        ];
    }
}
