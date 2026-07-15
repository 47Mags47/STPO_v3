<?php

namespace App\Http\Requests\SFR\FSD;

use App\Models\SFR\FSD\SFRPaymentCategory;
use Illuminate\Foundation\Http\FormRequest;

class ASPPaymentCategoryUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:1', 'max:255'],
            'sfr_payment_category_id' => ['required', 'exists:' . SFRPaymentCategory::class . ',id']
        ];
    }
}
