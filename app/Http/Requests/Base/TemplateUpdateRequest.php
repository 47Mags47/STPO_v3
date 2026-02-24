<?php

namespace App\Http\Requests\Base;

use App\Models\TemplateStyle;
use App\Models\TemplateType;
use Illuminate\Foundation\Http\FormRequest;

class TemplateUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'      => ['required', 'string', 'min:1', 'max:255'],
            'style_id'  => ['required', 'exists:'. TemplateStyle::class .',id'],
            'type_id'  => ['required', 'exists:'. TemplateType::class .',id'],
            'chunk'     => ['nullable', 'integer'],
        ];
    }
}
