<?php

namespace App\Http\Requests\SFR\FSD;

use App\Models\Base\UploadFile;
use Illuminate\Foundation\Http\FormRequest;

class SFRFileStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file_id'       => ['required', 'exists:' . UploadFile::class . ',id'],
            'in_date'       => ['required', 'date']
        ];
    }
}
