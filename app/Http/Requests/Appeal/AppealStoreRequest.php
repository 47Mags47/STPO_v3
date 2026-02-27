<?php

namespace App\Http\Requests\Appeal;

use App\Models\Appeal\Them;
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
            'office' => ['nullable', 'string', 'min:1', 'max:10'],
            'comment' => ['required', 'string', 'min:1', 'max:255'],
            'them_id' => ['required', 'exists:'. Them::class .',id'],
        ];
    }
}
