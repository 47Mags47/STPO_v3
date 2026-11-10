<?php

namespace App\Http\Requests\Veteran;

use App\Models\Administrate\Division;
use App\Models\Auth\Permission;
use App\Models\Base\User;
use Illuminate\Foundation\Http\FormRequest;

class AccessStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'division_id'   => ['required', 'exists:' . Division::class . ',id'],
            'user_id'       => ['required', 'exists:' . User::class . ',id'],
            'permission_id' => ['required', 'exists:' . Permission::class . ',id']
        ];
    }
}
