<?php

namespace App\Http\Requests\FSD;

use App\Models\Base\UploadFile;
use Illuminate\Foundation\Http\FormRequest;

class PaymentFileStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'upload_file_id'    => ['required', 'exists:' . UploadFile::class . ',id'],
            'date_start'        => ['required', 'date'],
            'date_end'          => ['required', 'date'],
        ];
    }
}
