<?php

namespace App\Http\Requests\Veteran;

use App\Models\Auth\Permission;
use App\Models\Auth\PermissionGroup;
use App\Models\Base\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccessDestroyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id'       => ['required', 'exists:' . User::class . ',id'],
            'permission_id' => [
                'required',
                Rule::exists(Permission::class, 'id')
                    ->where('group_id', PermissionGroup::byCode('veteran')->id)
            ]
        ];
    }
}
