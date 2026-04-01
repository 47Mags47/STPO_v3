<?php

namespace App\Http\Requests\Base;

use Illuminate\Foundation\Http\FormRequest;

class UploadStartUploadRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'origin_name' => ['required', 'string', 'max:255'],
            'file_size' => ['required', 'integer', 'min:0']
        ];
    }
}
