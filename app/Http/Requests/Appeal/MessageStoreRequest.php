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
            'message' => [
                'nullable',
                'required_without:file',
                'string',
                'max:25000',
            ],

            'file' => [
                'nullable',
                'required_without:message',
                'file',
                'max:2048',
            ],
        ];
    }
}
