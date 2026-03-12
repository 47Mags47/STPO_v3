<?php

namespace App\Http\Requests\Appeal;

use Illuminate\Foundation\Http\FormRequest;

class MessageStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'message' => ['required_unless:file', 'string', 'max:25000'],
            'file' => ['required_unless:message', 'file', 'max:2048'],
        ];
    }
}
