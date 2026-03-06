<?php

namespace App\Http\Requests\FSD;

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
            'file' => ['required', 'file']
        ];
    }
}
