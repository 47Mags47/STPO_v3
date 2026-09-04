<?php

namespace App\Http\Requests\Payment;

use App\Models\Administrate\Bank;
use App\Models\Base\UploadFile;
use Illuminate\Foundation\Http\FormRequest;

class PaymentFileStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'bank_id' => ['required', 'exists:' . Bank::class . ',id'],
            'file_ids' => ['required', 'array'],
            'file_ids.*' => ['exists:' . UploadFile::class . ',id'],
        ];
    }
}
