<?php

namespace App\Http\Resources\Base;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Auth\Role;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"                => $this->id,
            'first_name'        => $this->first_name,
            'last_name'         => $this->last_name,
            'middle_name'       => $this->middle_name,
            'full_name'         => $this->full_name,
            'phone'             => $this->phone,
            'phone_dob'         => $this->phone_dob,
            'login'             => $this->login,
            'email'             => $this->email,
            'divisions'         => $this->divisions->map(fn($division) => [
                'id'    => $division->id,
                'name'  => $division->name,
                'role'  => [
                    'id'    => $division->pivot?->role_id,
                    'name' => Role::roleById($division->pivot?->role_id)?->name
                ]
            ]),
        ];
    }
}
