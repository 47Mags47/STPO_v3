<?php

namespace App\Http\Requests\Base;

use App\Models\Base\UploadFile;
use Illuminate\Foundation\Http\FormRequest;

class ChatMessageStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'message' => [
                'nullable',
                'required_without:files',
                'string',
                'max:25000',
            ],

            'files' => [
                'nullable',
                'required_without:message',
            ],

            'files.*' => [
                'exists:' . UploadFile::class . ',id'
            ]
        ];
    }
}
