<?php

namespace App\Http\Requests\Auth;

use App\Models\Administrate\Division;
use Illuminate\Foundation\Http\FormRequest;

class SelectDivisionStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'division_id' => ['required', 'exists:' . Division::class . ',id'],
        ];
    }
}
