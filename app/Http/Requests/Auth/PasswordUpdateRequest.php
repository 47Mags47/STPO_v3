<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class PasswordUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'current_password'  => ['required', 'current_password'],
            'new_password'      => ['required', 'string', 'min:4', 'max:255', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required'         => 'Введите текущий пароль.',
            'current_password.current_password' => 'Текущий пароль указан неверно.',

            'new_password.required'             => 'Введите новый пароль.',
            'new_password.string'               => 'Пароль должен быть строкой.',
            'new_password.min'                  => 'Новый пароль должен содержать не менее :min символов.',
            'new_password.max'                  => 'Новый пароль не должен превышать :max символов.',
            'new_password.confirmed'            => 'Пароли не совпадают.',
        ];
    }
}
