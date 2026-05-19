<?php

namespace App\Http\Requests\FSD;

use App\Models\Base\UploadFile;
use Illuminate\Foundation\Http\FormRequest;

class TransitFileStoreReqouest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file_id'       => ['required', 'exists:' . UploadFile::class . ',id'],
            'date_start'    => ['required', 'date', 'after:date_and'],
            'date_end'      => ['required', 'date', 'after:date_start'],
        ];
    }
}
