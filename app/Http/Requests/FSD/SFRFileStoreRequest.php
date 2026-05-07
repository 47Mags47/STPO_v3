<?php

namespace App\Http\Requests\FSD;

use App\Models\Base\UploadFile;
use Illuminate\Foundation\Http\FormRequest;

class SFRFileStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file_ids'          => ['required', 'array'],
            'file_ids.*'        => ['exists:' . UploadFile::class . ',id'],
        ];
    }
}
