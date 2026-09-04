<?php

namespace App\Http\Requests\Appeal;

use App\Models\Appeal\ThemGroup;
use App\Models\Appeal\Them;
use App\Models\Base\User;
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
            'group'   => ['required', 'exists:'  . ThemGroup::class . ',id'],
            'theme' => ['required', 'exists:' . Them::class .',id'],
            'comment' => ['required', 'string', 'min:1', 'max:255']
        ];
    }
}
