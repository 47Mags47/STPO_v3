<?php

namespace App\Http\Requests\Appeal;

use App\Models\Appeal\Theme;
use Illuminate\Foundation\Http\FormRequest;

class AppealStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'theme_id' => ['required', 'exists:' . Theme::class .',id'],
            'comment' => ['required', 'string', 'min:1', 'max:255']
        ];
    }
}
