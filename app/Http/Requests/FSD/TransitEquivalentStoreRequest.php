<?php

namespace App\Http\Requests\FSD;

use App\Models\FSD\TransitCategory;
use Illuminate\Foundation\Http\FormRequest;

class TransitEquivalentStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id'   => ['required', 'exists:'. TransitCategory::class .',id'],
            'equivalent'    => ['required', 'decimal:0,2'],
            'date_start'    => ['required', 'date'],
            'date_end'      => ['required', 'date'],
        ];
    }
}
