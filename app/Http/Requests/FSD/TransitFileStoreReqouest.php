<?php

namespace App\Http\Requests\FSD;

use App\Models\Base\UploadFile;
use Illuminate\Foundation\Http\FormRequest;

class TransitFileStoreReqouest extends FormRequest
{
    public function rules(): array
    {
        return [
            'upload_file_id' => ['required', 'exists:' . UploadFile::class . ',id']
        ];
    }
}
