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
        //DEV Переделать на required_unless
        return [

            'message' => ['required_if:file, null', 'string', 'max:25000'],
            'file' => ['required_if:message, null', 'file', 'max:2048'],
        ];
    }
}
