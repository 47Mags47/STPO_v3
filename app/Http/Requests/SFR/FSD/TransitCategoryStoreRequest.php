<?php

namespace App\Http\Requests\SFR\FSD;

use App\Models\SFR\FSD\TransitCategory;
use Illuminate\Foundation\Http\FormRequest;

class TransitCategoryStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'wp_category_id' => ['required', 'unique:'. TransitCategory::class .',wp_category_id'],
            'name'              => ['required', 'string', 'min:1', 'max:255']
        ];
    }
}
