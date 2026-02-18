<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name'        => ['required', 'string', 'min:2', 'max:255'],
            'last_name'         => ['nullable', 'string', 'max:255'],
            'middle_name'       => ['nullable', 'string', 'max:255'],
            'full_name'         => ['required', 'string', 'min:2', 'max:255'],
            'phone'             => ['nullable', 'string', 'regex:/\+7 \([0-9]{3}\) [0-9]{3} [0-9]{2}-[0-9]{2}/'],
            'phone_dob'         => ['nullable', 'string', 'max:10'],
            'login'             => ['required', 'string', 'min:2', 'max:255', 'unique:' . User::class . ',login'],
            'email'             => ['required', 'email', 'unique:' . User::class . ',enail'],
            'password'          => ['required', 'string', 'min:4', 'max:255', 'confirmed'],
        ];
    }
}
