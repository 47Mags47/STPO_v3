<?php

namespace App\Http\Requests\Base;

use App\Models\ModulGroup;
use Illuminate\Foundation\Http\FormRequest;

class ModulUpdateRequest extends FormRequest
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
            'route_name' => ['required', 'string', 'min:1', 'max:255'],
            'group_id' => ['required', 'exists:' . ModulGroup::class . ',id']
        ];
    }
}
