<?php

namespace App\Http\Requests\SFR\FSD;

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
            'in_date'           => ['required', 'date'],
            'file_ids'          => ['required', 'array'],
            'file_ids.*'        => ['exists:' . UploadFile::class . ',id'],
        ];
    }
}
