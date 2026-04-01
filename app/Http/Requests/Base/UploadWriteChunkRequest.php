<?php

namespace App\Http\Requests\Base;

use Illuminate\Foundation\Http\FormRequest;

class UploadWriteChunkRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'max:' . return_bytes(config('filesystems.max_file_size')) / 1024]
        ];
    }
}
