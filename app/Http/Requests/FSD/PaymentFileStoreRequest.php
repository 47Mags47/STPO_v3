<?php

namespace App\Http\Requests\FSD;

use App\Models\Base\UploadFile;
use App\Models\FSD\PaymentType;
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
            'in_month'          => ['required', 'date'],
            'file_ids'          => ['required', 'array'],
            'file_ids.*'        => ['exists:' . UploadFile::class . ',id'],
            'type_id'           => ['required', 'exists:' . PaymentType::class . ',id'],
        ];
    }
}
