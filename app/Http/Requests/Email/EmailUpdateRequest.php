<?php

namespace App\Http\Requests\Email;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Base\User;

class EmailUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique(User::class, 'email')->ignore($user->id)
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'Введите email адрес.',
            'email.email'       => 'Введите корректный email адрес.',
            'email.max'         => 'Email адрес слишком длинный.',
            'email.unique'      => 'Этот email уже используется.',
        ];
    }
}
